<?php
namespace CommunicationBundle\Publish;

use OldSound\RabbitMqBundle\RabbitMq\Producer;

class SortingPublisher extends Producer
{
    /**
     * @param string $msgBody
     * @param string $routingKey
     * @param array $additionalProperties
     * @param array|null $headers
     */
    public function publish($msgBody, $routingKey = '', $additionalProperties = array(), array $headers = null)
    {
        // TODO
    }
}
