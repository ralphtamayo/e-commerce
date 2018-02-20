<?php

namespace CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username', TextType::class, array(
				'required' => true,
				'attr' => array(
					'placeholder' => 'Username',
				),
			))
			->add('email', EmailType::class, array(
				'required' => true,
				'attr' => array(
					'placeholder' => 'E-mail Address',
				),
			))
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
			->add('plainPassword', RepeatedType::class, array(
				'type' => PasswordType::class,
				'required' => true,
				'first_options' => array(
					'label' => 'Password',
					'attr' => array(
						'placeholder' => 'Password',
						'class' => 'form-input',
					),
				),
				'second_options' => array(
					'label' => 'Confirm password',
					'attr' => array(
						'placeholder' => 'Confirm password',
						'class' => 'form-input',
					),
				),
				'invalid_message' => 'user.password.notMatch',
			))
		;
	}

	public function getParent()
	{
		return 'FOS\UserBundle\Form\Type\RegistrationFormType';
	}

	public function getBlockPrefix()
	{
		return 'core_user_registration';
	}
}
