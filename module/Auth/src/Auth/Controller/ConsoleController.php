<?php

namespace Auth\Controller;

use Auth\Entity\User;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;

class ConsoleController extends AbstractActionController
{

    public function createAction()
    {
        if (! $this->getRequest() instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $user = new User();
        $user->setEmail($this->getRequest()->getParam('email'));
        $user->setPassword(password_hash($this->getRequest()->getParam('password'), PASSWORD_BCRYPT));

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        return "Created user.\n";
    }


    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

}
