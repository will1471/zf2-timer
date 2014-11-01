<?php

namespace Auth\Form;

class Account extends \Zend\Form\Form
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setAttribute('method', 'post');

        $inputFilter = new \Zend\InputFilter\InputFilter();

        $this->add(
            array(
                'type' => 'email',
                'name' => 'username',
                'options' => array(
                    'label' => 'Email Address',
                ),
                'attributes' => array(
                    'class' => 'form-control',
                    'placeholder' => 'sam.jones@example.com',
                )
            )
        );


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
