

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `ucenter_admin_base_protocol`
-- ----------------------------
DROP TABLE IF EXISTS `ucenter_admin_base_protocol`;
CREATE TABLE `ucenter_admin_base_protocol` (
  `protocol_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '协议索引Id',
  `cmd_id` smallint(4) NOT NULL DEFAULT '0' COMMENT '协议Id',
  `ctl` varchar(50) NOT NULL DEFAULT '' COMMENT '控制器类名称',
  `met` varchar(50) NOT NULL DEFAULT '' COMMENT '控制器方法',
  `db` enum('master','slave') NOT NULL DEFAULT 'master' COMMENT '连接数据库类型',
  `typ` enum('e','json','msgpcak','amf') NOT NULL DEFAULT 'json' COMMENT '输出数据默认类型',
  `rights_id` mediumint(20) NOT NULL COMMENT '权限Id',
  `log` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否记录日志',
  `struct` varchar(100) NOT NULL DEFAULT '' COMMENT '生成结构体，独立使用',
  `comment` varchar(255) NOT NULL DEFAULT '' COMMENT '注释',
  `0` varchar(255) NOT NULL DEFAULT 'int16_t:cmd_id' COMMENT '第一个字段',
  `1` varchar(255) NOT NULL DEFAULT '',
  `2` varchar(255) NOT NULL DEFAULT '',
  `3` varchar(255) NOT NULL DEFAULT '',
  `4` varchar(255) NOT NULL DEFAULT '',
  `5` varchar(255) NOT NULL DEFAULT '',
  `6` varchar(255) NOT NULL DEFAULT '',
  `7` varchar(255) NOT NULL DEFAULT '',
  `8` varchar(255) NOT NULL DEFAULT '',
  `9` varchar(255) NOT NULL DEFAULT '',
  `10` varchar(255) NOT NULL DEFAULT '',
  `11` varchar(255) NOT NULL DEFAULT '',
  `12` varchar(255) NOT NULL DEFAULT '',
  `13` varchar(255) NOT NULL DEFAULT '',
  `14` varchar(255) NOT NULL DEFAULT '',
  `15` varchar(255) NOT NULL DEFAULT '',
  `16` varchar(255) NOT NULL DEFAULT '',
  `17` varchar(255) NOT NULL DEFAULT '',
  `18` varchar(255) NOT NULL DEFAULT '',
  `19` varchar(255) NOT NULL DEFAULT '',
  `20` varchar(255) NOT NULL DEFAULT '',
  `21` varchar(255) NOT NULL DEFAULT '',
  `22` varchar(255) NOT NULL DEFAULT '',
  `23` varchar(255) NOT NULL DEFAULT '',
  `24` varchar(255) NOT NULL DEFAULT '',
  `25` varchar(255) NOT NULL DEFAULT '',
  `26` varchar(255) NOT NULL DEFAULT '',
  `27` varchar(255) NOT NULL DEFAULT '',
  `28` varchar(255) NOT NULL DEFAULT '',
  `29` varchar(255) NOT NULL DEFAULT '',
  `30` varchar(255) NOT NULL DEFAULT '',
  `31` varchar(255) NOT NULL DEFAULT '',
  `32` varchar(255) NOT NULL DEFAULT '',
  `33` varchar(255) NOT NULL DEFAULT '',
  `34` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`protocol_id`),
  UNIQUE KEY `cmd_id_key` (`cmd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='基础通信协议表';

-- ----------------------------
--  Table structure for `ucenter_admin_log_action`
-- ----------------------------
DROP TABLE IF EXISTS `ucenter_admin_log_action`;
CREATE TABLE `ucenter_admin_log_action` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `user_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '玩家Id',
  `user_account` varchar(100) NOT NULL DEFAULT '' COMMENT '角色账户',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '角色名称',
  `action_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '行为id == protocal_id -> rights_id',
  `log_param` text NOT NULL COMMENT '请求的参数',
  `log_ip` varchar(20) NOT NULL DEFAULT '',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '记录时间',
  PRIMARY KEY (`log_id`),
  KEY `player_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户行为日志表';

-- ----------------------------
--  Table structure for `ucenter_admin_rights_group`
-- ----------------------------
DROP TABLE IF EXISTS `ucenter_admin_rights_group`;
CREATE TABLE `ucenter_admin_rights_group` (
  `rights_group_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限组id',
  `rights_group_name` varchar(50) NOT NULL COMMENT '权限组名称',
  `rights_group_rights_ids` text NOT NULL COMMENT '权限列表',
  `rights_group_add_time` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`rights_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='权限组表';

-- ----------------------------
--  Records of `ucenter_admin_rights_group`
-- ----------------------------
BEGIN;
INSERT INTO `ucenter_admin_rights_group` VALUES ('1', '系统管理员', '[3000,3020,3040,3060,3080,3100,3160,3180,3200,3220,3240,3260,3280,3300,3320,3340,3360,3380,3400,3420,3440,4000,4400,4430,4450,4500,4550,4600,4650,4750,4900,4950,5000,5050,5100,5200,5350,5400,5450,5500,5550,5650,5751,5800,5850,5900,5950,6000,6250,6300,6350,6400,6450,6500,6550,6600,6650,6700,6750,6800,6810,6820,6830,6840,6850,6900,6950,7000,7010,7020,7030,7040,7100,7110,7120,7130,7140,7160,7170,7180,7200,7210,7220,7230,7240,7260,7270,7280,7350,7360,7370,7380,7390,7410,7420,7430,7500,7510,7520,7530,7540,7560,7570,7580,7730,7740,7750,7760,7770,7780,7810,7820,7830,7840,7850,7860,7910,7920,7930,7940,7950,7960,7970,8100,8130,8150,8200,8250,8300,8350,8400,8501,8502,8550,8600,8650,8700,8750,8851,8852,8900,8950,9000,9050,9100,9250,9300,9350,9360,9400,9450,9500,9510,9550,9600,9650,9660,9700,9750,9800,9850,9900,9950,10000,10050,10100,10150,10200,10250,10300,10350,10400,10450,10500,10550,10600,10650,10700,10760,10770,10780,10810,10820,10830,10860,10870,10880,10900,10920,10940,11000,11010,11020,11030,11100,11110,11120,11200,11210,11220,11300,11310,11320,11400,11410,11420,11510,11520,11530,11540,11620,11630,11640,11650,11700,11710,11720,11730,11833,11834,11835,11837,11838,11843,11844,11845,11847,11848,31320,32666,32667,32668,32669,33110,33111,33120,33121,33122,33123,33124,33125,33130,33131,33132,33133,33140,33141,33142,33143,33150,33160,33161,33162,34000,34001,34002,34003,34004,34005,34006,34007,34010,34011,34012,34013,34014,34015,34016,34017,34020,34021,34022,34023,34024,34030,34031,34032,34033,34034,34035,34036,34037,34050,34051,34052,34053,34055,34056,34057,34058,34059,34060,34061,34062,34063,34064,34065,34066,34067,34069,34070,34071,34080,34081,34082,34083,34084,34085,34086,34087,34089,34090,34091,34092,34093,34095,34096,34097,34098,34099,34100,34101,34102,34103,34104,34105,34106,34200,34201,34202,34203,34204,34205,34206,34207,34300,34301,34302,34303,34400,34401,34402,34403,34410,34411,34412,34413,34420,34421,34422,34423,34500,34501,34502,34503,34504,34505,34506,34507,34508,34509,34510,34511,34600,34601,34602,34603]', '2013');
COMMIT;

-- ----------------------------
--  Table structure for `ucenter_admin_user_base`
-- ----------------------------
DROP TABLE IF EXISTS `ucenter_admin_user_base`;
CREATE TABLE `ucenter_admin_user_base` (
  `user_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_account` varchar(50) NOT NULL COMMENT '用户帐号',
  `user_password` char(32) NOT NULL COMMENT '用户密码',
  `user_key` varchar(32) NOT NULL COMMENT '用户key',
  `user_realname` varchar(32) NOT NULL COMMENT '用户真实姓名',
  `user_nickname` varchar(30) NOT NULL COMMENT '用户昵称',
  `user_mobile` varchar(20) NOT NULL COMMENT '用户手机号',
  `user_email` varchar(100) NOT NULL COMMENT '用户密码',
  `rights_group_id` smallint(4) NOT NULL COMMENT '用户权限组id',
  `user_rights_ids` text NOT NULL COMMENT '用户权限',
  `user_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否被封禁 0:未被封禁 1:被封禁',
  `user_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否管理员 0:不是',
  `server_id` mediumint(8) NOT NULL COMMENT '服务id-公司关联-关联数据库-key中',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `ucenter_admin_user_base`
-- ----------------------------
BEGIN;
INSERT INTO `ucenter_admin_user_base` VALUES ('10001', 'admin', '', '', '', '', '', '', '1', '', '0', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `ucenter_admin_web_config`
-- ----------------------------
DROP TABLE IF EXISTS `ucenter_admin_web_config`;
CREATE TABLE `ucenter_admin_web_config` (
  `config_key` varchar(50) NOT NULL COMMENT '数组下标',
  `config_value` text NOT NULL COMMENT '数组值',
  `config_type` varchar(50) NOT NULL,
  `config_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态值，1可能，0不可用',
  `config_comment` text NOT NULL,
  `config_datatype` enum('string','json','number') NOT NULL DEFAULT 'string' COMMENT '数据类型',
  PRIMARY KEY (`config_key`),
  KEY `index` (`config_key`,`config_type`) COMMENT '(null)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='网站配置表';

-- ----------------------------
--  Records of `ucenter_admin_web_config`
-- ----------------------------
BEGIN;
INSERT INTO `ucenter_admin_web_config` VALUES ('current_db_version', '37965', 'site', '1', '', 'string'), ('current_version', '1.0.1', 'site', '1', '', 'string'), ('required_mysql_version', '5.0', 'site', '1', '', 'string'), ('required_php_version', '5.3', 'site', '1', '', 'string');
COMMIT;

-- ----------------------------
--  Table structure for `ucenter_admin_web_config`
-- ----------------------------
DROP TABLE IF EXISTS `ucenter_admin_web_config`;
CREATE TABLE `ucenter_admin_web_config` (
  `config_key` varchar(50) NOT NULL COMMENT '数组下标',
  `config_value` text NOT NULL COMMENT '数组值',
  `config_type` varchar(50) NOT NULL,
  `config_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态值，1可能，0不可用',
  `config_comment` text NOT NULL,
  `config_datatype` enum('string','json','number') NOT NULL DEFAULT 'string' COMMENT '数据类型',
  PRIMARY KEY (`config_key`),
  KEY `index` (`config_key`,`config_type`) COMMENT '(null)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='网站配置表';

-- ----------------------------
--  Records of `ucenter_admin_web_config`
-- ----------------------------
BEGIN;
INSERT INTO `ucenter_admin_web_config` VALUES ('current_db_version', '37965', 'site', '1', '', 'string'), ('current_version', '1.0.1', 'site', '1', '', 'string'), ('required_mysql_version', '5.0', 'site', '1', '', 'string'), ('required_php_version', '5.3', 'site', '1', '', 'string');
COMMIT;



SET FOREIGN_KEY_CHECKS = 1;
