<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function listEtudiant(ManagerRegistry $doctrine)
    {
        $etudiants = $doctrine->getRepository(Etudiant::class)->findAll();
        return $this->render('etudiant/list.html.twig', [
            'etudiants'=> $etudiants
        ]);
    }


    #[Route('/addetudiant', name: 'add_etudiant')]
    public function addEtudiant(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $etudiant = new Etudiant();

        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($etudiant);
            $em->flush();
            return $this->redirectToRoute('app_etudiant');
        }
        return $this->render('etudiant/add.html.twig', [
            'formet'=>$form
        ]);
    }

    #[Route('/editetudiant/{id}', name: 'edit_etudiant')]
    public function editEtudiant(ManagerRegistry $doctrine, Etudiant $etudiant): Response
    {
                  
            $em = $doctrine->getManager();
            $etudiant->setNom("Maurel");
            $etudiant->setPrenom("Charlie");
            $etudiant->setEtude("Art");
            $em->flush();            
            return $this->redirectToRoute('app_etudiant');
      
    }
}