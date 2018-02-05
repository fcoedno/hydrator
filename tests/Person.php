<?php
/**
 * Created by PhpStorm.
 * User: edno
 * Date: 05/02/18
 * Time: 12:20
 */

namespace Edno\Hydrator\Tests;

class Person
{
    private $name;
    private $age;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }
}