
CREATE TABLE `countries` (
  `cnt_id` int(11) NOT NULL AUTO_INCREMENT,
  `cnt_code` char(3) NOT NULL,
  `cnt_title` varchar(100) NOT NULL,
  `cnt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cnt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_name` varchar(50) NOT NULL,
  `usr_active` tinyint(1) DEFAULT 0,
  `usr_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usr_id`)
  UNIQUE KEY `users_usr_name_uindex` (`usr_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE `numbers` (
  `num_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cnt_id` int(11) NOT NULL,
  `num_number` varchar(15) NOT NULL,
  `num_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`num_id`),
  KEY `numbers_countries_cnt_id_fk` (`cnt_id`),
  CONSTRAINT `numbers_countries_cnt_id_fk` FOREIGN KEY (`cnt_id`) REFERENCES `countries` (`cnt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `send_log` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) NOT NULL,
  `num_id` bigint(20) NOT NULL,
  `log_message` varchar(100) NOT NULL,
  `log_success` tinyint(4) NOT NULL DEFAULT '0',
  `log_crated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `send_log_log_crated_index` (`log_crated`),
  KEY `send_log_numbers_num_id_fk` (`num_id`),
  KEY `send_log_users_usr_id_fk` (`usr_id`),
  CONSTRAINT `send_log_numbers_num_id_fk` FOREIGN KEY (`num_id`) REFERENCES `numbers` (`num_id`),
  CONSTRAINT `send_log_users_usr_id_fk` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `send_log_aggregated` (
  `log_agg_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `log_agg_date` date NOT NULL,
  `log_agg_usr_id` int(11) DEFAULT NULL,
  `log_agg_cnt_id` int(11) DEFAULT NULL,
  `log_agg_count_sent_success` int(11) DEFAULT NULL,
  `log_agg_count_sent_fail` int(11) DEFAULT NULL,
  PRIMARY KEY (`log_agg_id`),
  KEY `send_log_date_usrId_cntid_index` (`log_agg_date`,`log_agg_usr_id`,`log_agg_cnt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8