<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('', name: 'open_main_page')]
    public function getAllAuthorsList(EntityManagerInterface $entityManager)
    {
        $authorsList = $entityManager->getRepository(Author::class)->findAll();

        return $this->render("mainPage/mainPage.html.twig", ["authorsList" => $authorsList]);
    }
}
