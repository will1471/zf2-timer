<?php

namespace Auth\Controller;

use Auth\Form\Login as LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{


    public function loginAction()
    {
        $form = new LoginForm();

        return new ViewModel(array(
            'form' => $form,
        ));
    }


    public function logoutAction()
    {
        return $this->redirect()->toRoute('login');
    }

}
