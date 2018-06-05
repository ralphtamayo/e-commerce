<?php

namespace SalesBundle\Controller;

use SalesBundle\Entity\Cart;
use SalesBundle\Entity\Payment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Payment controller.
 *
 * @Route("payment")
 */
class PaymentController extends Controller
{
	/**
	 * @Route("/{id}", name="payment_index")
	 * @Template("@Sales/payment/index.html.twig")
	 * @Method("GET")
	 */
	public function indexAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$payment = $em->getRepository('SalesBundle:Payment')->find($id);

		return [
			'payment' => $payment,
		];
	}

	/**
	 * @Route("/{id}/show", name="payment_show")
	 * @Template("@Sales/payment/show.html.twig")
	 * @Method("GET")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$payment = $em->getRepository('SalesBundle:Payment')->find($id);

		return [
			'payment' => $payment,
		];
	}

	/**
	 * @Route("/{id}/new", name="payment_new")
	 * @Template("@Sales/payment/new.html.twig")
	 * @Method("GET")
	 */
	public function newAction($id)
	{
		$payment = new Payment();
		$payment->setAddress($this->getUser()->getAddress());
		$payment->setContactDetails($this->getUser()->getContactDetails());

		$form = $this->createForm('SalesBundle\Form\PaymentType', $payment);

		$em = $this->getDoctrine()->getManager();

		$cart = $em->getRepository('SalesBundle:Cart')->find($id);
		$total = 0;

		foreach ($cart->getItems() as $item) {
			$total += ($item->getQuantity() * $item->getProduct()->getPrice());
		}

		return [
			'id' => $id,
			'total' => $total,
			'form' => $form->createView(),
		];
	}

	/**
	 * @Route("/{id}/create", name="payment_create")
	 * @Template("@Sales/payment/new.html.twig")
	 * @Method("POST")
	 */
	public function createAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$cart = $em->getRepository('SalesBundle:Cart')->find($id);
		$total = 0;

		foreach ($cart->getItems() as $item) {
			$total += ($item->getQuantity() * $item->getProduct()->getPrice());
		}

		$payment = new Payment();
		$payment->setTotal($total);
		$payment->setAddress($this->getUser()->getAddress());
		$payment->setContactDetails($this->getUser()->getContactDetails());

		$form = $this->createForm('SalesBundle\Form\PaymentType', $payment);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$payment->setCart($cart);
			$cart->setIsActive(false);

			$newCart = new Cart();
			$user = $this->getUser();

			if (null != $user) {
				$newCart->setUser($this->getUser());
				$newCart->setIsActive(true);

				$em->persist($newCart);
				$em->persist($payment);
				$em->flush();
			}

			$message = \Swift_Message::newInstance()
				->setSubject('Flowershop Order Numer: '.$cart->getId())
				->setFrom($this->getParameter('mailer_user'))
				->setTo($this->getUser()->getEmail())
				->setBody(
					$this->renderView(
						'email\e-mail.html.twig',
						[
							'payment' => $payment,
							'cart' => $cart,
						]
					),
					'text/html'
				)
			;

			$this->get('mailer')->send($message);

			return $this->redirectToRoute('payment_show', ['id' => $payment->getId()]);
		}

		return [
			'id' => $id,
			'total' => $total,
			'payment' => $payment,
			'form' => $form->createView(),
		];
	}
}
