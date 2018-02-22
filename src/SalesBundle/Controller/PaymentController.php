<?php

namespace SalesBundle\Controller;

use SalesBundle\Entity\Cart;
use SalesBundle\Entity\Payment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Payment controller.
 *
 * @Route("payment")
 */
class PaymentController extends Controller
{

	/**
	 * @Route("/{id}", name="payment_show")
	 * @Template("@Sales/payment/show.html.twig")
	 * @Method("GET")
	 * @Security("has_role('ROLE_USER')")
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$payment = $em->getRepository('SalesBundle:Payment')->find($id);

		return array(
			'payment' => $payment,
		);
	}

    /**
	 * @Route("/{id}/new", name="payment_new")
	 * @Template("@Sales/payment/new.html.twig")
	 * @Method("GET")
	 */
	public function newAction($id)
	{
        $payment = new Payment();
		$form = $this->createForm('SalesBundle\Form\PaymentType', $payment);

		$em = $this->getDoctrine()->getManager();

		$cart = $em->getRepository('SalesBundle:Cart')->find($id);
		$total = 0;

		foreach($cart->getItems() as $item) {
			$total += ($item->getQuantity() * $item->getProduct()->getPrice());
		}

		return array(
			'total' => $total,
			'payment' => $payment,
			'form' => $form->createView(),
		);
	}

	/**
	 * @Route("/{id}/create", name="payment_create")
	 * @Template("@Sales/payment/new.html.twig")
	 * @Method("POST")
	 */
	public function createAction(Request $request, $id)
	{
        $payment = new Payment();
		$form = $this->createForm('SalesBundle\Form\PaymentType', $payment);
		$form->handleRequest($request);

		$em = $this->getDoctrine()->getManager();

		$cart = $em->getRepository('SalesBundle:Cart')->find($id);
		$total = 0;

		foreach($cart->getItems() as $item) {
			$total += ($item->getQuantity() * $item->getProduct()->getPrice());
		}

		if ($form->isSubmitted() && $form->isValid()) {
			$payment->setTotal($total);

			$cart->setPayment($payment);
			$cart->setIsActive(false);

			$newCart = new Cart();
			$user = $this->getUser();

			if ($user != null) {
				$newCart->setUser($this->getUser());
				$newCart->setIsActive(true);
	
				$em->persist($newCart);
				$em->persist($payment);
				$em->flush();

			}

			return $this->redirectToRoute('payment_show', array('id' => $payment->getId()));
		}

		return array(
			'total' => $total,
			'payment' => $payment,
			'form' => $form->createView(),
		);
	}
}