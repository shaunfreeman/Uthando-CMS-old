<?php
/*
 * Comments.php
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
 * Description of Blog_Model_Mapper_Comments
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Ublog_Model_Mapper_Comments extends Uthando_Model_Mapper_Acl_Abstract
{
    protected $_dbTableClass = 'Ublog_Model_DbTable_Comments';
    protected $_modelClass = 'Ublog_Model_Comment';

    protected function _setVars($row, Ublog_Model_Comment $model) {
        return $model->setCommentId($row->commentId)
                ->setBlogId($row->blogId)
                ->setName($row->name)
                ->setEmail($row->email)
                ->setWebsite($row->website)
                ->setComment($row->comment)
                ->setCdate($row->cdate);
    }

    public function getComments($id)
    {
        $select = $this->getDbTable()
                ->select()
                ->where('blogId = ?', $id)
                ->order('cdate ASC');

        return $this->fetchAll($select);
    }

    public function saveComment($values)
    {
        $comment = new Ublog_Model_Comment($values);
        $data = $comment->toArray();

        if (null === ($id = $comment->getCommentId())) {
            unset($data[$id]);
            return $this->getDbTable()->insert($data);
        }
    }

    public function  setAcl($acl)
    {
        parent::setAcl($acl);

        //$this->_acl->allow('Guest', $this, array('save'))->allow('Registered', $this);
    }
}
?>
