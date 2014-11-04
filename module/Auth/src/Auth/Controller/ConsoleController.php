<?php

namespace Auth\Controller;

use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;


class ConsoleController extends AbstractActionController
{

    /**
     * Provides getUserService()
     */
    use \Auth\ServiceTrait;


    /**
     * Create a user from console (php public/index.php user create email password)
     *
     * @return string
     *
     * @throws \Exception on doctrine issues.
     * @throws \RuntimeException on wrong runtime env.
     */
    public function createAction()
    {
        if (! $this->getRequest() instanceof ConsoleRequest) {
            throw new \RuntimeException('You can only use this action from a console!');
        }

        $email = $this->getRequest()->getParam('email');
        $password = $this->getRequest()->getParam('password');

        if (! $this->getUserService()->getUniqueUsernameValidator()->isValid($email)) {
            return 'Email address already in user.';
        }

        $this->getUserService()->createUser($email, $password);

        return "Created user.\n";
    }

}
