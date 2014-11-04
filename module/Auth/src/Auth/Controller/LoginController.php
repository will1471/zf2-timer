<?php

namespace Auth\Controller;

use Auth\Form\Login as LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class LoginController extends AbstractActionController
{

    /**
     * Provides getAuthenticationService()
     */
    use \Auth\ServiceTrait;


    /**
     * Login Action (route: /login)
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function loginAction()
    {
        $form = new LoginForm();

        if ($form->handleRequest($this->getRequest())->isValid()
            && $this->authenticate($form)->isValid()) {

            return $this->redirect()->toRoute('home');
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }


    /**
     * @param \Auth\Form\Login $form
     *
     * @return \Zend\Authentication\Result
     */
    private function authenticate(LoginForm $form)
    {
        $authService = $this->getAuthenticationService();
        $adaptor = $authService->getAdapter();
        $adaptor->setIdentity($form->getInputFilter()->get('email')->getValue());
        $adaptor->setCredential($form->getInputFilter()->get('password')->getValue());

        return $authService->authenticate($adaptor);
    }


    /**
     * Login Action (route: /logout)
     *
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $this->getAuthenticationService()->clearIdentity();

        return $this->redirect()->toRoute('login');
    }

}
