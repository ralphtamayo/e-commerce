<?php

namespace CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MiscController extends Controller
{
	/**
	 * @Route("/about", name="misc")
	 * @Template("@Core/Misc/about.html.twig")
	 */
	public function indexAction()
	{
	}
}
