<?php

namespace App\Controller;

use App\Entity\GrandPrix;
use App\Form\GrandPrixType;
use App\Service\PaginationService;
use App\Repository\GrandPrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminGrandPrixController extends AbstractController
{
    /**
     * 
     * @Route("/admin/grandprix/{page<\d+>?1}", name="admin_grandprix_index")
     */
    public function index($page, PaginationService $pagination)
    {
     
        $pagination->setEntityClass(GrandPrix::class)
        ->setPage($page)
        ->setLimit(10)
        ->setRoute('admin_grandprix_index');

        /* return $this->render('admin/grand_prix/index.html.twig', [
            'controller_name' => 'AdminGrandPrixController',
            ]); */  

        return $this->render('admin/grand_prix/index.html.twig',[
            'pagination' => $pagination
        ]);
    }

     /**
     * Permet d'afficher le formulaire d'édition
     * @Route("/admin/grandprix/{id}/edit", name="admin_grandprix_edit")
     * 
     * @param GrandPrix $grandprix
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(GrandPrix $grandprix, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(GrandPrixType::class,$grandprix);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($grandprix);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$grandprix->getTitle()}</strong> a bien été modifiée"
            );
        }

        return $this->render('admin/grand_prix/edit.html.twig',[
            'grandprix' => $grandprix,
            'myForm' => $form->createView()
        ]);


    }

     /**
     * Permet de supprimer un Grand-Prix
     * @Route("/admin/grand_prix/{id}/delete", name="admin_grandprix_delete")
     *
     * @param GrandPrix $grandprix
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(GrandPrix $grandprix, EntityManagerInterface $manager){
        // on ne peut pas supprimer une annonce qui possède des Statistiques 
        if(count($grandprix->getStats()) > 0){
            $this->addFlash(
                'warning',
                "Vous ne pouvez pas supprimer le Grand-Prix de <strong>{$grandprix->getTitle()}</strong> car il possède déjà des statistiques"
            );
        }else{
            $manager->remove($grandprix);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$grandprix->getTitle()}</strong> a bien été supprimée"
            );
        }

        return $this->redirectToRoute('admin_grandprix_index');

    }
    
 /**
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
                "Le Grand-Prix &nbsp<strong>{$grandprix->getTitle()}</strong> a bien été enregistrée ! "
            );

            return $this->redirectToRoute('admin_grandprix_index',[
                'slug' => $grandprix->getSlug()
            ]);
        }

        return $this->render('admin/grand_prix/new.html.twig', [
           'myForm' => $form->createView()
        ]);

    }

   /**
     * @Route("/admin/grandprix/{slug}", name="admin_grandprix_show")
     *
     * @return Response
     */
    public function show($slug, GrandPrix $grandprix){

        //$ad = $repo->findOneBySlug($slug);

        return $this->render('admin/grand_prix/show.html.twig',[
          'grandprix' => $grandprix
        ]);

    }

}
