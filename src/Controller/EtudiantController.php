<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    #[IsGranted('ROLE_ADMIN')]
    public function addEtudiant(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {
        $em = $doctrine->getManager();
        $etudiant = new Etudiant();

        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $fichier = $form->get('fichier')->getData(); 
            if($fichier){
                //recupère des infos sur le chemin plus précissement  le nom du fichier
                $originalFilename = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                //Recupère le nom du fichier sans extension
                $saveFilename = $slugger->slug($originalFilename);
                //formter le fichier en ajoutant un nombre aléatoire afin de distinguer 2 fishier avec le même nom
                $newFilename = $saveFilename . '-'. uniqid(). '.' . $fichier->guessExtension();
                $fichier->move(
                    $this->getParameter('etudiant_directory'), $newFilename
                );
                $etudiant->setFichier($newFilename); 
            }

            $em->persist($etudiant);
            $em->flush();
            return $this->redirectToRoute('app_etudiant');
        }
        return $this->render('etudiant/add.html.twig', [
            'formet'=>$form
        ]);
    }

    #[Route('/editetudiant/{id}', name: 'edit_etudiant')]
    public function editEtudiant(ManagerRegistry $doctrine, Etudiant $etudiant, Request $req, SluggerInterface $slugger): Response
    {
            $form = $this->createForm(EtudiantType::class, $etudiant); 
            $form->handleRequest($req);
            if($form->isSubmitted() && $form->isValid()){
                $fichier = $form->get('fichier')->getData(); 
                if($fichier){
                //recupère des infos sur le chemin plus précissement  le nom du fichier
                $originalFilename = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                //Recupère le nom du fichier sans extension
                $saveFilename = $slugger->slug($originalFilename);
                //formter le fichier en ajoutant un nombre aléatoire afin de distinguer 2 fishier avec le même nom
                $newFilename = $saveFilename . '-'. uniqid(). '.' . $fichier->guessExtension();
                $fichier->move(
                    $this->getParameter('etudiant_directory'), $newFilename
                );
                $etudiant->setFichier($newFilename); 
            }
                $em = $doctrine->getManager();
                $em->persist($etudiant);
                $em->flush();            
                return $this->redirectToRoute('app_etudiant');
            }      
         
            return $this->render('etudiant/edit.html.twig', [
                'formet' => $form->createView()
            ]);
      
    }

    #[Route('/deleteetudiant/{id}', name: 'delete_etudiant')]
    public function deleteEtudiant(ManagerRegistry $doctrine, Etudiant $et) : Response
    {
        $em = $doctrine->getManager();
        $em->remove($et);
        $em->flush(); 

        return $this->redirectToRoute('app_etudiant');
    }
}