<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Product;
use SalesBundle\Entity\CartItem;
use InventoryBundle\Entity\Inventory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\File;

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

		$cartItem = new CartItem();
		$form = $this->createForm('SalesBundle\Form\CartItemType', $cartItem);

		$products = $em->getRepository('InventoryBundle:Product')->findAll();

		foreach ($products as $product) {
			$forms[$product->getId()] = $form->createView();
		}

		return array(
			'products' => $products,
			'form' => $forms,
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
		$inventory = new Inventory();
		$form = $this->createForm('InventoryBundle\Form\ProductType', $product);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();

			$file = $product->getImage();

			$fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

			// moves the file to the directory where brochures are stored
			$file->move(
				$this->getParameter('images_directory'),
				$fileName
			);

			$product->setImage($fileName);

			$inventory->setProduct($product);
			$inventory->setQuantity(0);
			$em->persist($inventory);
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
	 * @Route("/{id}", name="product_show")
	 * @Template("@Inventory/product/show.html.twig")
	 * @Method("GET")
	 * @Security("has_role('ROLE_ADMIN')")
	 */
	public function showAction(Product $product)
	{
		$form = $this->createDeleteForm($product);

		return array(
			'product' => $product,
			'delete_form' => $form->createView(),
		);
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

			$fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

			// moves the file to the directory where brochures are stored
			$file->move(
				$this->getParameter('images_directory'),
				$fileName
			);

			// remove old image on uploads/images folder
			unlink($previousImage);

			$product->setImage($fileName);

			$this->getDoctrine()->getManager()->flush();

			return $this->redirectToRoute('product_show', array('id' => $product->getId()));
		}

		return array(
			'product' => $product,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
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
			->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
			->setMethod('DELETE')
			->getForm()
		;
	}

	private function generateUniqueFileName()
	{
		// md5() reduces the similarity of the file names generated by
		// uniqid(), which is based on timestamps
		return md5(uniqid());
	}
}
