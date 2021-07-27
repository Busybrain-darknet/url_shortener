CREATE DATABASE IF NOT EXISTS `url`;
USE url;
-- Table structure for table `url_info` 
CREATE TABLE `url_info` (   
`long_url` VARCHAR(500) NOT NULL,  
`short_url` VARCHAR(10) NOT NULL,
`hits` INT(11) DEFAULT '0' ,
`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,    
PRIMARY KEY  (`short_url`)
) ENGINE = InnoDB   DEFAULT CHARSET=latin1 ;