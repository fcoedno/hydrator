<?php
/**
 * Created by PhpStorm.
 * User: edno
 * Date: 05/02/18
 * Time: 12:13
 */

namespace Edno\Hydrator;

class Hydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function hydrate($object, array $data)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('$object parameter must be an object');
        }

        $reflection = new \ReflectionObject($object);
        $this->hydrateByReflection($reflection, $object, $data);

        // Hydrates parent classes
        while ($reflection = $reflection->getParentClass()) {
            $this->hydrateByReflection($reflection, $object, $data);
        }
    }

    /**
     * @inheritdoc
     */
    public function extract($object): array
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('The $object parameter must be an object');
        }

        $reflection = new \ReflectionObject($object);
        $dados = $this->extractByReflection($reflection, $object);

        while ($reflection = $reflection->getParentClass()) {
            $dados = array_merge(
                $this->extractByReflection($reflection, $object),
                $dados // allows child classes to have priority
            );
        }

        return $dados;
    }

    /**
     * Hydrates an object by using reflection
     *
     * @param \ReflectionClass $reflection
     * @param $object
     * @param $data
     */
    private function hydrateByReflection(\ReflectionClass $reflection, $object, $data)
    {
        foreach ($data as $name => $value) {
            if (!$reflection->hasProperty($name)) {
                continue;
            }

            $setter = 'set' . ucfirst($name);

            if ($reflection->hasMethod($setter)) {
                $method = $reflection->getMethod($setter);
                if ($method->isPublic()) {
                    $method->invoke($object, $value);
                    continue;
                }
            }

            $property = $reflection->getProperty($name);
            $property->setAccessible(true);
            $property->setValue($object, $value);
        }
    }

    /**
     * Extracts object data into an array using reflection
     *
     * @param \ReflectionClass $reflection
     * @param $object
     * @return array
     */
    private function extractByReflection(\ReflectionClass $reflection, $object) : array
    {
        $data = [];
        foreach ($reflection->getProperties() as $property) {
            $getter = 'get' . ucfirst($reflection->getName());
            if ($reflection->hasMethod($getter)) {
                $method = $reflection->getMethod($getter);
                $data[$property->getName()] = $method->invoke($object);
                continue;
            }
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($object);
        }

        return $data;
    }
}