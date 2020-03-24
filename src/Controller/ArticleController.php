<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/") Response
     */
    public function homepage() {
        return new Response('OMG! My first page already!');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug) {
        return new Response(sprintf(
            'Future page to show the article: %s',
            $slug
        ));

    }
}