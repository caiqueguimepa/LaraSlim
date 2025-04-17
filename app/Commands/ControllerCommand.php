<?php

namespace LaraSlim\Commands;

use LaraSlim\Karnel\Console\Controller;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ControllerCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:controller')
            ->setDescription('Create a new controller')
            ->setHelp('This command allows you to create a new controller in the application.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        if (!$name) {
            $output->writeln('<error>No controller name provided.</error>');
            return Command::FAILURE;
        }

        $controllerName = ucfirst($name);
        
        Controller::create($controllerName);
        
        $output->writeln("<info>Controller {$controllerName} created successfully</info>");

        return Command::SUCCESS;
    }
}
