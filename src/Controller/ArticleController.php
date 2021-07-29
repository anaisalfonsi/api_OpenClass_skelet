<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 *@Route("/api",name="api_")
 */

class ArticleController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path="/article/{id}",
     *     name="show_article",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View()
     */
    public function showArticle()
    {
        $article = new Article();
        $article->setTitle("Un titre");
        $article->setContent("Un contenu");

        return $article;
    }
    /**
     * @Rest\Post(
     *     path="/article/new",
     *     name="create_article"
     * )
     * @Rest\View(StatusCode=201)
     * @ParamConverter("article", converter="fos_rest.request_body")
     */
    public function createArticle(Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($article);
        $em->flush();

        return $this->view(
            $article,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl('api_show_article', ['id' => $article->getId(), UrlGeneratorInterface::ABSOLUTE_URL])
            ]
        );
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
