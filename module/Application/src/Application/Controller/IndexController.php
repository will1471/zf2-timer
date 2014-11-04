<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{

    /**
     * Provides getAuthenticationService()
     */
    use \Auth\ServiceTrait;


    /**
     * Index Action (route: /)
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        if (! $this->getAuthenticationService()->hasIdentity()) {
            return $this->redirect()->toRoute('login');
        }

        return new ViewModel(array('user' => $this->getAuthenticationService()->getIdentity()));
    }

}
