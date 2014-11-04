<?php

namespace Auth\Form;

use Auth\UserService;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;


/**
 * Form used when creating new accounts.
 */
class Account extends AbstractForm
{


    /**
     * @param \Auth\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();

        $this->setAttribute('method', 'post');

        $inputFilter = new InputFilter();

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
        $email = new Input('email');
        $email->setAllowEmpty(false);

        /*
         * It could be considered bad practice to have the form validation
         * make calls to the database.
         */
        $email->getValidatorChain()
            ->attach($userService->getUniqueUsernameValidator());

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
        $password = new Input('password');
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
        $password2->getValidatorChain()
            ->attach(
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
