<?php
/**
 * Created by PhpStorm.
 * User: edno
 * Date: 05/02/18
 * Time: 12:20
 */

namespace Edno\Hydrator\Tests;

class Employee extends Person
{
    private $salary;

    public function getSalary()
    {
        return $this->salary;
    }
}