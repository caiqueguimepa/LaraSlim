<?php

namespace LaraSlim\Commands;

use LaraSlim\Kernel\Console\Controller;
use LaraSlim\Kernel\Console\Migration;
use LaraSlim\Kernel\Console\Model;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:migration')
            ->setDescription('Create a new migration')
            ->setHelp('This command allows you to create a new migration in the application.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the migration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        if (!$name) {
            $output->writeln('<error>No migration name provided.</error>');
            return Command::FAILURE;
        }

        $migrationName = $name;

        Migration::create($migrationName);

        $output->writeln("<info>Migration {$migrationName} created successfully</info>");

        return Command::SUCCESS;
    }
}