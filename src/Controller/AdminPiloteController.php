<?php

namespace App\Controller;

use App\Entity\Pilote;
use App\Form\PiloteType;
use App\Service\PaginationService;
use App\Repository\PiloteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPiloteController extends AbstractController
{
    /**
     * @Route("/admin/pilote/{page<\d+>?1}", name="admin_pilote_index")
     */
    public function index($page, PaginationService $pagination)
    {
     
        $pagination->setEntityClass(Pilote::class)
        ->setPage($page)
        ->setLimit(10)
        ->setRoute('admin_pilote_index');

        /* return $this->render('admin/pilote/index.html.twig', [
            'controller_name' => 'AdminGrandPrixController',
            ]); */  

        return $this->render('admin/pilote/index.html.twig',[
            'pagination' => $pagination
        ]);



     




    }

     /**
     * Permet d'afficher le formulaire d'édition
     * @Route("/admin/pilote/{id}/edit", name="admin_pilote_edit")
     *
     * @param Pilote $pilote
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Pilote $pilote, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(PiloteType::class,$pilote);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($pilote);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$pilote->getNom()}</strong> a bien été modifiée"
            );
        }

        return $this->render('admin/grand_prix/edit.html.twig',[
            'grandprix' => $pilote,
            'myForm' => $form->createView()
        ]);


    }

     /**
     * Permet de supprimer une annonce
     * @Route("/admin/grand_prix/{id}/delete", name="admin_grandprix_delete")
     *
     * @param Pilote $pilote
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Pilote $pilote, EntityManagerInterface $manager){
        // on ne peut pas supprimer une annonce qui possède des Statistiques 
        if(count($pilote->getStats()) > 0){
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer le Pilote  <strong>{$pilote->getNom()}</strong> car il possède déjà des statistiques"
            );
        }else{
            $manager->remove($pilote);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$pilote->getNom()}</strong> a bien été supprimée"
            );
        }

        return $this->redirectToRoute('admin_grandprix_index');

    }



}
