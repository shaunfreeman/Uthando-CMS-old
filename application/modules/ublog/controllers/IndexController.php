<?php
/*
 * IndexController.php
 *
 * Copyright (c) 2011 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 *
 * This file is part of Uthando-CMS.
 *
 * Uthando-CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Uthando-CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Uthando-CMS.  If not, see <http ://www.gnu.org/licenses/>.
 */

/**
 * Description of Blog_IndexController
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Ublog_IndexController extends Uthando_Controller_Action_Abstract
{
    protected $_commentsModel;

    public function init()
    {
        parent::init();

        $this->_authService = new Core_Service_Authentication();
        $this->_model = new Ublog_Model_Mapper_Blogs();
        $this->_commentsModel = new Ublog_Model_Mapper_Comments();

        $this->setForm('commentAdd', array(
            'action'     => 'add-comment'
        ), 'ublog');
    }

    public function indexAction()
    {
        $this->_log->info(__METHOD__);

        $this->view->blogs = $this->_model->getBlogs();

    }

    public function viewAction()
    {
        $page = $this->_getParam('page');

        if (is_numeric($page)) {
            $this->view->blog = $this->_model->find($page);
        } elseif (is_string($page)) {
            $this->view->blog = $this->_model->getBlogByIdent($page);
        } else {
            throw new Exception('No page found');
        }

        $this->view->comments = $this->_commentsModel->getComments($this->view->blog->blogId);
    }

    public function addCommentAction()
    {
        if (!$this->_request->isPost()) {
            return $this->_helper->redirector('index');
        }

        $this->view->blog = $this->_model->find($this->_request->getParam('blogId'));

        if (!$this->getForm('commentAdd')->isValid($this->_request->getPost())) {
             $this->view->comments = $this->_commentsModel->getComments($this->view->blog->blogId);
            return $this->render('view'); // re-render the login form
        }

        if (false === $this->_commentsModel->saveComment($this->getForm('commentAdd')->getValues())) {
            /**
             * TODO:
             * flashmessager.
             */
        } else {

            return $this->_helper->redirector->gotoRoute(
                array('page'  => $this->view->blog->ident),
                'blog',
                true
            );
        }

        return $this->render('view');
    }
}
?>
