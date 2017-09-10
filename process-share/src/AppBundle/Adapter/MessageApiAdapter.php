<?php
namespace AppBundle\Adapter;

use AppBundle\Entity\ProcesshareUser;
use AppBundle\Service\MessageRequestService;

class MessageApiAdapter
{
    public static function adapt(array $message)
    {
        return [
            'type' => array_rand(
                [
                    'less_than' => 'less_than',
                    'greater_than' => 'greater_than'
                ],
                1
            ),
            'data' => $message['data'],
            'request_id' => MessageRequestService::computeMessageCacheKey($message)
        ];
    }
}