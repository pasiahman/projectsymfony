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
use AddressBundle\Entity\Address;
use AppBundle\Entity\Orders;
use AppBundle\Entity\OrderDetails;

class OrderController extends Controller
{
    /**
     * @Route("/order", name="order_index")
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

        $order_id = $request->get('order_id');

        $order = $this->getDoctrine()->getRepository(Orders::class)->findOneBy(['user' => $user, 'id' => $order_id]);
        $continue_link = $this->generateUrl('homepage');

        return $this->render('order/index.html.twig', array(
            'order' => $order,
            'continue_link' => $continue_link,
            'user' => $user,
        ));
    }

    /**
     * @Route("/order/add", name="order_add")
     * @Method({"POST"})
     */
    public function orderAddAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        // existing cart
        $cart = $this->getDoctrine()->getRepository(Cart::class)->findOneBy(['user' => $user, 'isOrdered' => false]);
        
        $address_id = $request->get("address_id");
        $payment = $request->get("payment");

        $repository = $this->getDoctrine()->getRepository(Address::class);
        $address = $repository->find($address_id);

        $refrence = $this->str_random(9);

        $em = $this->getDoctrine()->getManager();
        $total_order = 0;
        if($cart){
            $order = new Orders();
            $order->setRefrence($refrence);
            $order->setStatus("Pending");
            $order->setPayment($payment);
            $order->setAddress($address);
            $order->setUser($user);
            $order->setDateAdd(new \DateTime());
            $order->setDateUpd(new \DateTime());

            $cartProduct = $cart->getCartProduct();
            foreach ($cartProduct as $cartProd) {
                $quantity = $cartProd->getQuantity();
                $product = $cartProd->getProduct();
                
                $price = $product->getPrice();
                $subtotal = $quantity*$price;

                $orderDetails = new OrderDetails;
                $orderDetails->setProductName($product->getProductName());
                $orderDetails->setQuantity($quantity);
                $orderDetails->setPrice($price);
                $orderDetails->setSubtotal($subtotal);
                $orderDetails->setDateAdd(new \DateTime());
                $orderDetails->setDateUpd(new \DateTime());
                $orderDetails->setOrder($order);
                $orderDetails->setProduct($product);

                $em->persist($orderDetails);
                $total_order += $subtotal;
            }
            $order->setTotalOrder($total_order);
            $em->persist($order);
            $cart->setIsOrdered(1);
            $em->persist($cart);
            $em->flush();
        }
        
        return $this->redirectToRoute('order_index', array('order_id' => $order->getId()));
    }

    private function str_random($length = 16)
    {
        $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
