<?php

namespace SalesBundle\Form;

use SalesBundle\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('paymentMode', Type\ChoiceType::class, [
				'choices' => [
					Payment::PAYMENT_MODE_BDO => Payment::PAYMENT_MODE_BDO,
					Payment::PAYMENT_MODE_CEBUANA => Payment::PAYMENT_MODE_CEBUANA,
					Payment::PAYMENT_MODE_COD => Payment::PAYMENT_MODE_COD,
				],
			])
			->add('cardNumber', Type\TextType::class)
			->add('expirationDate', Type\DateType::class)
			->add('referenceNumber', Type\TextType::class)
			->add('address', TextAreaType::class, [
				'required' => true,
				'disabled' => true,
			])
			->add('contactDetails', TextType::class, [
				'required' => true,
				'disabled' => true,
			])
		;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => 'SalesBundle\Entity\Payment',
		]);
	}

	public function getBlockPrefix()
	{
		return 'salesbundle_payment';
	}
}
