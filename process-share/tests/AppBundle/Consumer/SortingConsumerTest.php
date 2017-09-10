<?php
namespace Tests\AppBundle\Consumer;

use AppBundle\Consumer\SortingConsumer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;

class SortingConsumerTest extends TestCase
{
    public function testExecute()
    {
        $numbers = array(2, 5, 1, 3, 4, 9, 6, 7, 8, 10);
        $amqpMessage = $this->getAmqpMessageMock();
        $amqpMessage->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(
                json_encode($numbers)
            ));

        $sortService = $this->getSortServiceMock();
        $sortService->expects($this->once())
            ->method('sort')
            ->will($this->returnValue(array(1, 2, 3, 4, 5, 6, 7, 8, 9)));

        $consumer = new SortingConsumer();
        $consumer->setSortService($sortService);
        $this->assertEquals(ConsumerInterface::MSG_ACK, $consumer->execute($amqpMessage));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAmqpMessageMock()
    {
        $amqpMessage = $this->getMockBuilder('PhpAmqpLib\Message\AMQPMessage')
            ->disableOriginalConstructor()
            ->getMock();

        return $amqpMessage;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getSortServiceMock()
    {
        $sortService = $this->createMock('AppBundle\Service\SortService');

        return $sortService;
    }
}