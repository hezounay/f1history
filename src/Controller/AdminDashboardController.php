<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StatsService;
use Doctrine\ORM\EntityManagerInterface;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard_index")
     */
    public function index(EntityManagerInterface $manager, StatsService $statsService)
    {


        $stats = $statsService->getStatsCount();
        $gp = $statsService->getGrandPrixCount();
        $driver = $statsService->getPiloteCount();
        $team = $statsService->getTeamCount();



        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('stats','gp','driver','team')
        ]);
    }
}
