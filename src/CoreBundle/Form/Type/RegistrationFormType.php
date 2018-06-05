<?php

namespace CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('username', TextType::class, [
				'required' => true,
				'attr' => [
					'placeholder' => 'Username',
				],
			])
			->add('email', EmailType::class, [
				'required' => true,
				'attr' => [
					'placeholder' => 'E-mail Address',
				],
			])
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
			->add('plainPassword', RepeatedType::class, [
				'type' => PasswordType::class,
				'required' => true,
				'first_options' => [
					'label' => 'Password',
					'attr' => [
						'placeholder' => 'Password',
						'class' => 'form-input',
					],
				],
				'second_options' => [
					'label' => 'Confirm password',
					'attr' => [
						'placeholder' => 'Confirm password',
						'class' => 'form-input',
					],
				],
				'invalid_message' => 'user.password.notMatch',
			])
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
