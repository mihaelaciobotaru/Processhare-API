<?php
namespace Tests\AppBundle\Comparator;

use AppBundle\Comparator\GreaterThanComparator;
use PHPUnit\Framework\TestCase;

class GreaterThanComparatorTest extends TestCase
{
    public function testCompare()
    {
        $comparator = new GreaterThanComparator();

        $result = $comparator->compare(10, 5);
        $this->assertTrue($result);

        $result = $comparator->compare( 5, 10);
        $this->assertFalse($result);
    }
}