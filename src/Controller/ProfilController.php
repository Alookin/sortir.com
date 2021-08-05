<?php

namespace App\Controller;

use App\Form\ProfilType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController

{
    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function index(): Response
    {
        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    /**
     * @Route("/profil/{id}/modify", name="profil_modify")
     */
    public function modify(Request $request, $id, UtilisateurRepository $repository): Response
    {
        if($repository->find($id)) {
            $utilisateur = $repository->find($id);
            $form = $this->createForm(ProfilType::class, $utilisateur);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($utilisateur);
                $entityManager->flush();

                return $this->redirectToRoute('profil', array(
                    'id' => $id
                ));
            }

            return $this->render('profil/modifyProfil.html.twig', [
                'utilisateur' => $utilisateur,
                'profilForm' => $form->createView(),
            ]);
        }

    }
}
