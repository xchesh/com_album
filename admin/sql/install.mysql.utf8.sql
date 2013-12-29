DROP TABLE IF EXISTS `#__album`;
DROP TABLE IF EXISTS `#__album_image`;
DROP TABLE IF EXISTS `#__album_video`;

CREATE TABLE `#__album` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `asset_id` int(10) NOT NULL DEFAULT '0',
    `name` varchar(255) NOT NULL,
    `alias` varchar(255) NOT NULL,
    `type` int(2) NOT NULL DEFAULT '0',
    `catid` int(11) NOT NULL DEFAULT '0',
    `ordering` int(11) NOT NULL DEFAULT '0',
    `params` TEXT NOT NULL DEFAULT '',
    `amount` int(3) NOT NULL DEFAULT '0',
    `cover` varchar(255) NOT NULL DEFAULT '',
    `video` TEXT NOT NULL DEFAULT '',
    PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__album_image` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `alb_id` int(11) NOT NULL DEFAULT '0',
    `src` varchar(255) NOT NULL,
    `alt` TEXT NOT NULL DEFAULT '',
    `title` TEXT NOT NULL DEFAULT '',
    `caption` TEXT NOT NULL DEFAULT '',
    `min` varchar(255) NOT NULL,
    PRIMARY KEY  (`id`),
    FOREIGN KEY (`alb_id`)
    REFERENCES `#__album` (`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;