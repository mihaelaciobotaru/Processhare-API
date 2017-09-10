<?php
namespace AppBundle\Adapter;

use PhpAmqpLib\Message\AMQPMessage;

class AMQPMessageAdapter
{
    const DATA_KEY = 'data';
    const TIME_KEY = 'timestamp';

    /**
     * @param AMQPMessage $message
     * @return string
     */
    public static function adapt(AMQPMessage $message)
    {
        return [
            self::DATA_KEY => self::decode($message->getBody()),
            self::TIME_KEY => time()
        ];
    }

    /**
     * @param string $message
     * @return array
     */
    public static function decode(string $message) : array
    {
        return @json_decode($message, true);
    }
}