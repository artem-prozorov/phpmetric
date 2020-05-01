<?php

namespace PhpMetric\Tests\Actions;

use PHPUnit\Framework\TestCase;
use PhpMetric\Actions\Find;
use \PhpMetric\Exceptions\FatalActionException;

class FindStringTest extends TestCase
{
    public function testSettersAndGetters()
    {
        $code = 'string';
        $identifier = 'test string';
        $context = 'This is a context that contains phrase test string';
        
        $action = new Find();
        $action->setCode($code);
        $action->setIdentifier($identifier);
        $action->setContext($context);

        $this->assertEquals($action->getCode(), $code);
        $this->assertEquals($action->getIdentifier(), $identifier);
        $this->assertEquals($action->getContext(), $context);
    }

    public function testConstructor()
    {
        $code = 'string';
        $identifier = 'test string';
        $context = 'This is a context that contains phrase test string';

        $action = new Find($code, $identifier, $context);

        $this->assertEquals($action->getCode(), $code);
        $this->assertEquals($action->getIdentifier(), $identifier);
        $this->assertEquals($action->getContext(), $context);
    }

    public function testSuccessFind()
    {
        $code = 'string';
        $identifier = 'test string';
        $context = 'This is a context that contains phrase test string';

        $action = new Find($code, $identifier, $context);

        $this->assertEquals($action->execute()->getResult()->getData(), $identifier);
    }

    public function testFailureFind()
    {
        $code = 'string';
        $identifier = 'test string';
        $context = 'This is a context that does not contains the phrase we are looking for';

        $this->expectexception(FatalActionException::class);

        $action = new Find($code, $identifier, $context);
        $action->execute();
    }
}
