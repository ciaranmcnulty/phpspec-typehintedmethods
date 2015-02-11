<?php

namespace Cjm\PhpSpec\Service;

use Gnugat\Medio\Model\Type;
use Prophecy\Prophecy\ProphecySubjectInterface;

class TypeFactory
{
    /**
     * @param mixed $variable
     *
     * @return Type
     */
    public function fromVariable($variable)
    {
        if (is_callable($variable)) {
            return new Type('callable');
        }
        if (is_object($variable)) {
            if ($variable instanceof ProphecySubjectInterface) {
                return new Type($this->getProphecyBaseType($variable));
            }
            return new Type(get_class($variable));
        }
        $gettypeName = gettype($variable);
        if ($gettypeName === 'boolean') {
            return new Type('bool');
        }
        if ($gettypeName === 'integer') {
            return new Type('int');
        }
        if ($gettypeName === 'NULL') {
            return new Type('null');
        }
        if ($gettypeName === 'unknown type') {
            return new Type('mixed');
        }

        return new Type($gettypeName);
    }

    /**
     * @param mixed $variable
     *
     * @return mixed|string
     */
    private function getProphecyBaseType($variable)
    {
        $typeName = get_parent_class($variable);

        if ($typeName == 'stdClass'
            && $interfaces = $this->getAllInterfaces($variable)) {
            $typeName = reset($interfaces);
        }

        return $typeName;
    }

    /**
     * @param mixed $variable
     *
     * @return array
     */
    private function getAllInterfaces($variable)
    {
        $interfaces = array_filter(
            class_implements($variable),
            function ($el) {
                return 0 !== strpos($el, 'Prophecy\\');
            }
        );

        return $interfaces;
    }
}
