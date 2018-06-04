<?php

namespace SalesBundle\Entity;

use CoreBundle\Entity\User;
use InventoryBundle\Entity\Product;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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

	/**
	 * @ORM\Column(name="quantity", type="integer")
	 * @Assert\GreaterThan(0)
	 */
	private $quantity;

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

	/**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getQuantity() > $this->getProduct()->getInventory()->getQuantity()) {
            $context->buildViolation('Quantity available is not enough.')
                ->atPath('quantity')
                ->addViolation();
        }
    }
}