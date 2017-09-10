<?php
/**
 * Created by PhpStorm.
 * User: cosmin.caloian
 * Date: 9/10/2017
 * Time: 2:51 AM
 */

namespace AppBundle\Service;


class MessageRequestService
{
    public static function computeMessageCacheKey(array $message)
    {
        return sha1($message['timestamp'] . json_encode($message['data']));
    }
}