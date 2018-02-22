<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
	public function indexAction($name, \Swift_Mailer $mailer)
	{
		$message = (new \Swift_Message('Hello Email'))
			->setFrom('no-reply@flowershop.com')
			->setTo('tamayoralph24@gmail.com')
			->setBody(
				$this->renderView(
					// app/Resources/views/Emails/registration.html.twig
					'Emails/payment-details.html.twig',
					array('name' => $name)
				),
				'text/html'
			)
		;

		$mailer->send($message);

		return $this->render('@Core::Email:payment-details.html.twig');
	}
}
