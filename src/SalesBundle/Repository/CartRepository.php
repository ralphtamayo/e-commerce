<?php

namespace SalesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartRepository extends EntityRepository
{
	public function load($id)
	{
		$qb = $this->createQueryBuilder('cart')
			->select('cart', 'item','product')
			->join('cart.items', 'item')
			->join('item.product', 'product')
			->andWhere("cart.id = :id")
			->setParameter('id', $id)
		;

		return $qb->getQuery()->getOneOrNullResult();
	}

	public function findByUser($id)
	{
		$qb = $this->createQueryBuilder('cart')
			->select('cart')
			->join('cart.user', 'user')
			->andWhere('user.id = :id')
			->andWhere('cart.isActive = 1')
			->setParameter('id', $id)
		;

		return $qb->getQuery()->getOneOrNullResult();
	}
}