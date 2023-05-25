SET FOREIGN_KEY_CHECKS=0;

/* VIP */
DROP TABLE IF EXISTS `ny_game`;
CREATE TABLE `ny_game` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(1000) NOT NULL,
`url` varchar(1000) NOT NULL,
`admin_username` varchar(100) NOT NULL,
`admin_password` varchar(100) NOT NULL,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;