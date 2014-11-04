<?php

namespace Auth\Form;


/**
 * Form used when user logs in.
 */
class Login extends AbstractForm
{


    public function __construct()
    {
        parent::__construct();

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'email',
            'type' => 'text',
            'options' => array(
                'label' => 'Email Address'
            ),
            'attributes' => array (
                'class' => 'form-control',
                'placeholder' => 'email',
            )
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password'
            ),
            'attributes' => array (
                'class' => 'form-control',
                'placeholder' => 'password',
            )
        ));

        $this->add(array(
            'name' => 'login',
            'type' => 'submit',
            'attributes' => array(
                'id' => 'login-submit-button',
                'class' => 'btn btn-primary pull-right',
                'value' => 'Login',
            )
        ));
    }

}
