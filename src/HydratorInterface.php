<?php
/**
 * Created by PhpStorm.
 * User: edno
 * Date: 05/02/18
 * Time: 12:10
 */

namespace Edno\Hydrator;

interface HydratorInterface
{
    /**
     * @param $object
     * @param array $data
     */
    public function hydrate($object, array $data);
    public function extract($object) : array;
}