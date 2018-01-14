<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;

use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{
    /**
     * @Route("/product_add", name="product_add")
     */
    public function addProduct(Request $request){
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $prodToSave = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($prodToSave);
                $em->flush();
            }

        return $this->render('AppBundle:products:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/{id}", name="show_product")
     */
    public function found_product($id){
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
        return $this->render('AppBundle:products:product.html.twig', [
            'product' => $product
        ]);
    }
    /**
     * @Route(
     *     "/products/{prop}/{dir}",
     *     name="products",
     *     requirements={"_format": "html"},
     *     defaults={"prop": "title", "dir": "asc"}
     *  )
     */
    public function products(Request $request){
        //dump($request->getRequestFormat());
        $form = $this->createFormBuilder()
            ->add('search', TextType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
        $search = null;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
        }

        $key = $request->get('prop');
        $dir = $request->get('dir');
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->findAllAsArray($key, $dir, $search);
        if ($request->getRequestFormat() === 'json')
            return new JsonResponse($product);
        return $this->render('AppBundle:products:products.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'key' => $key,
            'dir' => $dir
        ]);
    }
}