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

		$cartItem = new CartItem();
		$form = $this->createForm('SalesBundle\Form\CartItemType', $cartItem);
		$form->handleRequest($request);

		$cartItem->setProduct($product);
		$cartItem->setCart($cart);

		$em->persist($cartItem);
		$em->flush();

		$url = $this->generateUrl('product_index');
		$response = new RedirectResponse($url);

		return $response;
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

		$cart->removeItem($cartItem);

		$em->remove($cartItem);
		$em->persist($cart);
		$em->flush();

		$url = $this->generateUrl('cart_index', array('id' => $cart->getId()));
		$response = new RedirectResponse($url);

		return $response;
	}
}
