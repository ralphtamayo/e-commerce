<?php

namespace SalesBundle\Entity;

use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Payment
 *
 * @ORM\Table(name="sales_payment")
 * @ORM\Entity(repositoryClass="SalesBundle\Repository\PaymentRepository")
 */
class Payment
{
	const PAYMENT_MODE_BDO = 'BDO';
	const PAYMENT_MODE_CEBUANA = 'Cebuana';
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(name="paymentMode", type="string", length=255)
	 */
	private $paymentMode;

	/**
	 * @ORM\Column(name="cardNumber", type="string", length=255, nullable=true)
	 */
	private $cardNumber;

	/**
	 * @ORM\Column(name="expirationMonth", type="string", length=255, nullable=true)
	 */
	private $expirationMonth;

	/**
	 * @ORM\Column(name="expirationYear", type="string", length=255, nullable=true)
	 */
	private $expirationYear;

	/**
	 * @ORM\Column(name="referenceNumber", type="string", length=255, nullable=true)
	 */
	private $referenceNumber;
	
	/**
	 * @ORM\OneToOne(targetEntity="Cart", inversedBy="payment")
	 */
	private $cart;

	/**
	 * @ORM\Column(name="total", type="decimal", scale=2, precision=13)
	 */
   private $total;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setPaymentMode(?string $paymentMode = null): self
	{
		$this->paymentMode = $paymentMode;

		return $this;
	}

	public function getPaymentMode(): ?string
	{
		return $this->paymentMode;
	}

	public function setCart(?Cart $cart = null): self
	{
		$this->cart = $cart;

		return $this;
	}

	public function getCart(): ?Cart
	{
		return $this->cart;
	}

	public function setCardNumber(?string $cardNumber = null): self
	{
		$this->cardNumber = $cardNumber;

		return $this;
	}

	public function getCardNumber(): ?string
	{
		return $this->cardNumber;
	}

	public function setExpirationMonth(?string $expirationMonth = null): self
	{
		$this->expirationMonth = $expirationMonth;

		return $this;
	}

	public function getExpirationMonth(): ?string
	{
		return $this->expirationMonth;
	}

	public function setExpirationYear(?string $expirationYear = null): self
	{
		$this->expirationYear = $expirationYear;

		return $this;
	}

	public function getExpirationYear(): ?string
	{
		return $this->expirationYear;
	}

	public function setReferenceNumber(?string $referenceNumber = null): self
	{
		$this->referenceNumber = $referenceNumber;

		return $this;
	}

	public function getReferenceNumber(): ?string
	{
		return $this->referenceNumber;
	}

	public function setTotal(?string $total = null): self
	{
		$this->total = $total;

		return $this;
	}

	public function getTotal(): ?string
	{
		return $this->total;
	}
}