<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Book;
 
/**
 * @Route("/api", name="api_")
 */
class BooksController extends AbstractController
{
    /**
     * @Route("/book", name="book_index", methods={"GET"})
     */
    public function index(): Response
    {
        $products = $this->getDoctrine()
            ->getRepository(Book::class)
            ->findAll();
 
        $data = [];
 
        foreach ($products as $product) {
           $data[] = [
               'id' => $product->getId(),
               'name' => $product->getName(),
               'description' => $product->getDescription(),
           ];
        }
 
 
        return $this->json($data);
    }
 
    /**
     * @Route("/book", name="book_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
 
        $book = new Book();
        $book->setName($request->request->get('name'));
        $book->setDescription($request->request->get('description'));
 
        $entityManager->persist($book);
        $entityManager->flush();
 
        return $this->json('Created new book successfully with id ' . $book->getId());
    }
 
    /**
     * @Route("/book/{id}", name="book_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $book = $this->getDoctrine()
            ->getRepository(Book::class)
            ->find($id);
 
        if (!$book) {
 
            return $this->json('No book found for id' . $id, 404);
        }
 
        $data =  [
            'id' => $book->getId(),
            'name' => $book->getName(),
            'description' => $book->getDescription(),
        ];
         
        return $this->json($data);
    }
 
    /**
     * @Route("/book/{id}", name="book_edit", methods={"PUT"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
 
        if (!$book) {
            return $this->json('No book found for id' . $id, 404);
        }
 
        $book->setName($request->request->get('name'));
        $book->setDescription($request->request->get('description'));
        $entityManager->flush();
 
        $data =  [
            'id' => $book->getId(),
            'name' => $book->getName(),
            'description' => $book->getDescription(),
        ];
         
        return $this->json($data);
    }
 
    /**
     * @Route("/book/{id}", name="book_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
 
        if (!$book) {
            return $this->json('No book found for id' . $id, 404);
        }
 
        $entityManager->remove($book);
        $entityManager->flush();
 
        return $this->json('Deleted a book successfully with id ' . $id);
    }
 
 
}