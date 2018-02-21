<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="inventory_product")
 * @ORM\Entity(repositoryClass="InventoryBundle\Repository\ProductRepository")
 */
class Product
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(name="name", type="string", length=255)
	 */
	private $name;

	/**
	 * @ORM\Column(name="description", type="string", length=255, nullable=true)
	 */
	private $description;

	/**
	 * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
	 */
	private $price;

	/**
	 * One Product has One Inventory.
	 * @ORM\OneToOne(targetEntity="Inventory", mappedBy="product")
	 */
	private $inventory;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setName(?string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setPrice(?string $price): self
	{
		$this->price = $price;

		return $this;
	}

	public function getPrice(): ?string
	{
		return $this->price;
	}

	public function setInventory(?Inventory $inventory = null): self
	{
		$this->inventory = $inventory;

		return $this;
	}

	public function getInventory(): ?Inventory
	{
		return $this->inventory;
	}
}
