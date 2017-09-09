<?php
namespace AppBundle\Consumer;

use \OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use \PhpAmqpLib\Message\AMQPMessage;

class SortingConsumer implements ConsumerInterface
{
    /**
     * @inheritdoc
     */
    public function execute(AMQPMessage $msg)
    {
        // TODO: Implement execute() method.
    }
}
