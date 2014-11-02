<?php

namespace Auth\Controller;

use Auth\Entity\User;
use Auth\Form\Login as LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class LoginController extends AbstractActionController
{

    public function loginAction()
    {
        $form = new LoginForm();

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid())  {

                $authService = $this->getAuthenticationService();
                $adaptor = $authService->getAdapter();
                $adaptor->setIdentity($form->getInputFilter()->get('email')->getValue());
                $adaptor->setCredential($form->getInputFilter()->get('password')->getValue());

                $result = $authService->authenticate();

                if ($result->isValid()) {
                    $this->redirect()->toRoute('home');
                }
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }


    public function logoutAction()
    {
        $this->getAuthenticationService()->clearIdentity();

        return $this->redirect()->toRoute('login');
    }


    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->getServiceLocator()->get('authentication-service');
    }


    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEnttiyManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}
