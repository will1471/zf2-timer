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
                $adaptor = $this->getAuthenticationAdapter();
                $adaptor->setIdentity($form->getInputFilter()->get('email')->getValue());
                $adaptor->setCredential($form->getInputFilter()->get('password')->getValue());

                $result = $this->getAuthenticationService()->authenticate($adaptor);

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
     * @return \DoctrineModule\Authentication\Adapter\ObjectRepository
     */
    private function getAuthenticationAdapter()
    {
        return new \DoctrineModule\Authentication\Adapter\ObjectRepository(
            array(
                'object_manager' => $this->getEnttiyManager(),
                'identity_class' => User::class,
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function(User $user, $passwordGiven) {
                    return password_verify($passwordGiven, $user->getPassword());
                },
            )
        );
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
