<?php

namespace App\Controller;


use App\Entity\Campus;
use App\Entity\Ville;
use App\Form\CampusType;
use App\Form\VilleType;
use App\Repository\CampusRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/campus", name="admin_campus")
     */
    public function allCampus(Request $request, CampusRepository $repository): Response
    {
        $campus = new Campus();
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($campus);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin_campus');
        }

        $allCampus = $repository->findAll();
        return $this->render('admin/allCampus.html.twig', [
            "campus" => $allCampus,
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/campus/modify/{id}", name="campus_modify")
     */
    public function modify(Request $request, $id, CampusRepository $repository): Response
    {
        if($repository->find($id)) {
            $campus = $repository->find($id);
            $form = $this->createForm(CampusType::class, $campus);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($campus);
                $entityManager->flush();
                // do anything else you need here, like send an email

                return $this->redirectToRoute('admin_campus');
            }

            return $this->render('admin/modifyCampus.html.twig', [
                'campus' => $campus,
                'registrationForm' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/admin/campus/suppress/{id}", name="campus_suppress")
     */
    public function suppress(Request $request, $id, CampusRepository $repository): Response
    {
        if($repository->find($id)){
            $entityManager = $this->getDoctrine()->getManager();
            $campus = $repository->find($id);
            $entityManager->remove($campus);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_campus');
    }

    /**
     * @Route("/admin/villes", name="admin_villes")
     */
    public function allVille(Request $request, VilleRepository $repository): Response
    {
        $ville = new Ville();
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ville);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin_villes');
        }

        $allVilles = $repository->findAll();
        return $this->render('admin/allVilles.html.twig', [
            "Villes" => $allVilles,
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/villes/suppress/{id}", name="villes_suppress")
     */
    public function suppres(Request $request, $id, VilleRepository $repository): Response
    {
        if($repository->find($id)){
            $entityManager = $this->getDoctrine()->getManager();
            $ville = $repository->find($id);
            $entityManager->remove($ville);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_villes');
    }

    /**
     * @Route("/admin/villes/modify/{id}", name="villes_modify")
     */
    public function modif(Request $request, $id, VilleRepository $repository): Response
    {
        if($repository->find($id)) {
            $ville = $repository->find($id);
            $form = $this->createForm(VilleType::class, $ville);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($ville);
                $entityManager->flush();
                // do anything else you need here, like send an email

                return $this->redirectToRoute('admin_villes');
            }

            return $this->render('admin/modifyVille.html.twig', [
                'ville' => $ville,
                'registrationForm' => $form->createView(),
            ]);
        }
    }
}
