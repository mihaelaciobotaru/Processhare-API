<?php
namespace Tests\AppBundle\Service;
use AppBundle\Entity\ComparatorFunction;
use AppBundle\Service\ComparatorService;
use PHPUnit\Framework\TestCase;

class ComparatorServiceTest extends TestCase
{
    public function testGetComparatorFromCache()
    {
        $comparator = new ComparatorFunction();
        $comparator->setName('test')
            ->setCode('testCode');

        $cacheDriver = $this->getCacheDriverMock();
        $cacheDriver->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($comparator));

        $comparatorRepository = $this->getComparatorRepositoryMock();
        $comparatorRepository->expects($this->never())
            ->method('findComparatorByName');

        $doctrine = $this->getDoctrineMock();
        $doctrine->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($comparatorRepository));

        $comparatorService = new ComparatorService();
        $comparatorService->setCacheProvider($cacheDriver);
        $comparatorService->setComparatorRepository($doctrine);

        /** @var ComparatorFunction $result */
        $result = $comparatorService->getComparator('test');

        $this->assertEquals($result, $comparator->getCode());
    }

    public function testGetComparatorFromDatabase()
    {
        $comparator = new ComparatorFunction();
        $comparator->setName('test')
            ->setCode('testCode');

        $cacheDriver = $this->getCacheDriverMock();
        $cacheDriver->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue(null));

        $comparatorRepository = $this->getComparatorRepositoryMock();
        $comparatorRepository->expects($this->once())
            ->method('findComparatorByName')
            ->will($this->returnValue($comparator));

        $doctrine = $this->getDoctrineMock();
        $doctrine->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($comparatorRepository));

        $comparatorService = new ComparatorService();
        $comparatorService->setCacheProvider($cacheDriver);
        $comparatorService->setComparatorRepository($doctrine);

        /** @var ComparatorFunction $result */
        $result = $comparatorService->getComparator('test');

        $this->assertEquals($result, $comparator->getCode());
    }

    private function getCacheDriverMock()
    {
        return $this->getMockBuilder('Doctrine\Common\Cache\CacheProvider')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getComparatorRepositoryMock()
    {
        return $this->getMockBuilder('AppBundle\Repository\ComparatorFunctionRepository')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getDoctrineMock()
    {
        return $this->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();
    }
}