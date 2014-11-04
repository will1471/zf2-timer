<?php

namespace Auth\Form;

use Zend\Form\Form;

/**
 * Adds some nice functionality to setData and validate in one if statement.
 *
 * if ($request->isPost()) {
 *     $form->setData($request->getPost());
 *     if ($form->isValid()) {
 *         // use $form
 *     }
 * }
 *
 * Becomes:
 *
 * if ($form->handleRequest($request)->isValid()) {
 *     // use $form
 * }
 *
 * And the controller no longer has to care about the method type, however the
 * form now cares about the Request object, which may not be ideal.
 */
abstract class AbstractForm extends Form
{

    /**
     * Handle a Request object, isValid() should still be called.
     *
     * @param \Zend\Http\Request $request
     *
     * @return \Auth\Form\AbstractForm
     *
     * @throws \Exception if the form method is not get or post.
     */
    public function handleRequest(\Zend\Http\Request $request)
    {
        $data = null;

        $formMethod = strtolower($this->getAttribute('method'));
        switch ($formMethod) {
            case 'post':
                if ($request->isPost()) {
                    $data = $request->getPost();
                }
                break;

            case 'get':
                if ($request->isGet()) {
                    $data = $request->getQuery();
                }
                break;

            default:
                throw new \Exception('Can not handle form method: ' . $formMethod);
        }

        try {
            // setting the data to null will throw an exception.
            $this->setData($data);

        } catch (\Zend\Form\Exception\InvalidArgumentException $e) {
            $this->hasValidated = false;
            $this->data = null;
        }

        return $this;
    }


    /**
     * @return boolean
     */
    public function isValid()
    {
        // stop exceptions when data is not set.
        if (! isset($this->data)) {
            return false;
        }

        return parent::isValid();
    }

}
