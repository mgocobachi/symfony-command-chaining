<?php
/*
 * This file is part of the Gocobachi package.
 *
 * (c) Miguel Gocobachi <mgocobachi@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Gocobachi\ChainCommandBundle\Tests\Fixture;

use Gocobachi\ChainCommandBundle\Console\Event\Listener;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CommandTestCase extends KernelTestCase
{
    /**
     * Name of the event
     *
     * @var string
     */
    const EVENT_NAME = 'kernel.listener.console';

    /**
     * Symfony application reference
     *
     * @var Application
     */
    protected $application = null;

    /**
     * Dispatcher
     *
     * @var EventDispatcher
     */
    protected $dispatcher = null;

    /**
     * Chain listener
     *
     * @var Listener
     */
    protected $listener = null;

    /**
     * Set up for the tests
     *
     * @return void
     */
    public function setUp()
    {
        $this->bootApplication();
    }

    /**
     * Reset the configuration for each test
     *
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->application = null;
        $this->dispatcher  = null;
        $this->listener    = null;
    }

    /**
     * Initialize the application
     *
     * @return void
     */
    protected function bootApplication()
    {
        $this->bootKernel();

        $this->application = new Application(static::$kernel);
        $this->dispatcher  = new EventDispatcher;
        $this->listener    = new Listener;

        $this->dispatcher->addListener(static::EVENT_NAME, [
            $this->listener,
            'onConsoleCommand',
        ]);

        $this->dispatcher->addListener(static::EVENT_NAME, [
            $this->listener,
            'onConsoleTerminate',
        ]);

        $this->application->setDispatcher($this->dispatcher);
    }

    /**
     * Add a new command to be tested and return its tester environment
     *
     * @param Command $command
     *
     * @return CommandTester
     */
    protected function addCommand(Command $command)
    {
        $this->application->add($command);

        return new CommandTester($command);
    }

    /**
     * Fire the event to catch the console event
     *
     * @param Command         $command
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function fireEvent(Command $command, InputInterface $input, OutputInterface $output)
    {
        $event = new ConsoleCommandEvent($command, $input, $output);
        $this->dispatcher->dispatch(static::EVENT_NAME, $event);
    }
}