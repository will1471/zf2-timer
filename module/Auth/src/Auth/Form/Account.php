<?php

namespace Auth\Form;

use DoctrineModule\Validator\NoObjectExists;
use Doctrine\Common\Persistence\ObjectRepository;


class Account extends \Zend\Form\Form
{


    public function __construct(ObjectRepository $userRepository, $name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setAttribute('method', 'post');

        $inputFilter = new \Zend\InputFilter\InputFilter();

        $this->add(
            array(
                'type' => 'email',
                'name' => 'email',
                'options' => array(
                    'label' => 'Email Address',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'sam.jones@example.com',
                )
            )
        );
        $email = new \Zend\InputFilter\Input('email');
        $email->setAllowEmpty(false);
        $email->getValidatorChain()
            ->attach(
                new NoObjectExists(
                    array(
                        'object_repository' => $userRepository,
                        'fields' => array('email'),
                        'messages' => array(
                            NoObjectExists::ERROR_OBJECT_FOUND => 'A user with this email already exists.',
                        ),
                    )
                )
            );
        $inputFilter->add($email);


        $this->add(
            array(
                'type' => 'password',
                'name' => 'password',
                'options' => array(
                    'label' => 'Password',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'something secure',
                )
            )
        );
        $password = new \Zend\InputFilter\Input('password');
        $password->setAllowEmpty(false);
        $inputFilter->add($password);


        $this->add(
            array(
                'type' => 'password',
                'name' => 'password_repeat',
                'options' => array(
                    'label' => 'Repeat Password',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'something secure',
                )
            )
        );
        $password2 = new \Zend\InputFilter\Input('password_repeat');
        $password2->setAllowEmpty(false);
        $password2->getValidatorChain()->addValidator(
            new \Zend\Validator\Callback(
                array(
                    'messages' => array(
                        \Zend\Validator\Callback::INVALID_VALUE => 'The passwords do not match.',
                    ),
                    'callback' => function($value, $context = array()) {
                        return $value == $context['password'];
                    }
                )
            )
        );
        $inputFilter->add($password2);


        $this->add(
            array(
                'name' => 'submit',
                'type' => 'submit',
                'attributes' => array(
                    'value' => 'Create Account',
                    'class' => 'btn btn-primary pull-right',
                ),
            )
        );

        $this->setInputFilter($inputFilter);
    }

}
