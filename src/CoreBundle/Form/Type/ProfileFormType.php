<?php

namespace CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProfileFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('firstName', TextType::class, array(
				'required' => true,
				'attr' => array(
					'placeholder' => 'First name',
				),
			))
			->add('lastName', TextType::class, array(
				'required' => true,
				'attr' => array(
					'placeholder' => 'Last name',
				),
			))
			->add('address', TextAreaType::class, array(
				'required' => true,
				'attr' => array(
					'placeholder' => 'Address',
				),
			))
			->add('contactDetails', TextType::class, array(
				'required' => true,
				'attr' => array(
					'placeholder' => 'Contact Details',
				),
			))
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
