#PhpSpec Typehinted Methods Extension

##Installation

Add this extension as a dependency in composer.json:

    "require-dev": {
        "phpspec/phpspec" : "2.*@dev",
        "ciaranmcnulty/phpspec-typehintedmethods": "*@dev"
    }

Install using composer, add the following to your phpspec.yml:

    extensions:
      - Cjm\PhpSpec\Extension\TypeHintedMethodsExtension

##Usage

PhpSpec by default will generate nonexistent methods, but will not add typehints. This extension enables that behaviour.

Write a phpspec example that uses a non-existent method:

    function it_does_foo()
    {
        $this->foo(new \ArrayObject());
    }

And run the spec. After accepting the prompt, the following will appear in your class under specification:

    public function foo(\ArrayObject $argument1)
    {
        // TODO: write logic here
    }

##Who should use this?

There are pros and cons to this extension. It's written to satisfy a particular itch that I (Ciaran) had, because I tend to write examples like this:

    function it_does_something_with_a_token(TokenInterface $token)
    {
        $token->getId()->willReturn(1234);

        $this->foo($token)->shouldReturn(1234);
    }

In this case, because I've written my example thinking about the types I want foo to take, it's efficient for me to get a typehinted method.

However, some people write specs much more in an 'example' frame of mind, so might write something like this:

    function it_does_something_with_a_token(ArrayToken $token)
    {
        $token->getId()->willReturn(1234);

        $this->foo($token)->shouldReturn(1234);
    }

In this case the author is using an ArrayToken to illustrate the example, but would prefer the typehint to be TokenInterface. For this author, the typehinting will be irritating because they will have to keep editing the typehint.

(This is the reason core phpspec does not have this feature... yet)