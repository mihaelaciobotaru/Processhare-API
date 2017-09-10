<?php
namespace Tests\AppBundle\Service;

use AppBundle\Service\MessageRequestService;
use PHPUnit\Framework\TestCase;

class MessageRequestServiceTest extends TestCase
{
    public function testComputeMessageCacheKey()
    {
        $message = array();
        $current = new \DateTime();
        $message['timestamp'] = $current->format('Y-m-d H:i:s');
        $message['data'] = array(1, 2, 3, 4, 5);
        $expected = sha1($message['timestamp'] . json_encode($message['data']));
        
        $service = new MessageRequestService();
        $this->assertEquals($expected, $service->computeMessageCacheKey($message));
    }
}