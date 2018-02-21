<?php

namespace SalesBundle\Entity;

use CoreBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cart
 *
 * @ORM\Table(name="sales_cart")
 * @ORM\Entity(repositoryClass="CartBundle\Repository\CartRepository")
 */
class Cart
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

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setUser(?User $user = null): self
	{
		$this->user = $user;

		return $this;
	}

	public function getUser(): ?User
	{
		return $this->user;
	}
}