<?php
namespace AppBundle\Consumer;


use AppBundle\Service\SortService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class SortingConsumer implements ConsumerInterface
{
    /**
     * @var SortService $sortService
     */
    private $sortService;

    /**
     * @param mixed $sortService
     */
    public function setSortService(SortService $sortService)
    {
        $this->sortService = $sortService;
    }

    /**
     * @inheritdoc
     */
    public function execute(AMQPMessage $msg)
    {
        $numbers = json_decode($msg->getBody(), true);
        $ordered = $this->sortService->sort($numbers);

        return ConsumerInterface::MSG_ACK;
    }
}