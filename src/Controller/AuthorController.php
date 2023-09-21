<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AuthorController extends AbstractController
{
    #[Route('/add_author_page', name: 'open_add_author_page')]
    public function index()
    {
        return $this->render("addAuthorPage/addAuthorPage.html.twig", ["status" => null]);
    }


    #[Route('/add_author', name: 'add_author')]
    public function addAuthor(EntityManagerInterface $entityManager, Request $request)
    {
        $name = $request->request->get('name');
        $surname = $request->request->get('surname');

        try {
            $author = new Author();
            $author->setName($name)
                   ->setSurname($surname);
    
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->render("addAuthorPage/addAuthorPage.html.twig", ["status" => "Автор успешно добавлен!"]);
        } catch(\Doctrine\ORM\ORMException $e) {
            return $this->redirect($request->headers->get('referer'));
        }
    }

    // #[Route('/author', name: 'open_author_page')]
    // public function index() {
    //     return $this->render("authorPage/authorPage.html.twig", []);
    // }
}