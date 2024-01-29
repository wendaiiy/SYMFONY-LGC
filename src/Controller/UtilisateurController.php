<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/login', name: 'login_utilisateur')]
    public function login(): Response
    {
        return $this->render('utilisateur/login.html.twig');
    }

    #[Route('/register', name: 'register_utilisateur')]
    public function addUtilisateur(Request $req, UserPasswordHasherInterface $hash, ManagerRegistry $doc): Response
    {
        $user = new Utilisateur;
        $form = $this->createForm(UtilisateurType::class);
        $form->handleRequest($req); 
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword($hash->hashPassword($user, $form->get('password')->getData()));
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setEmail($form->get('email')->getData());
            $user->setRoles($form->get('roles')->getData()); 

            $em= $doc->getManager();
            $em->persist($user);
            $em->flush(); 

            return $this->redirectToRoute('utilisateur/login.html.twig');
        }

        return $this->render('utilisateur/register.html.twig', [
            'formuser'=> $form
        ]);
    }
}
