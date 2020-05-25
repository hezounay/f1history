<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Pilote;
use App\Form\TeamType;
use App\Form\PiloteType;
use App\Entity\GrandPrix;
use App\Form\GrandPrixType;
use App\Service\StatsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard_index")
     * 
     * @return Response
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
  

    /**
     * Permet de créer une Ecurie
     * @Route("/admin/team/new", name="admin_team_create")
     * Permet de créer un Pilote
     * @Route("/admin/pilote/new", name="admin_pilote_create")
     * Permet de créer un Grand-Prix
     * @Route("/admin/grandprix/new", name="admin_grandprix_create")
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager){
        $grandprix = new GrandPrix();
       
        $form = $this->createForm(GrandPrixType::class, $grandprix);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            foreach($grandprix->getImages() as $image){
                $image->setGrandPrix($grandprix);
                $manager->persist($image);
            }

     

            $manager->persist($grandprix);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le Grand-Prix &nbsp<strong>{$grandprix->getTitle()}</strong> a bien été enregistré ! "
            );

            return $this->redirectToRoute('admin_grandprix_index',[
                'slug' => $grandprix->getSlug()
            ]);
        }

        return $this->render('admin/grand_prix/new.html.twig', [
           'myForm' => $form->createView()
        ]);
        $pilote = new Pilote();
       
        $form = $this->createForm(PiloteType::class, $pilote);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


     

            $manager->persist($pilote);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le Pilote &nbsp<strong>{$pilote->getNom()}</strong> a bien été enregistré ! "
            );

            return $this->redirectToRoute('admin_pilote_index',[
                'slug' => $pilote->getSlug()
            ]);
        }

        return $this->render('admin/pilote/new.html.twig', [
           'myForm' => $form->createView()
        ]);

        $team = new Team();
       
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


     

            $manager->persist($team);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'Ecurie &nbsp<strong>{$team->getNom()}</strong> a bien été enregistrée ! "
            );

            return $this->redirectToRoute('admin_team_index',[
                'slug' => $team->getSlug()
            ]);
        }

        return $this->render('admin/team/new.html.twig', [
           'myForm' => $form->createView()
        ]);



    }
   
}
