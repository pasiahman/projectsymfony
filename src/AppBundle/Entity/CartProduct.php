<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartProduct
 *
 * @ORM\Table(name="cart_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartProductRepository")
 */
class CartProduct
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_cart", type="integer")
     */
    private $idCart;

    /**
     * @var int
     *
     * @ORM\Column(name="id_product", type="integer")
     */
    private $idProduct;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idCart
     *
     * @param integer $idCart
     *
     * @return CartProduct
     */
    public function setIdCart($idCart)
    {
        $this->idCart = $idCart;

        return $this;
    }

    /**
     * Get idCart
     *
     * @return int
     */
    public function getIdCart()
    {
        return $this->idCart;
    }

    /**
     * Set idProduct
     *
     * @param integer $idProduct
     *
     * @return CartProduct
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get idProduct
     *
     * @return int
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CartProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return CartProduct
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set dateUpd
     *
     * @param \DateTime $dateUpd
     *
     * @return CartProduct
     */
    public function setDateUpd($dateUpd)
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd
     *
     * @return \DateTime
     */
    public function getDateUpd()
    {
        return $this->dateUpd;
    }
}

