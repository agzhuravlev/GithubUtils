<?php

namespace App\Command;

use App\Service\Reminder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemindAboutPullRequests extends BaseCommand
{
    private const SLACK = 'slack';
    private const EMAIL = 'email';


    protected function configure()
    {
        $this
            ->setName('pull_requests:remind')
            ->setDescription('Remind about open pull requests')
            ->addArgument('reminder', InputArgument::OPTIONAL, 'Reminder type: slack or email', self::SLACK);
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getReminder($input)->remindAboutOpenPullRequests();

        $output->write('Done!');
    }


    private function getReminder(InputInterface $input): Reminder
    {
        switch ($input->getArgument('reminder')) {
            case self::SLACK:
                return $this->getContainer()->get('slack_reminder');
            case self::EMAIL:
                return $this->getContainer()->get('email_reminder');
            default:
                throw new \Exception('Undefined reminder');
        }
    }
}