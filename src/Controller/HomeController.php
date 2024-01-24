<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')] // il est possible d'ajouter un 3ème paramètres avec methods:['GET', 'POST', 'DELETE']. mais on va laisser symfony faire le traitement directement
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            
        ]);
    }

    #[Route('/pageTexte/{id?}', name: 'app_pageTexte')]
    public function page($id): Response // ici response est la signature alors on retourne une réponse
    {
        return new Response("Hello tous le monde!". $id);
        // ici on ajoute n'importe qu'elle id apres et il s'affiche
        // avec le ? on idique le l'id est optionnelle, sinon il est obligatoire et la pge ne va pas s'afficher. 
    }

    // Rediriger vers une autre pages web possible de le faire grâce à la fonction abstract
    #[Route('/google', name: 'google_redirect')]
    public function google_redirect(): Response 
    {
        return $this->redirect('https://www.google.fr/');
    }

    //Redirection vers une page de notre site
    #[Route ('/redirecthome', name: 'homeredirect_home')]
    public function redirectHome(): Response
    {
        // permet de faire la redirection sur une page de notre site on doit appeler le paramètre name de notre page indiquer dans notre Route
        return $this->redirectToRoute('app_home');
    }

    #[Route ('/home/contact', name: 'contact_home')]
    public function contact(): Response
    {
        $nom = "Boubou";
        $prenom = "Caleb";
        // permet de faire la redirection sur une page de notre site on doit appeler le paramètre name de notre page indiquer dans notre Route
        // return $this->render('home/contact.html.twig', ['n' => $nom]);
        // ou autre affichage
        return $this->render('home/contact.html.twig', compact(['prenom','nom']));
    }

    //Afficher les variables sous forme de tableau 
    #[Route ('/home/user', name: 'user_home')]
    public function afficherUser(): Response
    {
        $user = ["Jhonne", "Whitney", "Winona", "Marine"];
        return $this->render('home/user.html.twig', ['utilisateur'=> $user]);
    }
}
