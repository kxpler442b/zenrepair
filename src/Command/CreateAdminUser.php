<?php

declare(strict_types = 1);

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminUser extends Command
{
    protected static $defaultName = 'users:create-admin';
    protected static $defaultDescription = 'Creates a new admin account.';

    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('What will this user\'s email be?', false);

        if(!$helper->ask($input, $output, $question)) {
            $output->writeln('You need to provide an email to create an admin account.');
        }


    }
}