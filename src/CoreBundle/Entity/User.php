<?php
namespace CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
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

	public function getId(): ?string
	{
		return $this->id;
	}

	public function setFirstName(?string $firstName): self
	{
		$this->firstName = $firstName;

		return $this;
	}

	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	public function setLastName(?string $lastName): self
	{
		$this->lastName = $lastName;

		return $this;
	}

	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	public function setAddress(?string $address): self
	{
		$this->address = $address;

		return $this;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function setContactDetails(?string $contactDetails): self
	{
		$this->contactDetails = $contactDetails;

		return $this;
	}

	public function getContactDetails(): ?string
	{
		return $this->contactDetails;
	}
}
