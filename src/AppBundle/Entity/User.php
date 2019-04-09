<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->address = new ArrayCollection();
        $this->cart = new ArrayCollection();
        $this->order = new ArrayCollection();
    }

    /**
     * One user has many cart. This is the inverse side.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Cart", mappedBy="user")
     */
    private $cart;

    /**
     * One user has many order. This is the inverse side.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Orders", mappedBy="user")
     */
    private $order;

    /**
     * One user has many address. This is the inverse side.
     * @ORM\OneToMany(targetEntity="AddressBundle\Entity\Address", mappedBy="user")
     */
    private $address;

    /**
     * Add address
     *
     * @param \AddressBundle\Entity\Address $address
     *
     * @return User
     */
    public function addAddress(\AddressBundle\Entity\Address $address)
    {
        $this->address[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \AddressBundle\Entity\Address $address
     */
    public function removeAddress(\AddressBundle\Entity\Address $address)
    {
        $this->address->removeElement($address);
    }

    /**
     * Get address
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add cart
     *
     * @param \AppBundle\Entity\Cart $cart
     *
     * @return User
     */
    public function addCart(\AppBundle\Entity\Cart $cart)
    {
        $this->cart[] = $cart;

        return $this;
    }

    /**
     * Remove cart
     *
     * @param \AppBundle\Entity\Cart $cart
     */
    public function removeCart(\AppBundle\Entity\Cart $cart)
    {
        $this->cart->removeElement($cart);
    }

    /**
     * Get cart
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCart()
    {
        return $this->cart;
    }
}
