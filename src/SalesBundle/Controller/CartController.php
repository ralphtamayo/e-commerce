<?php

namespace SalesBundle\Controller;

use SalesBundle\Entity\CartItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Cart controller.
 *
 * @Route("cart")
 */
class CartController extends Controller
{
	/**
	 * @Route("/{id}", name="cart_index")
	 * @Template("@Sales/cart/index.html.twig")
	 * @Method("GET")
	 */
	public function indexAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$cart = $em->getRepository('SalesBundle:Cart')->find($id);

		return array(
			'cart' => $cart,
		);
	}

	/**
	 * @Route("/add/{id}", name="cart_add_item")
	 * @Method("POST")
     * @Security("has_role('ROLE_USER')")
	 */
	public function addItemAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();
		
		$user = $this->getUser();
		$cart = $em->getRepository('SalesBundle:Cart')->findByUser($user->getId());
		$product = $em->getRepository('InventoryBundle:Product')->find($id);
		$inventory = $product->getInventory();

		$cartItem = new CartItem();
		$cartItem->setProduct($product);

		$form = $this->createForm('SalesBundle\Form\CartItemType', $cartItem);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {

			$inventory->deductQuantity($cartItem->getQuantity());
			$em->persist($inventory);
	
			$cartItem->setCart($cart);

			$em->persist($cartItem);
			$em->flush();
		}

		return $this->render(
			'InventoryBundle:Product:show.html.twig',
			array(
				'product' => $product,
				'cart_item_form' => $form->createView(),
			)
		);
	}

	/**
	 * @Route("/remove/{id}", name="cart_remove_item")
	 * @Method("POST")
     * @Security("has_role('ROLE_USER')")
	 */
	public function removeItemAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$user = $this->getUser();
		$cart = $em->getRepository('SalesBundle:Cart')->findByUser($user->getId());
		$cartItem = $em->getRepository('SalesBundle:CartItem')->find($id);
		$inventory = $cartItem->getProduct()->getInventory();
		
		$inventory->addQuantity($cartItem->getQuantity());
		$em->persist($inventory);

		$cart->removeItem($cartItem);

		$em->remove($cartItem);
		$em->persist($cart);
		$em->flush();

		$url = $this->generateUrl('cart_index', array('id' => $cart->getId()));
		$response = new RedirectResponse($url);

		return $response;
	}
}
