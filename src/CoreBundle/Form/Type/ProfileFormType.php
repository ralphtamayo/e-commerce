<?php

namespace CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('firstName', TextType::class, [
				'required' => true,
				'attr' => [
					'placeholder' => 'First name',
				],
			])
			->add('lastName', TextType::class, [
				'required' => true,
				'attr' => [
					'placeholder' => 'Last name',
				],
			])
			->add('address', TextAreaType::class, [
				'required' => true,
				'attr' => [
					'placeholder' => 'Address',
				],
			])
			->add('contactDetails', TextType::class, [
				'required' => true,
				'attr' => [
					'placeholder' => 'Contact Details',
				],
			])
		;
	}

	public function getParent()
	{
		return 'FOS\UserBundle\Form\Type\ProfileFormType';
	}

	public function getBlockPrefix()
	{
		return 'core_user_profile';
	}
}
