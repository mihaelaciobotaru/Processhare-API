<?php
namespace AppBundle\Command;

use AppBundle\Publisher\PublisherInterface;
use Doctrine\Common\Cache\CacheProvider;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TimeoutCheckerCommand extends ContainerAwareCommand
{
    /** @var  CacheProvider $cacheProvider */
    private $cacheProvider;

    /** @var  PublisherInterface $publisher */
    private $publisher;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('app:timeout_checker')
            ->setDescription('Republish expired messages back to queue');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return bool
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $keys = $this->getContainer()->get('memcached')->fetch('keys');
        if (!$keys) {
            return true;
        }

        $deletedKeys = [];
        foreach ($keys as $key) {
            $output->writeln($key);
            $messageTime = $this->getContainer()->get('memcached')->fetch($key . 'time');
            if ($messageTime > date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 60*5)) {
                break;
            }

            $deletedKeys[] = $key;
            $output->writeln("Republish data to queue $key");
            $this->getContainer()->get('sorting_publisher')->publish(
                $this->getContainer()->get('memcached')->fetch($key . 'data')
            );
            $this->getContainer()->get('memcached')->delete($key . 'time');
            $this->getContainer()->get('memcached')->delete($key . 'data');
        }
        $this->getContainer()->get('memcached')->save('keys', array_diff($keys, $deletedKeys));

        return true;
    }
}