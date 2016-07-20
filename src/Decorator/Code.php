<?php

namespace Cjm\PhpSpec\Decorator;

class Code
{
    /**
     * @param $argumentNamespace
     * @param $codeIn
     *
     * @return mixed
     */
    public function addUseStatementForArgument($argumentNamespace, $codeIn)
    {
        $codeOut = $this->removeNamespace($argumentNamespace, $codeIn);
        $codeOut = $this->addNamespace($argumentNamespace, $codeOut);

        return $codeOut;
    }

    /**
     * @param $argumentNamespace
     * @param $codeIn
     *
     * @return mixed
     */
    private function removeNamespace($argumentNamespace, $codeIn)
    {
        return preg_replace('/\nuse\s+' . addslashes($argumentNamespace) . ';/', '', $codeIn);
    }

    /**
     * @param $argumentNamespace
     * @param $codeOut
     *
     * @return mixed
     */
    private function addNamespace($argumentNamespace, $codeOut)
    {
        return preg_replace('/namespace\s+(.+);/', '$0' . "\n" . 'use ' . addslashes($argumentNamespace) . ';', $codeOut);
    }
}
