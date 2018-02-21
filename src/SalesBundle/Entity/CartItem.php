<?php

namespace SalesBundle\Entity;

use CoreBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CartItem
 *
 * @ORM\Table(name="sales_cart_item")
 * @ORM\Entity(repositoryClass="SalesBundle\Repository\CartItemRepository")
 */
class CartItem
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $cart;

	/**
	 * @ORM\ManyToOne(targetEntity="InventoryBundle\Entity\Product")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $product;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCart(): ?Cart
	{
		return $this->cart;
	}

	public function setCart(?Cart $cart): self
	{
		$this->cart = $cart;

		return $this;
	}
}