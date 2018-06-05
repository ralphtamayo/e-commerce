<?php

namespace SalesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartItemType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('quantity', Type\NumberType::class, [
				'label' => false,
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 'SalesBundle\Entity\CartItem',
		]);
	}

	public function getBlockPrefix()
	{
		return 'salesbundle_cart_item';
	}
}
