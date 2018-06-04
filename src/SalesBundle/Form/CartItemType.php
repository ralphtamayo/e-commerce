<?php

namespace SalesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use CI\InventoryBundle\Entity\Payment;

class CartItemType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('quantity', Type\NumberType::class, array(
				'label' => false,
			))
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'SalesBundle\Entity\CartItem'
		));
	}

	public function getBlockPrefix()
	{
		return 'salesbundle_cart_item';
	}
}
