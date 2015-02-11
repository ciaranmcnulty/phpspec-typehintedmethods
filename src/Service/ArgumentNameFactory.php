<?php

namespace Cjm\PhpSpec\Service;

use Gnugat\Medio\Model\Type;

class ArgumentNameFactory
{
    /**
     * @param Type $type
     *
     * @return string
     */
    public function fromType(Type $type)
    {
        if (!$type->isObject()) {
            return 'argument';
        }
        $fullyQualifiedClassName = $type->getName();
        $nameSpaces = explode('\\', $fullyQualifiedClassName);
        $className = end($nameSpaces);

        return lcfirst($className);
    }
}
