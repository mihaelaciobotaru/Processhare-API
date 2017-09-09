<?php
namespace AppBundle\Adapter;

use PhpAmqpLib\Message\AMQPMessage;

class AMQPMessageAdapter implements IAdapter
{
    /**
     * @param AMQPMessage $message
     * @return string
     */
    public static function adapt(AMQPMessage $message)
    {
        return $message->getBody();
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