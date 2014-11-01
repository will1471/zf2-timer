<?php

namespace Auth\Controller;

use Auth\Entity\User;
use Auth\Form\Account as AccountForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{

    public function createAction()
    {
        $form = new AccountForm($this->getEntityManager()->getRepository(User::class));

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                $user = new User();
                $user->setEmail($form->getInputFilter()->get('email')->getValue());
                $user->setPassword(password_hash($form->getInputFilter()->get('password')->getValue(), PASSWORD_BCRYPT));
                $this->getEntityManager()->persist($user);

                try {
                    $this->getEntityManager()->flush();
                    return $this->redirect()->toRoute('login');

                } catch (\Exception $e) {
                    die($e->getMessage());
                }
            }
        }

        return new ViewModel(array('form' => $form));
    }


    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}
