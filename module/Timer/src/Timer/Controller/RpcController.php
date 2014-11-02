<?php

namespace Timer\Controller;

/**
 * See: http://blog.amnuts.com/2012/08/23/zend-framework-2-json-rpc-server/
 */
class RpcController extends \Zend\Mvc\Controller\AbstractActionController
{

    public function rpcAction()
    {
        $timer = $this->getTimerService()->getTimer(
            $this->getAuthenticationService()->getIdentity(),
            $this->params()->fromRoute('id', null)
        );

        $server = new \Zend\Json\Server\Server();
        $server->setClass(new \Timer\Timer($timer, $this->getEntityManager()));
        $server->getRequest()->setVersion(\Zend\Json\Server\Server::VERSION_2);
        $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        if ($this->getRequest()->isPost()) {
            $server->handle();

        } else {
            $this->getResponse()->setContent(
                $server->getServiceMap()->setEnvelope(\Zend\Json\Server\Smd::ENV_JSONRPC_2)
            );
        }

        return $this->getResponse();
    }


    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->getServiceLocator()->get('authentication-service');
    }


    /**
     * @return \Timer\Service
     */
    private function getTimerService()
    {
        return $this->getServiceLocator()->get('timer-service');
    }


    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }
}
