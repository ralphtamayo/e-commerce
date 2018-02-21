<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Inventory
 *
 * @ORM\Table(name="inventory_inventory")
 * @ORM\Entity(repositoryClass="InventoryBundle\Repository\InventoryRepository")
 */
class Inventory
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(name="quantity", type="integer")
	 * @Assert\GreaterThan(0)
	 */
	private $quantity;

	/**
	 * One Inventory has One Product.
	 * @ORM\OneToOne(targetEntity="Product", inversedBy="inventory")
	 */
	private $product;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setQuantity(?string $quantity): self
	{
		$this->quantity = $quantity;

		return $this;
	}

	public function addQuantity(?string $quantity): self
	{
		$this->quantity += $quantity;

		return $this;
	}

	public function deductQuantity(?string $quantity): self
	{
		$this->quantity -= $quantity;

		return $this;
	}

	public function getQuantity(): ?string
	{
		return $this->quantity;
	}

	public function setProduct(?Product $product = null): self
	{
		$this->product = $product;

		return $this;
	}

	public function getProduct(): ?Product
	{
		return $this->product;
	}
}
