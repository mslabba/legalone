<?php

namespace App\Service;

use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;

class LogParserService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function parseAndSaveLogFile(string $logFilePath): void
    {
        $file = fopen($logFilePath, 'r');
        
        if (!$file) {
            throw new \Exception('Unable to open log file.');
        }

        while (($line = fgets($file)) !== false) {
            $logData = $this->parseLogLine($line);
            if ($logData) {
                $log = new Log();
                $log->setServiceName($logData['serviceName']);
                $log->setStatusCode($logData['statusCode']);
                $log->setCreatedAt($logData['createdAt']);
                $this->entityManager->persist($log);
            }
        }

        fclose($file);
        $this->entityManager->flush();
    }

    private function parseLogLine(string $line): ?array
    {
        // Assuming log line format:
        // SERVICE_NAME - - [TIMESTAMP] "REQUEST" STATUS_CODE
        $parts = explode('"', $line);
        $requestParts = explode(' ', trim($parts[1]));
        $status = trim($parts[2]);
        $statusParts = explode(' ', $status);
        $serviceName = trim(explode('-', $parts[0])[0]);
        $timestamp = trim(explode('[', explode(']', $line)[0])[1]);
        $statusCode = trim($statusParts[count($statusParts) - 1]);
        $createdAt = \DateTime::createFromFormat('d/M/Y:H:i:s O', $timestamp);

        return [
            'serviceName' => $serviceName,
            'statusCode' => $statusCode,
            'createdAt' => $createdAt,
        ];
    }
}
