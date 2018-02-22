<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 * @Template("@Core/Default/index.html.twig")
	 */
	public function indexAction()
	{
		return $this->redirectToRoute('product_index');
	}
}
