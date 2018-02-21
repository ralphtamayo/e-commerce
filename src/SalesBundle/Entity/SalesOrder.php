<?php

namespace SalesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cart
 *
 * @ORM\Table(name="sales_sales_order")
 * @ORM\Entity(repositoryClass="SalesBundle\Repository\SalesOrderRepository")
 */
class SalesOrder
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\OneToOne(targetEntity="CoreBundle\Entity\User", inversedBy="cart")
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart", cascade={"persist", "remove"})
	 */
	private $items;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setUser(?User $user): self
	{
		$this->user = $user;

		return $this;
	}

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function getItems(): DoctrineCollection
	{
		return $this->items;
	}

	public function setItems(DoctrineCollection $items): self
	{
		$this->items = $items;

		foreach ($items as $item) {
			$item->setCart($this);
		}

		return $this;
	}

}