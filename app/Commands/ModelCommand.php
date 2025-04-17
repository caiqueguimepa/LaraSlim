<?php

namespace LaraSlim\Commands;

use LaraSlim\Karnel\Console\Model;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModelCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('make:model')
            ->setDescription('Create a new model')
            ->setHelp('This command allows you to create a new model in the application.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the model');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        if (!$name) {
            $output->writeln('<error>No model name provided.</error>');
            return Command::FAILURE;
        }

        $modelName = ucfirst($name);
        
        Model::create($modelName);
        
        $output->writeln("<info>Model {$modelName} created successfully</info>");

        return Command::SUCCESS;
    }
}