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
        $order_link = $this->generateUrl('order_add');

        return $this->render('cart/index.html.twig', array(
            'cart' => $cart,
            'continue_link' => $continue_link,
            'order_link' => $order_link,
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

        // existing cart
        $cart = $this->getDoctrine()->getRepository(Cart::class)->findOneBy(['user' => $user, 'isOrdered' => false]);
        
        $qty = $request->get("quantity");
        $product_id = $request->get("product_id");

        $repository = $this->getDoctrine()->getRepository(Products::class);
        $product = $repository->find($product_id);

        $em = $this->getDoctrine()->getManager();
        
        if($cart){
            $cart->setDateUpd(new \DateTime());

            $cartProduct = $this->getDoctrine()->getRepository(CartProduct::class)->findOneBy(['product' => $product, 'cart' => $cart]);
            if($cartProduct){
                $quantity = $cartProduct->getQuantity();
                $quantity = $quantity+$qty;
                $cartProduct->setQuantity($quantity);
                $em->flush();
            } else {
                $cartProduct = new CartProduct();
                $cartProduct->setProduct($product);
                $cartProduct->setQuantity($qty);
                $cartProduct->setCart($cart);
                $cartProduct->setDateAdd(new \DateTime());
                $cartProduct->setDateUpd(new \DateTime());
                $em->persist($cartProduct);
                $em->flush();
            }
        } else {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setIsOrdered(0);
            $cart->setDateAdd(new \DateTime());
            $cart->setDateUpd(new \DateTime());

            $cartProduct = new CartProduct();
            $cartProduct->setProduct($product);
            $cartProduct->setQuantity($qty);
            $cartProduct->setCart($cart);
            $cartProduct->setDateAdd(new \DateTime());
            $cartProduct->setDateUpd(new \DateTime());

            $em->persist($cart);
            $em->persist($cartProduct);
            $em->flush();
        }
        
        return $this->redirectToRoute('cart_index');
    }
}
