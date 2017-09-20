CREATE TABLE IF NOT EXISTS `pay_transfer_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_user` int(11) NOT NULL COMMENT '发起转帐或红包的人',
  `to_user` int(11) NOT NULL COMMENT '接收人',
  `send_time` int(11) NOT NULL COMMENT '发送时间',
  `receive_time` int(11) DEFAULT NULL COMMENT '收到时间',
  `money` decimal(10,2) NOT NULL COMMENT '转了多少钱',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1为已收到，2为过期',
  `txt` text COMMENT '注释',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1红包 2 转帐',
  `transaction_number` char(20) NOT NULL COMMENT '交易单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='转帐，红包' AUTO_INCREMENT=1 ;
