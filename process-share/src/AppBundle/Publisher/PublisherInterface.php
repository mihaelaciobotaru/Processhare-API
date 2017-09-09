<?php

namespace AppBundle\Publisher;

interface PublisherInterface
{
    /**
     * @param string $message
     * @param string $routingKey
     * @param array $additionalProperties
     * @param array|null $headers
     */
    public function publish($message, $routingKey = '', $additionalProperties = array(), array $headers = null);

    /**
     * @param array $messageCollection
     * @param string $routingKey
     * @param array $additionalProperties
     */
    public function publishBatch(array $messageCollection, $routingKey = '', $additionalProperties = array());

    /**
     * @param $message
     * @return string|\Symfony\Component\Serializer\Encoder\scalar
     */
    public function encodeMessage($message);
}
