<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ProductBundle\Entity\Products;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);
        $products = $repository->findBy(
            array('active' => 1)
        );

        $cart_add = $this->generateUrl('cart_add');
        return $this->render('default/index.html.twig', array(
            'products' => $products,
            'cart_add' => $cart_add,
        ));
    }
}
