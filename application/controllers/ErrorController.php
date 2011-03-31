<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        if (!$errors) {
            $this->view->message = _('You have reached the error page');
            return;
        }
        
        switch (get_class($errors->exception)) {
            case 'Zend_Controller_Dispatcher_Exception':
                // send 404
                $this->getResponse()
                     ->setRawHeader('HTTP/1.1 404 Not Found');
                $this->view->message = '404 page not found.';
                break;
            case 'Uthando_Exception':
                // send 405
                $this->getResponse()
                     ->setRawHeader('HTTP/1.1 405 Method Not Allowed');
                $this->view->message = $errors->exception->getMessage();
                break;
            case 'Uthando_Acl_Exception':
                //$this->_helper->layout->setLayout('main');
                $this->view->message = $errors->exception->getMessage();
                break;
            default:
                // application error
                $this->view->message = $errors->exception->getMessage();
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}

?>