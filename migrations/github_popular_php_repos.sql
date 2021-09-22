/*
Target Server Type    : MYSQL
Target Server Version : 50735
File Encoding         : 65001

Date: 2021-09-22 10:22:19

Created By: Jason Stoyles for the purpose of storing popular PHP repos from Github
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `github_popular_php_repos`
-- ----------------------------
DROP TABLE IF EXISTS `github_popular_php_repos`;
CREATE TABLE `github_popular_php_repos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `github_id` int(11) NOT NULL,
  `github_name` varchar(255) NOT NULL,
  `github_url` varchar(255) NOT NULL,
  `github_created_date` datetime NOT NULL,
  `github_last_published_date` datetime NOT NULL,
  `github_description` text NOT NULL,
  `github_star_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
