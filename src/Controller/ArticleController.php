<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
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

        $comments = [
            'Jow swag dit is anneleen',
            'comments over here',
        ];
        dump( $slug, $this );
        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
        ]);


    }
}

