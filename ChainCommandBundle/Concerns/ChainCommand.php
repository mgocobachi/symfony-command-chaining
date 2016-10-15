<?php
/*
 * This file is part of the Gocobachi package.
 *
 * (c) Miguel Gocobachi <mgocobachi@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Gocobachi\ChainCommandBundle\Concerns;

/**
 * Class ChainCommand
 *
 * Extends the functionality of the commands to be able to register it to any master command
 *
 * @package Gocobachi\ChainCommandBundle\Concerns
 */
trait ChainCommand
{
    /**
     * List of commands who this command depends
     *
     * @var array
     */
    protected $commands = [];
    
    /**
     * Register a master command
     *
     * @param string $command
     */
    public function registerMasterCommand($command)
    {
        array_push($this->commands, $command);
    }
    
    /**
     * Gets all the master commands
     *
     * @return array
     */
    public function masters()
    {
        return $this->commands;
    }
    
    /**
     * Get the master method class
     *
     * @return string
     */
    public function getMaster()
    {
        if (!empty($this->commands)) {
            return $this->commands[0];
        }

        return '';
    }

    /**
     * Reset the master commands stored to empty array
     *
     * @return void
     */
    public function resetMasters()
    {
        $this->commands = [];
    }
}