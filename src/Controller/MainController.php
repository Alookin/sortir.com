<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="main_home")
     */
    public function home(SortieRepository $repository)
    {
        $sorties = $repository->findAll();
        return $this->render('main/home.html.twig', [
            'sorties' => $sorties,
        ]);
    }

}