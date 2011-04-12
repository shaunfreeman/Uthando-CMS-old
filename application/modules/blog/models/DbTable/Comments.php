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
 * Description of Blog_Model_DbTable_Comments
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class Blog_Model_DbTable_Comments extends Zend_Db_Table_Abstract
{
    protected $_name = 'blog_comments';
    protected $_primary = 'CommentId';

    protected $_referenceMap = array(
        'Blog' => array(
            'columns'   => 'blogId',
            'refTableClass' => 'Blog_Model_DbTable_Blogs',
            'refColumns'    => 'blogId'
        )
    );
}
?>
