INSERT INTO components (component_id, component, version) VALUES
(1, 'user', '1.0.0'),
(2, 'content', '1.0.0');
--
INSERT INTO email_body (email_id, template, body) VALUES
(1, 'reset password', 'Dear ####USER####\r\n\r\nYou have reset your password at ####SITE####.\r\n\r\nYour new password is: ####PASSWORD####\r\n\r\nPlease use this to log into your account at ####SITE#### then please change it to a more memorial one a.s.a.p.\r\n\r\nRegards\r\n####ADMINISTRATOR####  ');
--
INSERT INTO email_type (email_type_id, email_type) VALUES
(1, 'html'),
(2, 'plain');
--
INSERT INTO menus (menu_id, menu, deletable, menu_type_id) VALUES
(1, 'Main Menu', 0, 1),
(2, 'Top Menu', 1, 2),
(3, 'Admin', 0, 1);
--
INSERT INTO menu_items (item_id, menu_id, lft, rgt, status_id, url_id, title) VALUES
(1, 1, 1, 2, 1, 1, 'Home'),
(2, 1, 3, 4, 3, 2, 'Login'),
(3, 1, 5, 6, 2, 3, 'Logout'),
(11, 2, 1, 2, 1, 1, 'Home');
--
INSERT INTO menu_link_status (status_id, status) VALUES
(1, 'A'),
(2, 'LI'),
(3, 'LO');
--
INSERT INTO menu_type (menu_type_id, menu_type) VALUES
(1, 'vertical'),
(2, 'horizontal');
--
INSERT INTO menu_urls (url_id, page_id, url, modified_date) VALUES
(1, 1, '', '2008-12-07 16:41:49'),
(2, 2, 'user/login', '2008-12-06 22:41:00'),
(3, 3, 'user/logout', '2008-12-06 22:41:00');
--
INSERT INTO modules (module_id, module_name_id, position_id, module, sort_order, show_title, params, html) VALUES
(1, 1, 3, 'Top Menu', 1, 0, 'menu=Top Menu\r\nclass_sfx=-nav\r\nmoduleclass_sfx=', NULL),
(2, 1, 1, 'Main Menu', 2, 1, 'menu=Main Menu\r\nclass_sfx=\r\nmoduleclass_sfx=_menu', NULL),
(3, 2, 1, 'Site Specs', 3, 1, NULL, '<p>Site best viewed in a screen resolution of 1024x768 &#038; 32 bit colours or higher using the latest version of <a href="http://www.mozilla.com/en-US/firefox" target="_blank">Firefox</a></p>\r\n	<a href="http://www.mozilla.com/en-US/firefox" target="_blank"><img src="/templates/abstractportal/images/firefox.png" /></a>'),
(4, 2, 1, 'Logo', 1, 0, NULL, '<div id="uthandoLogo"></div>');
--
INSERT INTO modules_position (position_id, position) VALUES
(1, 'left'),
(2, 'right'),
(3, 'top menu');
--
INSERT INTO module_names (module_name_id, module_name) VALUES
(1, 'menu'),
(2, 'custom');
--
INSERT INTO pages (page_id, page, content, date_entered, hits, deletable) VALUES
(1, 'Welcome to Uthando CMS', '<p>this is some content more and more</p>', '2008-12-09 13:16:54', 196, 'N'),
(2, 'Login', '', '2008-10-19 12:53:26', 2777, 'N'),
(3, 'Logout', '', '2008-09-27 13:09:14', 263, 'N');
--