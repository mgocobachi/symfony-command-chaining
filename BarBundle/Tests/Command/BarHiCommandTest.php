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
use Gocobachi\BarBundle\Command\BarHiCommand;

class BarHiCommandTest extends CommandTestCase
{
    /**
     * Test the execution of the command
     *
     * @expectedException \Gocobachi\ChainCommandBundle\Exceptions\DependentException
     */
    public function testExecute()
    {
        $command       = new BarHiCommand;
        $commandTester = $this->addCommand($command);

        $commandTester->execute([
            'command' => $command,
        ]);

        $this->fireEvent($command, $commandTester->getInput(), $commandTester->getOutput());

        $this->assertContains('Hello from Bar!', $commandTester->getDisplay());
    }

    /**
     * Test the rest masters commands and its empty value if we call the getMaster() method
     */
    public function testMasters()
    {
        $command = new BarHiCommand;

        $this->assertTrue(count($command->masters()) > 0);
    }

    /**
     * Test the rest masters commands and its empty value if we call the getMaster() method
     */
    public function testResetMasters()
    {
        $command = new BarHiCommand;

        $command->resetMasters();

        $this->assertEmpty($command->getMaster());
    }
}
