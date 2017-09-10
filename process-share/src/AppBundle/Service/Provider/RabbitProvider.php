<?php

namespace AppBundle\Service\Provider;

use AppBundle\Adapter\AMQPMessageAdapter;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSocketConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitProvider implements ProviderInterface
{
    const HOST = 'host';
    const PORT = 'port';
    const USER = 'user';
    const PASSWORD = 'password';
    const VHOST = 'vhost';

    /** @var  string $connection */
    private $connection;

    /** @var  string $queueName */
    private $queueName;

    /**
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $vhost
     */
    public function setConnection(string $host, int $port, string $user, string $password, string $vhost)
    {
        $this->connection[self::HOST] = $host;
        $this->connection[self::PORT] = $port;
        $this->connection[self::USER] = $user;
        $this->connection[self::PASSWORD] = $password;
        $this->connection[self::VHOST] = $vhost;
    }

    /**
     * @param string $queueName
     */
    public function setQueueName(string $queueName)
    {
        $this->queueName = $queueName;
    }

    /**
     * @return array|null
     */
    public function getMessage()
    {
        $message = $this->getAMQPMessage();

        if (!$message) {
            return null;
        }

        return AMQPMessageAdapter::adapt($message);
    }

    /**
     * @return mixed
     */
    private function getAMQPMessage()
    {
        $connection = $this->createConnection();
        $connection->connectOnConstruct();
        $channel = $connection->channel();
        $amqpMessage = $channel->basic_get($this->queueName);

        if ($amqpMessage) {
            $channel->basic_ack($this->getDeliveryTag($amqpMessage));
        }

        return $amqpMessage;
    }

    /**
     * @param AMQPMessage $message
     * @return string
     */
    private function getDeliveryTag(AMQPMessage $message) : string
    {
        return $message->delivery_info['delivery_tag'];
    }

    /**
     * @return AMQPSocketConnection
     */
    private function createConnection() : AMQPSocketConnection
    {
        return new AMQPSocketConnection(
            $this->connection[self::HOST],
            $this->connection[self::PORT],
            $this->connection[self::USER],
            $this->connection[self::PASSWORD],
            $this->connection[self::VHOST]
        );
    }
}
