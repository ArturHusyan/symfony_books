<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    #[Route('/add_book/{author_id}', name: 'add_book')]
    public function addBook(EntityManagerInterface $entityManager, Request $request, $author_id)
    {
        $title = $request->request->get('title');
        $author = $entityManager->getRepository(Author::class)->find($author_id);

        try {
            $book = new Book();
            $book->setTitle($title)
                 ->setAuthor($author);
            
            $entityManager->persist($book);
            $entityManager->flush();
            
            $authorBooks = $entityManager->getRepository(Book::class)->findBy(['author' => $author_id], ['title' => 'ASC']);
            
            return $this->render("authorPage/authorPage.html.twig", ["author" => $author, "authorBooks" => $authorBooks, "status" => "Книга успешно добавлена!"]);
     
        } catch(\Doctrine\ORM\ORMException $e) {
            return $this->redirect($request->headers->get('referer'));
        }
    }
   
}