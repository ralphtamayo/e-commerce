<?php

namespace InventoryBundle\Model;

use CoreBundle\Model\BaseModel;
use CoreBundle\Utils\GeneratingUtils;
use InventoryBundle\Entity\Inventory;
use InventoryBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

	public function update(Product $product, $form)
	{
		$file = $product->getImage();

		$fileName = GeneratingUtils::generateUniqueFileName().'.'.$file->guessExtension();

		// moves the file to the directory where brochures are stored
		$file->move(
			$this->container->getParameter('images_directory'),
			$fileName
		);

		$product->setImage($fileName);

		$this->em->flush();
	}

	public function delete(Product $product)
	{
		unlink($this->getParameter('images_directory').'/'.$product->getImage());

		$inventory = $product->getInventory();

		$this->em->remove($inventory);
		$this->em->remove($product);

		$this->em->flush();
	}
}
