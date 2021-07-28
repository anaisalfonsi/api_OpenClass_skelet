<?php

namespace App\Controller;

use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author/{id}", name="show_author")
     */
    public function showAuthor(Author $author): Response
    {
        $data = $this->get('serializer')->serialize($author, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/create-author", name="create_author", methods={"POST"})
     */
    public function createAuthor(Request $request)
    {
        $data = $request->getContent();
        $author = $this->get('serializer')->deserialize($data, 'App\Entity\Author', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }
}
