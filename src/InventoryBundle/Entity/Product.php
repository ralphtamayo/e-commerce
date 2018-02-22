<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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

	/**
	 * @ORM\Column(type="string")
	 *
	 * @Assert\NotBlank(message="Please upload the product image as a (png/jpg) file.")
	 * @Assert\File(maxSize="2M", maxSizeMessage="File is too large. Max of 2MB", mimeTypes={ "image/png", "image/jpg", "image/jpeg" }, mimeTypesMessage="PNG/JPG/JPEG file only")
	 */
	private $image;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setName(?string $name = null): self
	{
		$this->name = $name;

		return $this;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setDescription(?string $description = null): self
	{
		$this->description = $description;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setPrice(?string $price = null): self
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

	public function getImage()
	{
		return $this->image;
	}

	public function setImage($image)
	{
		$this->image = $image;

		return $this;
	}
}
