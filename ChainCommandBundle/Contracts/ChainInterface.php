<?php
/*
 * This file is part of the Gocobachi package.
 *
 * (c) Miguel Gocobachi <mgocobachi@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Gocobachi\ChainCommandBundle\Contracts;

interface ChainInterface
{
    /**
     * Register a master command
     *
     * @param string $command
     */
    public function registerMasterCommand($command);

    /**
     * Gets all the master commands
     *
     * @return array
     */
    public function masters();

    /**
     * Get the master method class
     *
     * @return string
     */
    public function getMaster();

    /**
     * Reset the master commands stored to empty array
     *
     * @return void
     */
    public function resetMasters();
}