<?php

namespace spec\Cjm\PhpSpec\Decorator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Cjm\PhpSpec\Decorator\Code');
    }

    function it_should_add_use_namespace_for_typehinted_argument_from_spl()
    {
        $codeIn =<<<CODE_IN
<?php
namespace Foo;

class Foo {}
CODE_IN;

        $codeOut =<<<CODE_OUT
<?php
namespace Foo;
use ArrayObject;

class Foo {}
CODE_OUT;

        $this->addUseStatementForArgument('ArrayObject', $codeIn)->shouldReturn($codeOut);
    }

    function it_should_replace_use_statement_for_the_same_typehint()
    {

        $codeIn =<<<CODE_IN
<?php
namespace Foo;
use \SplFixedArray;

class Foo {}
CODE_IN;

        $codeOut =<<<CODE_OUT
<?php
namespace Foo;
use \SplFixedArray;

class Foo {}
CODE_OUT;

        $this->addUseStatementForArgument('\SplFixedArray', $codeIn)->shouldReturn($codeOut);
    }

    function it_should_add_only_one_use_statement()
    {
        $codeIn =<<<CODE_IN
<?php
namespace Foo;
use \SplFixedArray;

class Foo {}
CODE_IN;

        $codeOut =<<<CODE_OUT
<?php
namespace Foo;
use Foo\Bar\Baz;
use \SplFixedArray;

class Foo {}
CODE_OUT;

        $this->addUseStatementForArgument('Foo\Bar\Baz', $codeIn)->shouldReturn($codeOut);
    }
}
