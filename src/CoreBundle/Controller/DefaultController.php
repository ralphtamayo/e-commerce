<?php

namespace CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
