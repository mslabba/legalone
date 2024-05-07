<?php

namespace App\Command;

use App\Service\LogParserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseLogFilesCommand extends Command
{
    private $logParserService;

    public function __construct(LogParserService $logParserService)
    {
        parent::__construct();
        $this->logParserService = $logParserService;
    }

    protected function configure()
    {
        $this->setName('app:parse-log-files')
             ->setDescription('Parse and save log files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logFilePath = 'var/log/file.log';

        // Call the parseAndSaveLogFile method
        $this->logParserService->parseAndSaveLogFile($logFilePath);

        $output->writeln('Log files parsed and saved successfully.');

        return Command::SUCCESS;
    }
}
