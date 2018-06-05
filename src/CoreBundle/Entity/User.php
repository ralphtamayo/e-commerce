<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="core_user")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 * @Assert\NotBlank(message="user.firstName.blank")
	 * @Assert\Regex(pattern="/^[\p{L}'][ \p{L}'-]*[\p{L}]$/u", message="user.firstName.regex")
	 */
	private $firstName;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 * @Assert\NotBlank(message="user.lastName.blank")
	 * @Assert\Regex(pattern="/^[\p{L}'][ \p{L}'-]*[\p{L}]$/u", message="user.lastName.regex")
	 */
	private $lastName;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 * @Assert\NotBlank(message="user.address.blank")
	 */
	private $address;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 * @Assert\NotBlank(message="user.contactDetails.blank")
	 */
	private $contactDetails;

	/**
	 * @ORM\OneToMany(targetEntity="SalesBundle\Entity\Cart", mappedBy="user")
	 */
	private $carts;

	public function __construct()
	{
		parent::__construct();

		$this->carts = new ArrayCollection();
	}

	public function getId(): ?string
	{
		return $this->id;
	}

	public function setFirstName(?string $firstName = null): self
	{
		$this->firstName = $firstName;

		return $this;
	}

	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	public function setLastName(?string $lastName = null): self
	{
		$this->lastName = $lastName;

		return $this;
	}

	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	public function setAddress(?string $address = null): self
	{
		$this->address = $address;

		return $this;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setContactDetails(?string $contactDetails = null): self
	{
		$this->contactDetails = $contactDetails;

		return $this;
	}

	public function getContactDetails(): ?string
	{
		return $this->contactDetails;
	}

	public function getCarts()
	{
		return $this->carts;
	}

	public function setCarts($carts = null): self
	{
		$this->carts = $carts;

		return $this;
	}

	public function addRole($role)
	{
		if (is_array($this->roles)) {
			if (!in_array($role, $this->roles, true)) {
				$this->roles[] = $role;
			}
		}

		return $this;
	}
}
