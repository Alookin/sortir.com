<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController

{
    /**
     * @Route("/create", name="ajouter")
     */
    public function create( Request $request, EntityManagerInterface $manager): Response
    {
        $sortie = new Sortie();

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $manager->persist($sortie);
            $manager->flush();

            $this->addFlash('success', 'Produit ajouté, gg bro');
            return $this->redirectToRoute('sortie_details', ['id'=>$sortie->getId()]);

        }


        return $this->render('sortie/new.html.twig', [
            'formSortie' => $sortieForm->createView()
        ]);
    }

    /**
     * @Route ("/list", name="list")
     */
    public function list(SortieRepository $sortieRepository): Response {

        $sorties = $sortieRepository->findAll();

        return $this->render('main/home.html.twig', [
            "sorties"=>$sorties
        ]);
    }

    /**
     * @Route("/details/{id}", name="sortie_details")
     */
    public function details(int $id, SortieRepository $sortieRepository): Response
    {
        $sorties = $sortieRepository->find($id);


        return $this->render('sortie/detail.html.twig', [

            "sorties" => $sorties

        ]);
    }

    /**
     * @Route("/sortie/{id}/modify", name="sortie_modify")
     */
    public function modify(Request $request, $id, SortieRepository $sortieRepository): Response
    {
        if($sortieRepository->find($id)) {
            $sortie = $sortieRepository->find($id);
            $form = $this->createForm(SortieType::class, $sortie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($sortie);
                $entityManager->flush();

                return $this->redirectToRoute('sortie_details', array(
                    'id' => $id
                ));
            }

            return $this->render('sortie/modifySortie.html.twig', [
                'sortie' => $sortie,
                'sortieForm' => $form->createView(),
            ]);
        }

    }

}