<?php
/* 
 * Comment.php
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
 * Description of Blog_Model_Comment
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Blog_Model_Comment extends Uthando_Model_Abstract
{
    protected $_commentId;
    protected $_blogId;
    protected $_comment;
    protected $_name;
    protected $_email;
    protected $_website;
    protected $_cdate;

    public function getCommentId()
    {
        return $this->_commentId;
    }

    public function setId($id)
    {
        $this->_commentId = (int) $id;
        return $this;
    }

    public function getBlogId()
    {
        return $this->_blogId;
    }

    public function setBlogId($id)
    {
        $this->_blogId = (int) $id;
        return $this;
    }

    public function getComment()
    {
        return $this->_comment;
    }

    public function setComment($text)
    {
        $this->_comment = (string) $text;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }

    public function getWebsite()
    {
        return $this->_website;
    }

    public function setWebsite($site)
    {
        $this->_website = (string) $site;
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
}
?>
