<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
	public function processForm($entity, $formType)
	{
		$form = $this->createForm($formType, $entity);
		$request = $this->get('request_stack')->getCurrentRequest();

		$form->handleRequest($request);

		return $form;
	}
}
