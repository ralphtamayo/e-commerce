<?php
namespace CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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

    public function getId(): ?string
	{
		return $this->id;
	}

	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	public function setFirstName(?string $firstName): self
	{
		$this->firstName = $firstName;

		return $this;
	}

	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	public function setLastName(?string $lastName): self
	{
		$this->lastName = $lastName;

		return $this;
	}
}