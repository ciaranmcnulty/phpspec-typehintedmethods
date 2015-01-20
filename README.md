#PhpSpec Typehinted Methods Extension

##Usage

PhpSpec by default will generate nonexistent methods, but will not add typehints. This extension enables that behaviour.

Write a phpspec example that uses a non-existent method:

    function it_does_foo()
    {
        $this->foo(new \ArrayObject());
    }

And run the spec. After accepting the prompt, the following will appear in your class under specification:

    public function foo(\ArrayObject $arrayObject)
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

This is the reason the functionality is not in core - we do not want to encourage authors to typehint against implementations (discussion at https://github.com/phpspec/phpspec/issues/230)

##Installation

Add this extension as a dependency in composer.json:

    "require-dev": {
        "ciaranmcnulty/phpspec-typehintedmethods": "dev-master"
    }

Install using composer, add the following to your phpspec.yml:

    extensions:
      - Cjm\PhpSpec\Extension\TypeHintedMethodsExtension

##Todo

Future ideas:

1. Analysis/generation of `use` statements in target file to allow shorter typehints

2. Meta-analysis of examples to work out which parent class(es) could be used in typehint (?)