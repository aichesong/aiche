<?php if (!defined('ROOT_PATH')) exit('No Permission');

class Transfer_MoneyModel extends Transfer_Money
{
    //1为已收到，2为过期
    const STATUS_NOT_RECEIVED = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_EXPIRED = 2;
}