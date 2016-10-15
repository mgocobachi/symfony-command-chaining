<?php
/*
 * This file is part of the Gocobachi package.
 *
 * (c) Miguel Gocobachi <mgocobachi@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Gocobachi\ChainCommandBundle\Console\Event;

use Gocobachi\ChainCommandBundle\Contracts\ChainInterface;
use Gocobachi\ChainCommandBundle\Exceptions\DependentException;
use Symfony\Component\Console\Event\ConsoleEvent;

/**
 * Class Listener
 *
 * Service Event Listener for listening commands executed and catch them
 *
 * @package Gocobachi\ChainCommandBundle\Console\Event
 */
class Listener
{
    /**
     * Listen the command fire event, basically it process the command and see if it has dependencies,
     * if it does, then store them into the queue list and executing them right after the master is executed
     *
     * @param \Symfony\Component\Console\Event\ConsoleEvent $event
     *
     * @throws \Exception
     */
    public function onConsoleCommand(ConsoleEvent $event)
    {
        $command = $event->getCommand();

        if ($command instanceof ChainInterface) {
            $name = $command->getName();

            $event->stopPropagation();

            throw new DependentException(
                $name . ' command is a member of a command chain and cannot be executed on its own'
            );
        }
    }

    /**
     * Execute the commands belongs to the master
     *
     * @param \Symfony\Component\Console\Event\ConsoleEvent $event
     */
    public function onConsoleTerminate(ConsoleEvent $event)
    {
        $command = $event->getCommand();

        array_map(function ($command) use ($event) {
            $command->run($event->getInput(), $event->getOutput());
        }, array_filter($command->getApplication()->all(), function ($child) use ($command) {
            if ($child instanceof ChainInterface) {
                if (get_class($command) === $child->getMaster()) {
                    return $command;
                }
            }
        }));
    }
}