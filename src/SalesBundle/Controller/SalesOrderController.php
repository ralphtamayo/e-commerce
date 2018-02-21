<?php

namespace SalesBundle\Controller;

use SalesBundle\Entity\SalesOrderItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * SalesOrder controller.
 *
 * @Route("sales-order")
 */
class SalesOrderController extends Controller
{
	// /**
	//  * @Route("/{id}", name="sales_order_index")
	//  * @Template("@Sales/salesOrder/index.html.twig")
	//  * @Method("GET")
	//  */
	// public function indexAction($id)
	// {
	// 	$em = $this->getDoctrine()->getManager();

	// 	$salesOrder = $em->getRepository('SalesBundle:SalesOrder')->load($id);

	// 	return array(
	// 		'salesOrder' => $salesOrder,
	// 	);
    // }
    
    /**
	 * @Route("/generate", name="generate_sales_order")
	 * @Template("@Sales/salesorder/index.html.twig")
	 * @Method("POST")
	 */
	public function generateAction()
	{
        dump('ralph');
	}
}
