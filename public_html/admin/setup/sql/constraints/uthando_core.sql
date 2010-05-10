ALTER TABLE `ushop_countries`
  ADD CONSTRAINT `ushop_countries_ibfk_1` FOREIGN KEY (`post_zone_id`) REFERENCES `ushop_post_zones` (`post_zone_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `ushop_post_costs`
  ADD CONSTRAINT `ushop_post_costs_ibfk_1` FOREIGN KEY (`post_level_id`) REFERENCES `ushop_post_levels` (`post_level_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ushop_post_costs_ibfk_2` FOREIGN KEY (`post_zone_id`) REFERENCES `ushop_post_zones` (`post_zone_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `ushop_post_zones`
  ADD CONSTRAINT `ushop_post_zones_ibfk_1` FOREIGN KEY (`tax_code_id`) REFERENCES `ushop_tax_codes` (`tax_code_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `ushop_tax_codes`
  ADD CONSTRAINT `ushop_tax_codes_ibfk_1` FOREIGN KEY (`tax_rate_id`) REFERENCES `ushop_tax_rates` (`tax_rate_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;