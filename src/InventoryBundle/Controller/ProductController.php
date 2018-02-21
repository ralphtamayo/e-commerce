<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
	/**
	 * @Route("/", name="product_index")
	 * @Template("@Inventory/product/index.html.twig")
	 * @Method("GET")
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$products = $em->getRepository('InventoryBundle:Product')->findAll();

		return array(
			'products' => $products,
		);
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
		$form = $this->createForm('InventoryBundle\Form\ProductType', $product);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($product);
			$em->flush();

			return $this->redirectToRoute('product_show', array('id' => $product->getId()));
		}

		return array(
			'product' => $product,
			'form' => $form->createView(),
		);
	}

	/**
	 * Finds and displays a product entity.
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/{id}", name="product_show")
	 * @Method("GET")
	 */
	public function showAction(Product $product)
	{
		$deleteForm = $this->createDeleteForm($product);

		return $this->render('product/show.html.twig', array(
			'product' => $product,
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing product entity.
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/{id}/edit", name="product_edit")
	 * @Method({"GET", "POST"})
	 */
	public function editAction(Request $request, Product $product)
	{
		$deleteForm = $this->createDeleteForm($product);
		$editForm = $this->createForm('InventoryBundle\Form\ProductType', $product);
		$editForm->handleRequest($request);

		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('product_show', array('id' => $product->getId()));
		}

		return $this->render('product/edit.html.twig', array(
			'product' => $product,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Deletes a product entity.
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
			->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
			->setMethod('DELETE')
			->getForm()
		;
	}
}
