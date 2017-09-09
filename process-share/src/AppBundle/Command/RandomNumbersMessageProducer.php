<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RandomNumbersMessageProducer extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:generate-numbers')
            ->setDescription('Generates arrays of random numbers and posts them on the queue.')
            ->setHelp('Helps generate dummy messages');

        $this->addArgument('array_length', InputArgument::REQUIRED, 'The length of the result arrays.')
            ->addArgument('min_value', InputArgument::OPTIONAL, 'Minimum value that the array elements can take.', 0)
            ->addArgument('max_value', InputArgument::OPTIONAL, 'Maximum value that the array elements can take.', 10000);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $arrayLength = $input->getArgument('array_length');
        $minVal = $input->getArgument('min_value');
        $maxVal = $input->getArgument('max_value');

        /** @var SortingP $publisher */
        $publisher = $this->getContainer()->get('sorting_publisher');
        while(1) {
            $array = array();

            for ($i = 0; $i < $arrayLength; $i++) {
                $array[] = rand($minVal, $maxVal);
            }

            $publisher->publish(json_encode($array));
            unset($array);
        }
    }

}