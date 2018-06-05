<?php

namespace InventoryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InventoryBundle\Entity\Inventory;
use InventoryBundle\Entity\Product;

class LoadProductData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$product = new Product();

		$product->setName('Test product');
		$product->setDescription('Test description');
		$product->setPrice(24);
		$product->setImage('default_product_image.png');

		$inventory = new Inventory();

		$inventory->setQuantity(10);
		$inventory->setProduct($product);

		$manager->persist($product);
		$manager->persist($inventory);
		$manager->flush();
	}
}
