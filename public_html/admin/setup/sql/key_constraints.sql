ALTER TABLE menus
  ADD CONSTRAINT menus_ibfk_1 FOREIGN KEY (menu_type_id) REFERENCES menu_type (menu_type_id);
--
ALTER TABLE menu_items
  ADD CONSTRAINT menu_items_ibfk_1 FOREIGN KEY (menu_id) REFERENCES menus (menu_id),
  ADD CONSTRAINT menu_items_ibfk_2 FOREIGN KEY (status_id) REFERENCES menu_link_status (status_id),
  ADD CONSTRAINT menu_items_ibfk_3 FOREIGN KEY (url_id) REFERENCES menu_urls (url_id);
--
ALTER TABLE menu_urls
  ADD CONSTRAINT menu_urls_ibfk_1 FOREIGN KEY (page_id) REFERENCES pages (page_id);
--
ALTER TABLE modules
  ADD CONSTRAINT modules_ibfk_1 FOREIGN KEY (module_name_id) REFERENCES module_names (module_name_id),
  ADD CONSTRAINT modules_ibfk_2 FOREIGN KEY (position_id) REFERENCES modules_position (position_id);
--
ALTER TABLE users
  ADD CONSTRAINT users_ibfk_2 FOREIGN KEY (email_type_id) REFERENCES email_type (email_type_id);
--