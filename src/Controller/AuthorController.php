<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
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

    #[Route('/author/{id}', name: 'open_author_page')]
    public function showAuthorPage(EntityManagerInterface $entityManager, $id)
    {
        $author = $entityManager->getRepository(Author::class)->find($id);
        $authorBooks = $entityManager->getRepository(Book::class)->findBy(['author' => $id], ['title' => 'ASC']);
            return $this->render("authorPage/authorPage.html.twig", ["author" => $author, "authorBooks" => $authorBooks, "status" => null]);
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

}