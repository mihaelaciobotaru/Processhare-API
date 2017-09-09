<?php
namespace AppBundle\Command;

use Doctrine\Common\Cache\CacheProvider;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TimeoutCheckerCommand extends ContainerAwareCommand
{
    /** @var  CacheProvider $cacheProvider */
    private $cacheProvider;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:timeout_checker')
            ->setDescription('Republish expired messages back to queue');
    }

    public function setCacheProvider(CacheProvider $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $keys = $this->cacheProvider->fetch('keys');
        foreach ($keys as $key) {
            $message = $this->cacheProvider->fetch($key);
            if ($message['time'] < date('Y-m-d H:i:s', strtotime(date()) - 60*5)) {
                break;
            }

            $this->cacheProvider->delete($key);
            // republish
        }
    }
}