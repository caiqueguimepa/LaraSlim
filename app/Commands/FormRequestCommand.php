<?php

namespace LaraSlim\Commands;

use LaraSlim\Karnel\Console\FormRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FormRequestCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('make:request')
            ->setDescription('Create a new request')
            ->setHelp('This command allows you to create a new request in the application.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the request');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        if (!$name) {
            $output->writeln('<error>No request name provided.</error>');
            return Command::FAILURE;
        }

        $requestName = $name;

        FormRequest::create($requestName);

        $output->writeln("<info>Request {$requestName} created successfully</info>");

        return Command::SUCCESS;
    }
}