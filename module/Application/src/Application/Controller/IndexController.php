<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        if (! $this->getAuthenticationService()->hasIdentity()) {
            return $this->redirect()->toRoute('login');
        }

        return new ViewModel(array('user' => $this->getAuthenticationService()->getIdentity()));
    }


    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->getServiceLocator()->get('authentication-service');
    }

}
