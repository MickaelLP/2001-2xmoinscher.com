<?php
namespace App\Controller;
 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Entity\User;
 
class StaticPages extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        $titre = '2xmoinscher';
 
        return $this->render('base.html.twig', [
            'titre' => $titre
        ]);
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function voirPanier(): Response
    {
        $user = $this->getUser();
        $produits = $user->getProduits(); // Récupère les produits associés à l'utilisateur

        return $this->render('panier.html.twig', [
            'produits' => $produits,
        ]);
    }



 
}