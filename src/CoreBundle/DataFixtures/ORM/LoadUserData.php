<?php

namespace CoreBundle\DataFixtures\ORM;

use CoreBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{

	public function load(ObjectManager $manager)
	{
        $userAdmin = new User();
        
		$userAdmin->setUsername('admin');
		$userAdmin->setEmail('admin@ecommerce.com');
		$userAdmin->setPlainPassword('admin');
		$userAdmin->setEnabled(true);
		$userAdmin->setRoles(array('ROLE_ADMIN'));
		$userAdmin->setFirstName('admin');
		$userAdmin->setLastName('admin');
		$userAdmin->setAddress('Manila City');
		$userAdmin->setContactDetails('0912-345-6789');

		$manager->persist($userAdmin);
		$manager->flush();
	}
}
