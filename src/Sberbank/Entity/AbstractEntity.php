<?php

namespace Sberbank\Entity;


abstract class AbstractEntity
{
    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->setAttributes($params);
    }

    /**
     * @return array
     */
    public function fields() : array
    {
        $vars = get_object_vars($this);

        return array_keys($vars);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $valuesArray = get_object_vars($this);
        $returnArray = [];
        foreach ($this->fields() as $key) {
            if ($this->$key instanceof AbstractEntity) {
                $returnArray[$key] = $this->$key->toArray();
            } else {
                $returnArray[$key] = $valuesArray[$key];
            }
        }

        return $returnArray;
    }

    /**
     * @param $values
     */
    public function setAttributes($values)
    {
        if (is_array($values)) {
            foreach ($values as $name => $value) {
                $setter = 'set' . ucfirst($name);
                if (method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        }
    }
}