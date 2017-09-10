<?php

namespace AppBundle\Service\Provider;

use AppBundle\Adapter\AMQPMessageAdapter;
use AppBundle\Service\MessageRequestService;
use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ORM\Cache\QueryCacheEntry;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSocketConnection;
use PhpAmqpLib\Message\AMQPMessage;

class DecoratorRabbitProvider implements ProviderInterface
{
    /** @var RabbitProvider $provider */
    private $provider;

    /** @var CacheProvider $cacheProvider */
    private $cacheProvider;

    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
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
        $message = $this->provider->getMessage();

        if ($message) {
            $key = MessageRequestService::computeMessageCacheKey($message);
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
        $this->cacheProvider->save($key . 'data', json_encode($message['data']));
    }
}
