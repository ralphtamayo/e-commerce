<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Inventory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inventory controller.
 *
 * @Route("inventory")
 */
class InventoryController extends Controller
{
	/**
	 * @Route("/", name="inventory_index")
	 * @Template("@Inventory/inventory/index.html.twig")
	 * @Method("GET")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$inventories = $em->getRepository('InventoryBundle:Inventory')->findAll();

		return [
			'inventories' => $inventories,
		];
	}

	/**
	 * @Route("/new/{id}", name="inventory_new")
	 * @Template("@Inventory/inventory/new.html.twig")
	 * @Method({"GET", "POST"})
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function newAction(Request $request, $id)
	{
		$inventory = new Inventory();
		$product = $this->getDoctrine()->getManager()->getRepository('InventoryBundle:Product')->find($id);
		$form = $this->createForm('InventoryBundle\Form\InventoryType', $inventory);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$isPersisted = $em->getRepository('InventoryBundle:Inventory')->findOneBy(['product' => $product]);

			if (null === $isPersisted) {
				$inventory->setProduct($product);
				$em->persist($inventory);
			} else {
				$isPersisted->addQuantity($data->getQuantity());
				$em->persist($isPersisted);
			}

			$em->flush();

			return $this->redirectToRoute('inventory_index');
		}

		return [
			'product' => $product,
			'form' => $form->createView(),
		];
	}
}
