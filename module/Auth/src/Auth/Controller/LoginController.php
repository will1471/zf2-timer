<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{


    public function loginAction()
    {
        return new ViewModel();
    }


    public function logoutAction()
    {
        return $this->redirect()->toRoute('login');
    }

}
