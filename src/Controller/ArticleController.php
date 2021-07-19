<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="create_article", methods={"POST"})
     */
    public function createArticle(Request $request, SerializerInterface $serializer)
    {
        $data = $request->getContent();
        $article = $serializer->deserialize($data, 'App\Entity\Article', 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/article/{id}", name="show_article", methods={"GET"})
     */
    public function showArticle(Article $article, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($article, 'json', SerializationContext::create()->setGroups(['detail']));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/articles", name="show_articles", methods={"GET"})
     */
    public function showArticles(ArticleRepository $articleRepository, SerializerInterface $serializer)
    {
        $articles = $articleRepository->findAll();

        $data = $serializer->serialize($articles, 'json', SerializationContext::create()->setGroups(['list']));

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
