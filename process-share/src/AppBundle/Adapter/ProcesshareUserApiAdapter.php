<?php
namespace AppBundle\Adapter;

use AppBundle\Entity\ProcesshareUser;

class ProcesshareUserApiAdapter
{
    public static function adapt(ProcesshareUser $processhareUser)
    {
        return [
            'username' => $processhareUser->getUsername(),
            'reward' => number_format($processhareUser->getReward(), 3)
        ];
    }
}