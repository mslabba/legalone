<?php

namespace App\Controller;

use App\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LogController extends AbstractController
{
    private $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * @Route("/count", name="log_count", methods={"GET"})
     */
    public function countLogs(Request $request): JsonResponse
    {
        $filters = $request->query->all();
        $count = $this->logRepository->countLogsByFilters($filters);

        return new JsonResponse(['counter' => $count]);
    }
}
