<?php

namespace InventoryBundle\Model;

use CoreBundle\Model\BaseModel;
use InventoryBundle\Entity\Inventory;
use InventoryBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerInterface;
use CoreBundle\Utils\GeneratingUtils;

class ProductModel extends BaseModel
{
	private $container;
	private $em;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->em = $container->get('doctrine')->getManager();
	}

	public function save(Product $product, $form)
	{
		$file = $product->getImage();

		$fileName = GeneratingUtils::generateUniqueFileName().'.'.$file->guessExtension();

		$file->move(
			$this->container->getParameter('images_directory'),
			$fileName
		);

		$product->setImage($fileName);

		$inventory = new Inventory();
		$inventory->setProduct($product);
		$inventory->setQuantity(0);

		$this->em->persist($inventory);
		$this->em->persist($product);

		$this->em->flush();
	}
}
