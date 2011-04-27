<?php
/*
 * Blog.php
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
 * Description of Blog_Model_Blog
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Ublog_Model_Blog extends Uthando_Model_Abstract
{
    protected $_blogId;
    protected $_userId;
    protected $_user;
    protected $_title;
    protected $_ident;
    protected $_blog;
    protected $_cdate;
    protected $_mdate;
    protected $_comments;
    protected $_numComments;

    public function getBlogId()
    {
        return $this->_blogId;
    }

    public function setBlogId($id)
    {
        $this->_blogId = (int) $id;
        return $this;
    }

    public function getUserId()
    {
        return $this->_userId;
    }

    public function setUserId($id)
    {
        $this->_userId = (int) $id;
        return $this;
    }

    public function getUser()
    {
        return $this->_user;
    }

    public function setUser(Zend_Db_Table_Row $user)
    {
        $this->_user = join(' ', array(
            $user->firstName,
            $user->lastName
        ));
        return $this;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }

    public function getIdent()
    {
        return $this->_ident;
    }

    public function setIdent($text)
    {
        $this->_ident = (string) $text;
        return $this;
    }

    public function getBlog()
    {
        return $this->_blog;
    }

    public function setBlog($text)
    {
        $this->_blog = (string) $text;
        return $this;
    }

    public function getCdate()
    {
        return $this->_cdate;
    }

    public function setCdate($ts)
    {
        $this->_cdate = $ts;
        return $this;
    }

    public function getMdate()
    {
        return $this->_mdate;
    }

    public function setMdate($ts)
    {
        $this->_mdate = $ts;
        return $this;
    }

    public function getComments()
    {
        return $this->_comments;
    }

    public function setComments(Zend_Db_Table_Rowset $comments)
    {
        $this->_comments = $comments;
        $this->setNumComment($comments->count());
        return $this;
    }

    public function getNumComments()
    {
        return $this->_numComments;
    }

    public function setNumComment($num)
    {
        $this->_numComments = (int) $num;
        return $this;
    }
}
?>
