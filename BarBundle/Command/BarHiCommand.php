<?php
/*
 * This file is part of the Gocobachi package.
 *
 * (c) Miguel Gocobachi <mgocobachi@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Gocobachi\BarBundle\Command;

use Gocobachi\ChainCommandBundle\Concerns\ChainCommand;
use Gocobachi\ChainCommandBundle\Contracts\ChainInterface;
use Gocobachi\FooBundle\Command\FooHelloCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BarHiCommand extends ContainerAwareCommand implements ChainInterface
{
    use ChainCommand;

    protected function configure()
    {
        $this->setName('bar:hi')->setDescription('This is the bar:hi command who depends of foo:hello');

        $this->registerMasterCommand(FooHelloCommand::class);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello from Bar!');
    }

}
