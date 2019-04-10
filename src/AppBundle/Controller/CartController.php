<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Cart;
use AppBundle\Entity\CartProduct;
use AppBundle\Entity\User;
use ProductBundle\Entity\Products;

class CartController extends Controller
{
    /**
     * @Route("/cart", name="cart_index")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        // $validator = $this->get('validator');
        // dump($validator);
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        $cart = $this->getDoctrine()->getRepository(Cart::class)->findOneBy(['user' => $user, 'isOrdered' => false]);
        $continue_link = $this->generateUrl('homepage');

        return $this->render('cart/index.html.twig', array(
            'cart' => $cart,
            'continue_link' => $continue_link,
            'user' => $user,
        ));
    }

    /**
     * @Route("/cart/add", name="cart_add")
     * @Method({"POST"})
     */
    public function cartAddAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        
        $quantity = $request->get("quantity");
        $product_id = $request->get("product_id");

        $repository = $this->getDoctrine()->getRepository(Products::class);
        $product = $repository->find($product_id);
        
        $cart = new Cart();
        $cart->setUser($user);
        $cart->setIsOrdered(0);
        $cart->setDateAdd(new \DateTime());
        $cart->setDateUpd(new \DateTime());

        // $cart->getCartProduct()->add($cartProduct);

        // $this->getDoctrine()->persist($cart);
        // $this->getDoctrine()->flush();

        $em = $this->getDoctrine()->getManager();
        $em->persist($cart);
        // $em->flush();

        $cartProduct = new CartProduct();
        $cartProduct->setProduct($product);
        $cartProduct->setQuantity($quantity);
        $cartProduct->setCart($cart);
        $cartProduct->setDateAdd(new \DateTime());
        $cartProduct->setDateUpd(new \DateTime());

        // $em = $this->getDoctrine()->getManager();
        $em->persist($cartProduct);
        $em->flush();

        // return $this->view($this->get('otten.factory.cart_view')->createCartView($cart), 200);
        return $this->redirectToRoute('cart_index');
    }
}
