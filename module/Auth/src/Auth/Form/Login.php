<?php

namespace Auth\Form;

use Zend\Form\Form;

class Login extends Form
{


    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

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
