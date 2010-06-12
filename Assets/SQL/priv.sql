#admin
GRANT USAGE ON *.* TO 'uthando_admin'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE, DELETE ON `shaunfre\_core`.* TO 'uthando_admin'@'localhost';
GRANT SELECT ON `shaunfre\_admin`.* TO 'uthando_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `UthandoCMS_sessions`.`shaun` TO 'uthando_admin'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `uthando_ushop`.* TO 'uthando_admin'@'localhost';

#user
GRANT USAGE ON *.* TO 'uthando_user'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT ON `shaunfre\_core`.* TO 'uthando_user'@'localhost';
GRANT INSERT (user_group_id, cdate, password, email_type_id, activation, username, email, first_name, iv, last_name, user_id, mdate), UPDATE (user_group_id, cdate, password, email_type_id, activation, username, email, first_name, iv, last_name, user_id, mdate) ON `shaunfre_core`.`users` TO 'uthando_user'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `UthandoCMS_sessions`.`shaun` TO 'uthando_user'@'localhost';
GRANT SELECT ON `uthando\_ushop`.* TO 'uthando_user'@'localhost';
GRANT INSERT, UPDATE, DELETE ON `uthando_ushop`.`order_items` TO 'uthando_user'@'localhost';
GRANT INSERT, UPDATE, DELETE ON `uthando_ushop`.`shoppingcart` TO 'uthando_user'@'localhost';
GRANT INSERT, UPDATE ON `uthando_ushop`.`user_info` TO 'uthando_user'@'localhost';
GRANT INSERT, UPDATE, DELETE ON `uthando_ushop`.`orders` TO 'uthando_user'@'localhost';
GRANT INSERT, UPDATE ON `uthando_ushop`.`user_cda` TO 'uthando_user'@'localhost';

#guest
GRANT USAGE ON *.* TO 'uthando_guest'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT ON `shaunfre\_core`.* TO 'uthando_guest'@'localhost';
GRANT INSERT (user_group_id, cdate, password, email_type_id, activation, username, email, first_name, iv, last_name, user_id, mdate) ON `shaunfre_core`.`users` TO 'uthando_guest'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `UthandoCMS_sessions`.`shaun` TO 'uthando_guest'@'localhost';
GRANT SELECT ON `uthando\_ushop`.* TO 'uthando_guest'@'localhost';
GRANT INSERT, UPDATE, DELETE ON `uthando_ushop`.`shoppingcart` TO 'uthando_guest'@'localhost';
