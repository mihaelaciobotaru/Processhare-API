<?php
namespace AppBundle\Publisher;

use OldSound\RabbitMqBundle\RabbitMq\Producer;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class Publisher extends Producer
{
    /**
     * @param $msgBody
     * @param array $additionalProperties
     * @return AMQPMessage
     */
    private function prepareMessage($msgBody, array $additionalProperties = array())
    {
        $msg = new AMQPMessage(
            $msgBody,
            array_merge($this->getBasicProperties(), $additionalProperties)
        );

        return $msg;
    }

    /**
     * @inheritdoc
     */
    public function publish($message, $routingKey = '', $additionalProperties = array(), array $headers = null)
    {
        $msg = $this->prepareMessage($message, $additionalProperties);

        $this->getChannel()->basic_publish(
            $msg,
            $this->getExchangeName(),
            (string) $routingKey
        );
    }

    /**
     * @inheritdoc
     */
    public function publishBatch(array $messageCollection, $routingKey = '', $additionalProperties = array())
    {
        foreach ($messageCollection as $message) {
            $msg = $this->prepareMessage($message, $additionalProperties);

            $this->getChannel()->batch_basic_publish(
                $msg,
                $this->exchangeOptions['name'],
                (string) $routingKey
            );
        }

        $this->getChannel()->publish_batch();
    }

    /**
     * @inheritdoc
     */
    public function encodeMessage($message)
    {
        $encoder = new JsonEncoder();
        return $encoder->encode($message, JsonEncoder::FORMAT);
    }

    /**
     * @return string
     */
    public function getExchangeName() : string
    {
        return $this->exchangeOptions['name'];
    }
}
