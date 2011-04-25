<?php
/*
 * Blogs.php
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
 * Description of Blog_Model_Mapper_Blogs
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Ublog_Model_Mapper_Blogs extends Uthando_Model_Mapper_Acl_Abstract
{
    protected $_dbTableClass = 'Ublog_Model_DbTable_Blogs';
    protected $_modelClass = 'Ublog_Model_Blog';

    protected function  _setVars($row, Ublog_Model_Blog $model)
    {
        return $model->setBlogId($row->blogId)
                ->setTitle($row->title)
                ->setDescription($row->description)
                ->setCdate($row->cdate)
                ->setMdate($row->mdate);
    }

    public function getBlogs()
    {
        $select = $this->getDbTable()
                ->select()
                ->order('cdate');

        return $this->fetchAll($select);
    }

    public function  setAcl($acl)
    {
        parent::setAcl($acl);

        $this->_acl->allow('Manager', $this, array('save'))
            ->allow('SuperAdministrator', $this);
    }
}
?>
