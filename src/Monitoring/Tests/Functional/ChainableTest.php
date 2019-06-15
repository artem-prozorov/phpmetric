<?php

namespace Bizprofi\Monitoring\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Bizprofi\Monitoring\Actions\AbstractAction;
use Bizprofi\Monitoring\Actions\Http\Request;
use Bizprofi\Monitoring\Actions\{Find, Cycle};
use Bizprofi\Monitoring\Actions\ActionResult;
use Bizprofi\Monitoring\Exceptions\FatalActionException;
use Bizprofi\Monitoring\Exceptions\WarningActionException;

class ChainableTest extends TestCase
{
    public function testRequestAndFind()
    {
        // $this->assertTrue(true);

        // $findAlt = new Find('attribute', 'alt');
        // $findAlt->warning();

        $checkStatus = new Request('status');

        $findHref = new Find('attribute', 'href');
        $findHref->addChildAction($checkStatus);

        // $subAction = new Find('elements', 'img');
        // $subAction->addChildAction(new Cycle($findAlt))->warning();

        $subAction = new Find('elements', 'a');
        $subAction->addChildAction(new Cycle($findHref))->warning();

        $request = new Request('url', 'https://fermerator.ru/lebosol/catalog');
        $request->addChildAction($subAction);

        $request->execute();

        // var_dump($request->getResult()->getLogMessages());

        $this->assertTrue(true);

        //////////////////////////////////

        // $request = new Request('url', 'https://fermerator.ru');
        // $request->addChildAction(new Find('string', 'Средства'));
        // $request->addChildAction(new Find('string', 'фунгициды,'));
        // $request->addChildAction(new Find('string', 'd95d38a8faccaac9'));
        // $request->addChildAction(
        //     (new Find('string', 'not found'))
        //         ->setLevel(AbstractAction::WARNING)
        // );


        /////////////////////////////

        // request url 'http://localhost': 
        //     fail if cant find string 'Welcome', // Explicitly set warning
        //     warning if cant find element 'h1', // Warning is raized if metric fails
        //     warning if cant find elements 'img':
        //         for every element add warning if cant find attribute 'alt';
        //     status is 200,
        //     find link 'a.main-link':
        //         leads to 'http://localhost'.



        // $action = (new Request('url', 'http://localhost'))
        //     ->addChildAction(
        //         (new Find('string', 'Welcome'))
        //             ->setLevel(AbstractAction::FATAL)
        //     )
        //     ->addChildAction(
        //         (new Find('element', 'h1'))
        //             ->setLevel(AbstractAction::WARNING)
        //     )
        //     ->addChildAction(
        //         (new Find('elements', 'img'))
        //             ->setLevel(AbstractAction::WARNING)
        //             ->addChildLoopAction(
        //                 (new Find('attribute', 'alt'))
        //             ->setLevel(AbstractAction::WARNING)
        //             );
        //     );

        // $metric = new Metric();
        // $metric->setMap($action);
        // $metric->execute();
    }
}
