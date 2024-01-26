<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;

class CategorieController extends AbstractController
{
    #[Route('/addcategorie', name: 'app_categorie')]
    public function addCategorie(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManger();
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
    public function modifCategorie(ManagerRegistry $doctrine, Categorie $cat): Response
    {
              
        $em = $doctrine->getManager();
        $cat->setNom("matelas");
        $cat->setDescription("list des matelas");
        //Sauvegarder l'objet dans la BDD
        $em->flush();
        
        return $this->redirectToRoute('list_categorie');
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


}
