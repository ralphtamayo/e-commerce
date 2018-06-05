<?php

namespace InventoryBundle\Controller;

use CoreBundle\Controller\BaseController;
use InventoryBundle\Entity\Inventory;
use InventoryBundle\Entity\Product;
use InventoryBundle\Form\ProductType;
use SalesBundle\Entity\CartItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Utils\GeneratingUtils;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends BaseController
{
	/**
	 * @Route("/", name="product_index")
	 * @Template("@Inventory/product/index.html.twig")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$cartItem = new CartItem();
		$form = $this->createForm('SalesBundle\Form\CartItemType', $cartItem);

		$products = $em->getRepository('InventoryBundle:Product')->findAll();

		return [
			'products' => $products,
		];
	}

	/**
	 * @Route("/new", name="product_new")
	 * @Template("@Inventory/product/new.html.twig")
	 * @Method({"GET", "POST"})
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function newAction(Request $request)
	{
		$product = new Product();
		$productModel = $this->getModel();

		$form = $this->processForm($product, ProductType::class);

		if ($form->isSubmitted() && $form->isValid()) {
			$productModel->save($product, $form);

			return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
		}

		return [
			'product' => $product,
			'form' => $form->createView(),
		];
	}

	/**
	 * @Route("/{id}", name="product_show")
	 * @Template("@Inventory/product/show.html.twig")
	 * @Method("GET")
	 */
	public function showAction(Product $product)
	{
		$form = $this->createDeleteForm($product);

		$cartItem = new CartItem();
		$cartItemForm = $this->createForm('SalesBundle\Form\CartItemType', $cartItem);

		return [
			'product' => $product,
			'delete_form' => $form->createView(),
			'cart_item_form' => $cartItemForm->createView(),
		];
	}

	/**
	 * @Route("/{id}/edit", name="product_edit")
	 * @Template("@Inventory/product/edit.html.twig")
	 * @Method({"GET", "POST"})
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function editAction(Request $request, Product $product)
	{
		$deleteForm = $this->createDeleteForm($product);

		$product->setImage(
			new File($this->getParameter('images_directory').'/'.$product->getImage())
		);

		$previousImage = $product->getImage()->getPathName();

		$editForm = $this->createForm('InventoryBundle\Form\ProductType', $product);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$file = $product->getImage();

			$fileName = GeneratingUtils::generateUniqueFileName().'.'.$file->guessExtension();

			// moves the file to the directory where brochures are stored
			$file->move(
				$this->getParameter('images_directory'),
				$fileName
			);

			// remove old image on uploads/images folder
			unlink($previousImage);

			$product->setImage($fileName);

			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
		}

		return [
			'product' => $product,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		];
	}

	/**
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/{id}", name="product_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, Product $product)
	{
		$form = $this->createDeleteForm($product);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();

			// remove old image on uploads/images folder
			unlink($this->getParameter('images_directory').'/'.$product->getImage());

			$inventory = $product->getInventory();
			$em->remove($inventory);
			$em->remove($product);
			$em->flush();
		}

		return $this->redirectToRoute('product_index');
	}

	/**
	 * Creates a form to delete a product entity.
	 *
	 * @param Product $product The product entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm(Product $product)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('product_delete', ['id' => $product->getId()]))
			->setMethod('DELETE')
			->getForm()
		;
	}

	private function getModel()
	{
		return $this->get('inventory.product_model');
	}
}
