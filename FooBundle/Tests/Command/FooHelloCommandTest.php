<?php
/*
 * This file is part of the Gocobachi package.
 *
 * (c) Miguel Gocobachi <mgocobachi@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Gocobachi\FooBundle\Tests\Command;

use Gocobachi\ChainCommandBundle\Tests\Fixture\CommandTestCase;
use Gocobachi\FooBundle\Command\FooHelloCommand;

class FooHelloCommandTest extends CommandTestCase
{
    /**
     * Test the execution of the command
     *
     * @return void
     */
    public function testExecute()
    {
        $command       = new FooHelloCommand;
        $commandTester = $this->addCommand($command);

        $commandTester->execute([
            'command' => $command,
        ]);

        $this->fireEvent($command, $commandTester->getInput(), $commandTester->getOutput());

        $output = $commandTester->getDisplay();

        $this->assertContains('Hello from Foo!', $output);
    }

    /**
     * Test the execution of the command verifying that exists dependents executed
     *
     * @return void
     */
    public function testExecuteDependents()
    {
        $command       = new FooHelloCommand;
        $commandTester = $this->addCommand($command);

        $commandTester->execute([
            'command' => $command,
        ]);

        $this->fireEvent($command, $commandTester->getInput(), $commandTester->getOutput());

        $output = explode(PHP_EOL, trim($commandTester->getDisplay()));

        $this->assertTrue(count($output) > 1);
    }
}
