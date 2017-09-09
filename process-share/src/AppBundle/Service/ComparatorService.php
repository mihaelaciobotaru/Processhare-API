<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 10.09.2017
 * Time: 00:19
 */

namespace AppBundle\Service;


use AppBundle\Entity\ComparatorFunction;
use AppBundle\Repository\ComparatorFunctionRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Cache\CacheProvider;

class ComparatorService
{
    /**
     * @var CacheProvider $cacheProvider
     */
    private $cacheProvider;

    /**
     * @var ComparatorFunctionRepository $comparatorRepository
     */
    private $comparatorRepository;

    /**
     * @param CacheProvider $cacheProvider
     */
    public function setCacheProvider(CacheProvider $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }

    /**
     * @param Registry $doctrine
     */
    public function setComparatorRepository(Registry $doctrine)
    {
        $this->comparatorRepository = $doctrine->getRepository('AppBundle:ComparatorFunction');
    }

    /**
     * @param string $name
     * @return string
     */
    public function getComparator(string $name)
    {
        $result = $this->cacheProvider->fetch($name);
        if (!$result) {
            $result = $this->comparatorRepository->findComparatorByName($name);
            $this->cacheProvider->save($name, $result);
        }

        return $result->getCode();
    }
}