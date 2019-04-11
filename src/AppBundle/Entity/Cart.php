<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartRepository")
 */
class Cart
{
    public function __construct()
    {
        $this->cartProduct = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Many cart have one user. This is the owning side.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="cart")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * One cart has many cartProduct. This is the inverse side.
     * @ORM\OneToMany(targetEntity="CartProduct", mappedBy="cart")
     */
    private $cartProduct;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_ordered", type="boolean")
     */
    private $isOrdered;

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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isOrdered
     *
     * @param boolean $isOrdered
     *
     * @return Cart
     */
    public function setIsOrdered($isOrdered)
    {
        $this->isOrdered = $isOrdered;

        return $this;
    }

    /**
     * Get isOrdered
     *
     * @return boolean
     */
    public function getIsOrdered()
    {
        return $this->isOrdered;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return Cart
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
     * @return Cart
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

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Cart
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add cartProduct
     *
     * @param \AppBundle\Entity\CartProduct $cartProduct
     *
     * @return Cart
     */
    public function addCartProduct(\AppBundle\Entity\CartProduct $cartProduct)
    {
        $this->cartProduct[] = $cartProduct;

        return $this;
    }

    /**
     * Remove cartProduct
     *
     * @param \AppBundle\Entity\CartProduct $cartProduct
     */
    public function removeCartProduct(\AppBundle\Entity\CartProduct $cartProduct)
    {
        $this->cartProduct->removeElement($cartProduct);
    }

    /**
     * Get cartProduct
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCartProduct()
    {
        return $this->cartProduct;
    }
}
