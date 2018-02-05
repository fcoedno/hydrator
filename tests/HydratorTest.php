<?php
/**
 * Created by PhpStorm.
 * User: edno
 * Date: 05/02/18
 * Time: 12:18
 */

namespace Edno\Hydrator\Tests;

use Edno\Hydrator\Hydrator;
use PHPUnit\Framework\TestCase;

class HydratorTest extends TestCase
{
    /**
     * @var Hydrator $hydrator
     */
    protected $hydrator;

    public function setUp()
    {
        $this->hydrator = new Hydrator();
    }

    public function testObjectIsHydrated()
    {
        $data = [
            'name' => 'John Doe',
            'age' => 42
        ];

        $person = new Person();
        $this->hydrator->hydrate($person, $data);

        $expectedPerson = new Person();
        $expectedPerson
            ->setName('John Doe')
            ->setAge(42)
        ;

        $this->assertEquals($expectedPerson, $person);
    }
}