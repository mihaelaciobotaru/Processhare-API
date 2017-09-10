<?php

namespace AppBundle\Service;

class MessageRequestService
{
    public static function computeMessageCacheKey(array $message)
    {
        return sha1($message['timestamp'] . json_encode($message['data']));
    }
}
