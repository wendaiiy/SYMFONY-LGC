<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategorieController extends AbstractController
{
    #[Route('/addManuelcategorie', name: 'app_categorie')]
    public function addCategorie(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        //Pour créer une catégorie
        $categorie = new Categorie(); 
        $categorie->setNom("Meuble"); 
        $categorie->setDescription("une description d'une catégorie");
        $em->persist($categorie);
        $em->flush();
        return $this->render('categorie/index.html.twig', [            
        ]);
    }

    #[Route('/listecategorie', name: 'list_categorie')]
    public function listCategorie(ManagerRegistry $doctrine): Response
    {
        //récupérer la liste des catégories
        $cats = $doctrine->getRepository(Categorie::class)->findAll();
        return $this->render('categorie/list.html.twig', [
            'cats' => $cats
        ]);
    }

    // #[Route('/categorie/{id}', name: 'one_categorie')]
    // public function afficherCategorie(ManagerRegistry $doctrine, Categorie $cat): Response
    // {
    //      $cat = $doctrine->getRepository(Categorie::class)->find(2);
    //     //récupérer un catégorie via son id avec getRepository        
    //     return $this->render('categorie/categorie.html.twig', [
    //         'cat' => $cat
    //     ]);
    // }

    #[Route('/categorie/{id}', name: 'onee_categorie')]
    public function afficherCategorie(Categorie $cat): Response
    {
        //récupérer un catégorie via son id avec getRepository        
        return $this->render('categorie/categorie.html.twig', [
            'cat' => $cat
        ]);
    }

    //Modifier une categorie
    #[Route('/editCategorie/{id}', name: 'edit_categorie')]
    public function modifCategorie(ManagerRegistry $doctrine, Categorie $cat, Request $req): Response
    {
       
        $form = $this->createForm(CategorieType::class, $cat);
        $form->handleRequest($req); 
        if($form->isSubmitted() && $form->isValid()){
            $em= $doctrine->getManager();
            $em->persist($cat);
            $em->flush();
            return $this->redirectToRoute('list_categorie');
        }
        return $this->render('categorie/edit.html.twig', [
            'form' => $form->createView()
        ]);
                
        
    }

    //  Modification via le getRepository
    // #[Route('/editCategorieM2/{id}', name: 'editm2_categorie')]
    // public function modifCategorie(ManagerRegistry $doctrine, Categorie $cat): Response
    // {
              
    //     $em = $doctrine->getManager();
    //     $cat = $doctrine->getRepository(Categorie::class)->find(2);
    //     $cat->setNom("Bricolage");
    //     $cat->setDescription("marteaux, visse et clous");
    //     $em->flush();
    //     return $this->redirectRoute('list_categorie');
    // }
       
    //Supprimer une categorie
    #[Route('/deleteCategorie/{id}', name: 'delete_categorie')]
    public function supprimerCategorie(ManagerRegistry $doctrine, Categorie $cat): Response
    {              
        $em = $doctrine->getManager();
        $em->remove($cat);
        //Sauvegarder l'objet dans la BDD
        $em->flush();
        
        return $this->redirectToRoute('list_categorie');
    }

    // Ajout d'une catégorie
    #[Route('/addcategorie', name: 'add_categorie')]
    #[IsGranted("ROLE_ADMIN")]
    // afin de pouvoir laisser les role avec acces à une ressource en particulier exemple pour créer des articles on va utiliser la commande ci dessous
    //  #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_CLIENT")'))]
    public function addFormCategorie(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $catego = new Categorie();

        $form = $this->createForm(CategorieType::class, $catego);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($catego);
            $em->flush();
            return $this->redirectToRoute('list_categorie');
        }
        return $this->render('categorie/add.html.twig', [
            'form'=>$form
        ]);
    }


}
