<?php

namespace AppBundle\Service\Provider;

class MessageProvider
{
    /**
     * @var ProviderInterface[] $providers
     */
    private $providers = [];

    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        $message = null;
        foreach ($this->providers as $provider) {
            $message = $provider->getMessage();

            if ($message) {
                break;
            }
        }

        return $message;
    }
}
