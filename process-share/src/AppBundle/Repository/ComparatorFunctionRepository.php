<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ComparatorFunction;

/**
 * ComparatorFunctionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ComparatorFunctionRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param string $name
     * @return ComparatorFunction
     */
    public function findComparatorByName(string $name) : ComparatorFunction
    {
        $qb = $this->createQueryBuilder('cf')
            ->where('cf.name = :name')
            ->setParameter('name', $name);

        return $qb->getQuery()->getSingleResult();
    }
}
