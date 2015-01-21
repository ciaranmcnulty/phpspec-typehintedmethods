<?php

namespace Cjm\PhpSpec\Argument;

use Prophecy\Prophecy\ProphecySubjectInterface;

class ClassIdentifier
{
    /**
     * @param $argument
     * @return string
     */
    public function getTypeName($argument)
    {
        $typeName = get_class($argument);

        if ($this->isProphecyObject($argument)) {
            $typeName = $this->getProphecyBaseType($argument);
        }

        return $typeName;
    }

    /**
     * @param $argument
     * @return bool
     */
    private function isProphecyObject($argument)
    {
        return $argument instanceof ProphecySubjectInterface;
    }

    /**
     * @param $argument
     * @return mixed|string
     */
    private function getProphecyBaseType($argument)
    {
        $typeName = get_parent_class($argument);

        if ($typeName == 'stdClass'
            && $interfaces = $this->getAllInterfaces($argument)) {
            $typeName = reset($interfaces);
        }

        return $typeName;
    }

    /**
     * @param $argument
     * @return array
     */
    private function getAllInterfaces($argument)
    {
        $interfaces = array_filter(
            class_implements($argument),
            function ($el) {
                return 0 !== strpos($el, 'Prophecy\\');
            }
        );

        return $interfaces;
    }
}
