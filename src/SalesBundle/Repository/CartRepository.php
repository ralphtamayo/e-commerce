<?php

namespace SalesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CartRepository extends EntityRepository
{
	public function load($id)
	{
		$qb = $this->createQueryBuilder('cart')
			->select('cart', 'item', 'product')
			->join('cart.items', 'item')
			->join('item.product', 'product')
			->andWhere('cart.id = :id')
			->setParameter('id', $id)
		;

		return $qb->getQuery()->getOneOrNullResult();
	}

	public function loadAll()
	{
		$qb = $this->createQueryBuilder('cart')
			->select('cart', 'user', 'cart_item', 'product')
			->join('cart.user', 'user')
			->join('cart.items', 'cart_item')
			->join('cart_item.product', 'product')
			->andWhere('cart.isActive = 0')
		;

		return $qb->getQuery()->getResult();
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
