<?php

namespace SalesBundle\Entity;

use CoreBundle\Entity\User;
use InventoryBundle\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SalesOrderItem
 *
 * @ORM\Table(name="sales_sales_order_item")
 * @ORM\Entity(repositoryClass="SalesBundle\Repository\SalesOrderItemRepository")
 */
class SalesOrderItem
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="SalesOrder", inversedBy="items")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $salesOrder;

	/**
	 * @ORM\ManyToOne(targetEntity="InventoryBundle\Entity\Product")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $product;

	/**
	 * @ORM\Column(name="quantity", type="integer")
	 * @Assert\GreaterThan(0)
	 */
	private $quantity;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getSalesOrder(): ?SalesOrder
	{
		return $this->salesOrder;
	}

	public function setSalesOrder(?SalesOrder $salesOrder): self
	{
		$this->salesOrder = $salesOrder;

		return $this;
	}

	public function getProduct(): ?Product
	{
		return $this->product;
	}

	public function setProduct(?Product $product): self
	{
		$this->product = $product;

		return $this;
	}

	public function setQuantity(?string $quantity): self
	{
		$this->quantity = $quantity;

		return $this;
	}

	public function getQuantity(): ?string
	{
		return $this->quantity;
	}
}