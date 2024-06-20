<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\User;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        // Vérifier si l'utilisateur est un administrateur
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }

       /**
     * @Route("/panier/{id}", name="produitAjouter")
     */
    #[Route('panier/{id}', name: 'produitAjouter', methods: ['GET'])]
    public function ajouterPanier(Produit $produit): Response
    {
        $user = $this->getUser();
        $produit->addUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $produits = $user->getProduits(); // Récupère les produits associés à l'utilisateur

        return $this->render('panier.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * @Route("/panier/Supprimer/{id}", name="produitSupprimer")
     */
    public function supprimerPanier(Produit $produit): Response
    {
        $user = $this->getUser();
        $produit->removeUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $produits = $user->getProduits(); // Récupère les produits associés à l'utilisateur

        return $this->render('panier.html.twig', [
            'produits' => $produits,
        ]);
    }


    /**
     * @Route("/produitvendu/{id}", name="produitvendu")
     */
    public function compterProduit(Produit $produit): Response
    {
        $users = $produit->getUser();
        return $this->render('produitVendu.html.twig', [
            'users' => $users,
        ]);
    }

}
