<?php

namespace InventoryBundle\Controller;

use CoreBundle\Controller\BaseController;
use InventoryBundle\Entity\Inventory;
use InventoryBundle\Entity\Product;
use InventoryBundle\Form\ProductType;
use SalesBundle\Entity\CartItem;
use SalesBundle\Form\CartItemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

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

		$products = $em->getRepository(Product::class)->findAll();

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
		$cartItemForm = $this->createForm(CartItemType::class, $cartItem);

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
		$productModel = $this->getModel();

		$product->setImage(
			new File($this->getParameter('images_directory').'/'.$product->getImage())
		);

		$previousImage = $product->getImage()->getPathName();

		$editForm = $this->processForm($product, ProductType::class);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$productModel->update($product, $editForm);

			unlink($previousImage);

			return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
		}

		return [
			'product' => $product,
			'edit_form' => $editForm->createView(),
		];
	}

	/**
	 * @Route("/{id}", name="product_delete")
	 * @Method("DELETE")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function deleteAction(Request $request, Product $product)
	{
		$form = $this->createDeleteForm($product);
		$form->handleRequest($request);

		$productModel = $this->getModel();

		if ($form->isSubmitted() && $form->isValid()) {
			$productModel->delete($product);
		}

		return $this->redirectToRoute('product_index');
	}

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
