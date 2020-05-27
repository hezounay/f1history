<?php

namespace App\Controller;

use App\Entity\Stats;
use App\Entity\Pilote;
use App\Form\StatsType;
use App\Entity\GrandPrix;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminStatsController extends AbstractController
{
      /**
     * 
     * @Route("/admin/stats/{page<\d+>?1}", name="admin_stats_index")
     */
    public function index($page, PaginationService $pagination )
    {
     
        $pagination->setEntityClass(Stats::class)
        ->setPage($page)
        ->setLimit(10)
        ->setRoute('admin_stats_index');

        /* return $this->render('admin/stats/index.html.twig', [
            'controller_name' => 'AdminStatsController',
            ]); */  

        return $this->render('admin/stats/index.html.twig',[
            'pagination' => $pagination
        ]);
    }   
    /**
     * Permet d'afficher le formulaire d'édition
     * @Route("/admin/stats/{id}/edit", name="admin_stats_edit")
     * 
     * @param Stats $stats
     * @param Pilote $pilote
     * @param GrandPrix $grandprix
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Stats $stats, Pilote $pilote, GrandPrix $grandprix, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(StatsType::class, $stats);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($stats);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les Statistiques de <strong>{$pilote->getNom()}</strong> au <strong>{$grandprix->getTitle()}}</strong> en {$stats->getAnnee()} ont bien été modifiées"
            );
        }

        return $this->render('admin/stats/edit.html.twig',[
            'stats' => $stats,
            'pilote' => $pilote,
            'grandprix' => $grandprix,
            'myForm' => $form->createView()
            
        ]);


    }
    /**
     * Permet de créer des Statistiques
     * @Route("/admin/stats/new", name="admin_stats_create")
     * 
     * @param Stats $stats
     * @param Pilote $pilote
     * @param GrandPrix $grandprix
     * @param Request $request
     * @return Response
     */
    public function create(Stats $stats, Pilote $pilote, GrandPrix $grandprix, Request $request, EntityManagerInterface $manager){
        $stats = new Stats();
       
        $form = $this->createForm(StatsType::class, $stats);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

           

     

            $manager->persist($stats);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les Statistiques de <strong>{$pilote->getNom()}</strong> au <strong>{$grandprix->getTitle()}}</strong> en {$stats->getAnnee()} ont bien été enregistrées ! "
            );

            return $this->redirectToRoute('admin_stats_index',[
                'slug' => $stats->getSlug()
            ]);
        }

        return $this->render('admin/stats/new.html.twig', [
           'myForm' => $form->createView()
        ]);

    }
    /**
     * Permet de supprimer des Statistiques
     * @Route("/admin/stats/{id}/delete", name="admin_stats_delete")
     *
     * @param Stats $stats
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Stats $stats, Pilote $pilote, GrandPrix $grandprix, Request $request, EntityManagerInterface $manager){
        // on ne peut pas supprimer une annonce qui possède des Statistiques 
        
        {
            $manager->remove($stats);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les Statistiques de <strong>{$pilote->getNom()}</strong> au <strong>{$grandprix->getTitle()}}</strong> en {$stats->getAnnee()} ont bien été supprimées"
            );
        }

        return $this->redirectToRoute('admin_stats_index');

    }

}
