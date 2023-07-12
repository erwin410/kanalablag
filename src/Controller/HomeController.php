<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BlagRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(BlagRepository $blagRepository): Response
    {
        $blag = $blagRepository->findAllWithCategory();

        return $this->render('home/index.html.twig', [
            'blags' => $blag,
        ]);
    }
}
