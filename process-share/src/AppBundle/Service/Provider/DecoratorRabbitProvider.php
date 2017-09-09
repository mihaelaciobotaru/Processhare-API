<?php

namespace AppBundle\Service\Provider;

use AppBundle\Adapter\AMQPMessageAdapter;
use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ORM\Cache\QueryCacheEntry;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSocketConnection;
use PhpAmqpLib\Message\AMQPMessage;

class DecoratorRabbitProvider implements ProviderInterface
{
    /** @var RabbitProvider $rabbitProvider */
    private $rabbitProvider;

    /** @var CacheProvider $cacheProvider */
    private $cacheProvider;

    public function __construct(RabbitProvider $rabbitProvider)
    {
        $this->rabbitProvider = $rabbitProvider;
    }

    public function setCacheProvider(CacheProvider $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        $message = $this->rabbitProvider->getMessage();
        if ($message) {
            $key = self::computeMessageCacheKey($message);
            $this->saveMessageToCache($key, $message);
        }

        return $message;
    }

    /**
     * @param string $key
     * @param array $message
     */
    public function saveMessageToCache(string $key, array $message)
    {
        $keys = $this->cacheProvider->fetch("keys");
        if (!is_array($keys)) {
            $keys = [];
        }

        array_push($keys, $key);
        $this->cacheProvider->save("keys", $keys);
        $this->cacheProvider->save($key . 'time', date('Y-m-d H:i:s'));
        $this->cacheProvider->save($key . 'data', json_encode($message));
    }

    /**
     * @param array $message
     * @return string
     */
    public static function computeMessageCacheKey(array $message)
    {
        return sha1((string) time() . json_encode($message));
    }
}
