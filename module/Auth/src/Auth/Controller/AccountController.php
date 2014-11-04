<?php

namespace Auth\Controller;

use Auth\Form\Account as AccountForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class AccountController extends AbstractActionController
{

    /**
     * Provides getUserService()
     */
    use \Auth\ServiceTrait;


    /**
     * Create Account Action (route: /create-account)
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function createAction()
    {
        $form = new AccountForm($this->getUserService());

        if ($form->handleRequest($this->getRequest())->isValid()) {

            try {
                $this->getUserService()
                    ->createUser(
                        $form->getInputFilter()->get('email')->getValue(),
                        $form->getInputFilter()->get('password')->getValue()
                    );
                return $this->redirect()->toRoute('login');

            } catch (\Exception $e) {
                // should handle exceptions better, flash messager for example.
                die($e->getMessage());
            }
        }

        return new ViewModel(array('form' => $form));
    }

}
