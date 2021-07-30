<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route("/api",name="api_")
 */

class DefaultController extends AbstractFOSRestController
{
    /**
     * @Get("/articles/list", name="list_articles")
     * @RequestParam(
     *     name="search",
     *     requirements="[a-zA-Z0-9]",
     *     default=null,
     *     nullable=true,
     *     description="Search query to look for articles"
     * )
     */
    public function listAction($search)
    {
        //…
    }
}
