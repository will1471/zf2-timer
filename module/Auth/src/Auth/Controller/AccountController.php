<?php

namespace Auth\Controller;

use Auth\Form\Account as AccountForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{

    public function createAction()
    {
        $form = new AccountForm();
        return new ViewModel(array('form' => $form));
    }
}
