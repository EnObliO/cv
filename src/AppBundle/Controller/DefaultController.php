<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $age = date('Y') - 1998;
        $tab = [1, 1, 2, 3, 5, 8, 13];
        return $this->render('AppBundle:default:index.html.twig', [
            'firstname' => 'Matthieu',
            'age' => $age,
            'fibo' => $tab,
        ]);
    }

    /**
     * @Route("/cv", name="cv")
     */
    public function cv(Request $request)
    {
        return $this->render('AppBundle:cv:cv.html.twig');
    }

    /**
     * @Route("/cv_update", name="cv_update")
     */
    public function update(Request $request)
    {
        return $this->render('AppBundle:cv:update.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(Request $request)
    {
        return $this->render('AppBundle:cv:blog.html.twig');
    }
}
