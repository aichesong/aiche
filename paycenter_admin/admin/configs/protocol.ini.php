<?php
$ccmd_rows = array (
  'Bug' => 
  array (
    'bug' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'bug_type' => 'int8_t',
      'msg' => 'string',
    ),
  ),
'Message_Record' =>
    array (
        'index' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'getList' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'manage' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'getFriends' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'send' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'sendMessage' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
    ),
  'Service' => 
  array (
    'index' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4400',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Version' => 
  array (
    'version' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'client_version' => 'string',
    ),
  ),
  'Login' => 
  array (
    'login' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'user_account' => 'string',
      'user_password' => 'string',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Index' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34058',
      'cmd_id' => 'int16_t',
    ),
    'main' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34058',
      'cmd_id' => 'int16_t',
    ),
  ),
  'User_Base' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '34059',
      'log' => '1',
      'cmd_id' => 'int16_t',
      'user_id' => 'uint32',
    ),
    'userList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '34059',
      'log' => '1',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '34061',
      'log' => '1',
      'cmd_id' => 'int16_t',
    ),
    'getname' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34059',
      'log' => '1',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34066',
      'log' => '1',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34067',
      'log' => '1',
      'cmd_id' => 'int16_t',
    ),
    'right' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34062',
      'log' => '1',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Log_Action' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '34065',
      'cmd_id' => 'int16_t',
    ),
    'actionList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '34065',
      'cmd_id' => 'int16_t',
    ),
    'queryAllUser' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34202',
      'cmd_id' => 'int16_t',
    ),
    'queryAllOperateType' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34202',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_Assist' => 
  array (
    'assistList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Rights_' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'rightsList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Rights_Group' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '34062',
      'cmd_id' => 'int16_t',
    ),
    'rightsGroupList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '34062',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '34062',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34062',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34063',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34063',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34063',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_Employee' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '34061',
      'cmd_id' => 'int16_t',
    ),
    'employeeList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '34061',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34061',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34066',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34061',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34064',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '34061',
      'cmd_id' => 'int16_t',
    ),
    'queryAllEmployee' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34062',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_Test' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_Test_1' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_ShippingAddress' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '11000',
      'cmd_id' => 'int16_t',
    ),
    'shippingAddressList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '11000',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '11020',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '11000',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '11010',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '11020',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '11030',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_SettlementAccount' => 
  array (
    'settlementAccountList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '34206',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '34205',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34206',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34203',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34205',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34204',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6810',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_Warehouse' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'warehouseList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Vendor_Base' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '4900',
      'cmd_id' => 'int16_t',
    ),
    'vendorList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4900',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5000',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4900',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5000',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5050',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4950',
      'cmd_id' => 'int16_t',
    ),
    'getNextNo' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4900',
      'cmd_id' => 'int16_t',
    ),
    'checkName' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4900',
      'cmd_id' => 'int16_t',
    ),
    'BaseList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4900',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Vendor_Level' => 
  array (
    'levelList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34092',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34089',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34090',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34091',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34092',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34091',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34092',
      'cmd_id' => 'int16_t',
    ),
    'queryAllLevel' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34092',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Vendor_Type' => 
  array (
    'TypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6450',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6500',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6600',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6550',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6500',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6550',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6450',
      'cmd_id' => 'int16_t',
    ),
    'queryAllType' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6450',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Customer' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'customerList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'getNextNo' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'checkName' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Goods_Base' => 
  array (
    'sernum' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
    'goodsList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
      'user_account' => 'string',
      'user_password' => 'string',
      'skey' => 'string',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '5400',
      'cmd_id' => 'int16_t',
      'user_account' => 'string',
      'user_password' => 'string',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '5450',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5400',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5450',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5500',
      'cmd_id' => 'int16_t',
    ),
    'getNextNo' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
    'checkName' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
    'select' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
    'BaseList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
    'skus' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'skuslist' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'getprice' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
    'prints' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5550',
      'cmd_id' => 'int16_t',
    ),
    'printp' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5550',
      'cmd_id' => 'int16_t',
    ),
    'change' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5450',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Goods_UnitType' => 
  array (
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '32668',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '32669',
      'cmd_id' => 'int16_t',
    ),
    'getNextNo' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'checkName' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'goodsUnitTypeList' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'slave',
      'rid' => '32668',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'slave',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '32667',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Purchase_Order' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7100',
      'cmd_id' => 'int16_t',
    ),
    'lists' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7100',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7100',
      'cmd_id' => 'int16_t',
    ),
    'contacts' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4450',
      'cmd_id' => 'int16_t',
      'transType' => 'string',
      'billType' => 'string',
    ),
    'list1' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7100',
      'cmd_id' => 'int16_t',
      'matchCon' => 'string',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'list2' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7100',
      'cmd_id' => 'int16_t',
    ),
    'list3' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7100',
      'cmd_id' => 'int16_t',
    ),
    'OrderList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7100',
      'cmd_id' => 'int16_t',
      'matchCon' => 'string',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7110',
      'cmd_id' => 'int16_t',
    ),
    'checkpur' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7170',
      'cmd_id' => 'int16_t',
    ),
    'check' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7170',
      'cmd_id' => 'int16_t',
    ),
    'recheckpur' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7180',
      'cmd_id' => 'int16_t',
    ),
    'recheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7180',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7130',
      'cmd_id' => 'int16_t',
    ),
    'delete' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7130',
      'cmd_id' => 'int16_t',
    ),
    'queryPurchaseType' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34030',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7120',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Purchase_Order ' => 
  array (
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7120',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Purchase_Bill' => 
  array (
    'getlist_p' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'delete_p' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7230',
      'cmd_id' => 'int16_t',
    ),
    'purchaseList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'purchaseList2' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'addNew' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7210',
      'cmd_id' => 'int16_t',
    ),
    'pcheck_p' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7270',
      'cmd_id' => 'int16_t',
    ),
    'precheck_p' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7280',
      'cmd_id' => 'int16_t',
    ),
    'checkInvPu_p' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7270',
      'cmd_id' => 'int16_t',
    ),
    'rsBatchCheckInvPu_p' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7280',
      'cmd_id' => 'int16_t',
    ),
    'check_rp' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7270',
      'cmd_id' => 'int16_t',
    ),
    'recheck_rp' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7280',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'TypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'queryAllType' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'getlist_rp' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'delete_rp' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7230',
      'cmd_id' => 'int16_t',
    ),
    'pcheck_rp' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7270',
      'cmd_id' => 'int16_t',
    ),
    'pcheck_s' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7570',
      'cmd_id' => 'int16_t',
    ),
    'pcheck_rs' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7570',
      'cmd_id' => 'int16_t',
    ),
    'precheck_rp' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7280',
      'cmd_id' => 'int16_t',
    ),
    'precheck_s' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7580',
      'cmd_id' => 'int16_t',
    ),
    'precheck_rs' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7580',
      'cmd_id' => 'int16_t',
    ),
    'checkInvPu_rs' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7570',
      'cmd_id' => 'int16_t',
    ),
    'rsBatchCheckInvPu_rs' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7580',
      'cmd_id' => 'int16_t',
    ),
    'check_s' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7570',
      'cmd_id' => 'int16_t',
    ),
    'recheck_s' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7580',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Transport_Bill' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'BaseList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'queryBase' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'addNew' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7210',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Sale_Bill' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'indexList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'manageList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'save' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7510',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7510',
      'cmd_id' => 'int16_t',
    ),
    'lists' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'list2' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'delete_s' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7530',
      'cmd_id' => 'int16_t',
    ),
    'list1_s' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'update_s' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7520',
      'cmd_id' => 'int16_t',
    ),
    'delete_rs' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7530',
      'cmd_id' => 'int16_t',
    ),
    'list1_rs' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'list1_p' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'list1_rp' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7200',
      'cmd_id' => 'int16_t',
    ),
    'update_rs' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7520',
      'cmd_id' => 'int16_t',
    ),
    'serNumList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'getWarehouse_location_number' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7500',
      'cmd_id' => 'int16_t',
    ),
    'contacts' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4900',
      'cmd_id' => 'int16_t',
    ),
    'update_p' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7220',
      'cmd_id' => 'int16_t',
    ),
    'update_rp' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7220',
      'cmd_id' => 'int16_t',
    ),
    'employer' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4450',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Sale_Order' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7350',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7350',
      'cmd_id' => 'int16_t',
    ),
    'orderList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7350',
      'cmd_id' => 'int16_t',
    ),
    'list1' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7350',
      'cmd_id' => 'int16_t',
    ),
    'list2' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7350',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7360',
      'cmd_id' => 'int16_t',
    ),
    'update' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7370',
      'cmd_id' => 'int16_t',
    ),
    'checksal' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7420',
      'cmd_id' => 'int16_t',
    ),
    'rechecksal' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7430',
      'cmd_id' => 'int16_t',
    ),
    'pcheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7420',
      'cmd_id' => 'int16_t',
    ),
    'precheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7430',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7380',
      'cmd_id' => 'int16_t',
    ),
    'contacts' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4450',
      'cmd_id' => 'int16_t',
    ),
    'employer' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4450',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Finance_ReceiptBill' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7810',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7810',
      'cmd_id' => 'int16_t',
    ),
    'select' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7810',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7820',
      'cmd_id' => 'int16_t',
    ),
    'receiveBillList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7810',
      'cmd_id' => 'int16_t',
    ),
    'update' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7830',
      'cmd_id' => 'int16_t',
    ),
    'receiveupdate' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7810',
      'cmd_id' => 'int16_t',
    ),
    'delete' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7840',
      'cmd_id' => 'int16_t',
    ),
    'check' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7850',
      'cmd_id' => 'int16_t',
    ),
    'recheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7860',
      'cmd_id' => 'int16_t',
    ),
    'pcheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7850',
      'cmd_id' => 'int16_t',
    ),
    'precheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7860',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Finance_PaymentBill' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7730',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7730',
      'cmd_id' => 'int16_t',
    ),
    'select' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7730',
      'cmd_id' => 'int16_t',
    ),
    'findUnhxList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7730',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7740',
      'cmd_id' => 'int16_t',
    ),
    'paymentBillList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7730',
      'cmd_id' => 'int16_t',
    ),
    'updatePayment' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7750',
      'cmd_id' => 'int16_t',
    ),
    'paymentupdate' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7730',
      'cmd_id' => 'int16_t',
    ),
    'delete' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7760',
      'cmd_id' => 'int16_t',
    ),
    'check' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7770',
      'cmd_id' => 'int16_t',
    ),
    'recheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7780',
      'cmd_id' => 'int16_t',
    ),
    'pcheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7770',
      'cmd_id' => 'int16_t',
    ),
    'precheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7780',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_Config' => 
  array (
    'smsConfig' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33110',
      'cmd_id' => 'int16_t',
    ),
    'smsSave' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33111',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34200',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34201',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_Template' => 
  array (
    'smsTemplateList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33120',
      'cmd_id' => 'int16_t',
    ),
    'smsManageTemplate' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33120',
      'cmd_id' => 'int16_t',
    ),
    'smsPreview' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33124',
      'cmd_id' => 'int16_t',
    ),
    'sendSmsPreview' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33125',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33122',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33121',
      'cmd_id' => 'int16_t',
    ),
    'getSmsTemplateList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33120',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33123',
      'cmd_id' => 'int16_t',
    ),
    'getSmsPreviewData' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33124',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_SmsSend' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33140',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33140',
      'cmd_id' => 'int16_t',
    ),
    'SmsSendList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33140',
      'cmd_id' => 'int16_t',
    ),
    'default_send' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33142',
      'cmd_id' => 'int16_t',
    ),
    'send_run' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33142',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33141',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33142',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33143',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_SmsRule' => 
  array (
    'addRule' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33130',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33130',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33130',
      'cmd_id' => 'int16_t',
    ),
    'SmsRuleList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33130',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33133',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33131',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33132',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_SmsLog' => 
  array (
    'SmsLogList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33150',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33150',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_SmsFree' => 
  array (
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33160',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '33160',
      'cmd_id' => 'int16_t',
    ),
    'SmsFreeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33160',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33162',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '33161',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_Mail' => 
  array (
    'config' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34000',
      'cmd_id' => 'int16_t',
    ),
    'save' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34001',
      'cmd_id' => 'int16_t',
      'mailSmtp' => 'string',
      'mailAccount' => 'string',
      'mailPassword' => 'string',
    ),
    'templateList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34002',
      'cmd_id' => 'int16_t',
    ),
    'getTemplateList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34002',
      'cmd_id' => 'int16_t',
    ),
    'manageTemplate' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34002',
      'cmd_id' => 'int16_t',
    ),
    'addTemplate' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34004',
      'cmd_id' => 'int16_t',
      'template_subject' => 'string',
      'template_title' => 'string',
      'template_flag' => 'string',
      'template_type' => 'string',
      'template_status' => 'uint32',
    ),
    'editTemplate' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34003',
      'cmd_id' => 'int16_t',
      'template_id' => 'uint32',
      'template_subject' => 'string',
      'template_title' => 'string',
      'template_flag' => 'string',
      'template_type' => 'string',
      'template_status' => 'uint32',
    ),
    'removeTemplate' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34005',
      'cmd_id' => 'int16_t',
      'template_id' => 'uint32',
    ),
    'previewRuleTemplate' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34006',
      'cmd_id' => 'int16_t',
    ),
    'sendMail' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34007',
      'cmd_id' => 'int16_t',
      'send_content' => 'string',
      'email' => 'string',
    ),
    'queryMailTemplate' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34002',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_MailRule' => 
  array (
    'ruleList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34010',
      'cmd_id' => 'int16_t',
    ),
    'getMailRuleList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34010',
      'cmd_id' => 'int16_t',
    ),
    'manageMailRule' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34010',
      'cmd_id' => 'int16_t',
    ),
    'removeMailRule' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34013',
      'cmd_id' => 'int16_t',
      'rule_id' => 'uint32',
    ),
    'addMailRule' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34012',
      'cmd_id' => 'int16_t',
      'rule_title' => 'string',
      'rule_info' => 'string',
      'rule_weight' => 'uint32',
      'rule_content' => 'string',
      'rule_status' => 'uint32',
    ),
    'editMailRule' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34011',
      'cmd_id' => 'int16_t',
      'rule_id' => 'uint32',
      'rule_title' => 'string',
      'rule_info' => 'string',
      'rule_weight' => 'uint32',
      'rule_content' => 'string',
      'rule_status' => 'uint32',
    ),
    'queryMailRule' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34010',
      'cmd_id' => 'int16_t',
    ),
    'manageRules' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34010',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_MailSend' => 
  array (
    'sendList' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34014',
      'cmd_id' => 'int16_t',
    ),
    'getMailSendList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34014',
      'cmd_id' => 'int16_t',
    ),
    'manageMailSend' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34014',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34017',
      'cmd_id' => 'int16_t',
      'send_id' => 'uint32',
    ),
    'default_send' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34015',
      'cmd_id' => 'int16_t',
      'send_id' => 'uint32',
    ),
    'send_run' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34015',
      'cmd_id' => 'int16_t',
      'send_id' => 'uint32',
    ),
    'addSend' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34016',
      'cmd_id' => 'int16_t',
      'send_rule_id' => 'uint32',
      'send_template_id' => 'uint32',
      'send_issend' => 'uint32',
    ),
    'editSend' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34015',
      'cmd_id' => 'int16_t',
      'send_id' => 'uint32',
      'send_rule_id' => 'uint32',
      'send_template_id' => 'uint32',
      'send_issend' => 'uint32',
    ),
  ),
  'Base_MailLog' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34020',
      'cmd_id' => 'int16_t',
    ),
    'MailLogList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34020',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34021',
      'cmd_id' => 'int16_t',
      'log_account' => 'string',
      'log_email' => 'string',
      'log_time' => 'uint32',
      'log_status' => 'uint32',
      'log_reason' => 'string',
      'log_content' => 'string',
    ),
  ),
  'Base_MailFree' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34022',
      'cmd_id' => 'int16_t',
      '' => '5',
    ),
    'getMailFreeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34022',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34022',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34024',
      'cmd_id' => 'int16_t',
      'free_id' => 'uint32',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34023',
      'cmd_id' => 'int16_t',
      'free_email' => 'string',
    ),
  ),
  'Purchase_Type' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34030',
      'cmd_id' => 'int16_t',
    ),
    'TypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34030',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34030',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34031',
      'cmd_id' => 'int16_t',
      'purchase_type_name' => 'string',
      'purchase_type_desc' => 'string',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34033',
      'cmd_id' => 'int16_t',
      'purchase_type_id' => 'uint32',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34032',
      'cmd_id' => 'int16_t',
      'purchase_type_id' => 'uint32',
      'purchase_type_name' => 'string',
      'purchase_type_desc' => 'string',
    ),
  ),
  'Transport_BillType' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34034',
      'cmd_id' => 'int16_t',
    ),
    'BillTypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34034',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34034',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34035',
      'cmd_id' => 'int16_t',
      'transport_bill_type_name' => 'string',
      'transport_bill_type_desc' => 'string',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34037',
      'cmd_id' => 'int16_t',
      'transport_bill_type_id' => 'uint32',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34036',
      'cmd_id' => 'int16_t',
      'transport_bill_type_id' => 'uint32',
      'transport_bill_type_name' => 'string',
      'transport_bill_type_desc' => 'string',
    ),
    'queryBillType' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34034',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Goods_Category' => 
  array (
    'list1' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6650',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6700',
      'cmd_id' => 'int16_t',
    ),
    'update' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6750',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6800',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6650',
      'cmd_id' => 'int16_t',
    ),
    'getAssistType' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6650',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Goods_Brand' => 
  array (
    'brandList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34085',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34087',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34086',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34084',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6650',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34085',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Goods_Spec' => 
  array (
    'SpecList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6650',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34083',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34082',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34080',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34081',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34080',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34081',
      'cmd_id' => 'int16_t',
    ),
    'assistSku' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '32666',
      'cmd_id' => 'int16_t',
    ),
    'update' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34080',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Goods_Unit' => 
  array (
    'getUnitList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6850',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6900',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7000',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6950',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6850',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6850',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6850',
      'cmd_id' => 'int16_t',
    ),
    'update' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6950',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Member_Base' => 
  array (
    'memberList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4450',
      'cmd_id' => 'int16_t',
    ),
    'BaseList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4450',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4550',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4600',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4550',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '4450',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '4550',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '4450',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Member_Type' => 
  array (
    'TypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6300',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6400',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6350',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
    'queryAllType' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Member_Level' => 
  array (
    'levelList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6300',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6400',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6350',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '6250',
      'cmd_id' => 'int16_t',
    ),
    'queryAllLevel' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34106',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Report_Purchase' => 
  array (
    'detail' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '9700',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'query' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9700',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
      'customerId' => 'string',
      'goodsId' => 'string',
      'storageId' => 'string',
      'billNo' => 'string',
      'categoryId' => 'string',
    ),
    'goods' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '9850',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'query_goods' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9850',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
      'customerId' => 'string',
      'goodsId' => 'string',
      'storageId' => 'string',
      'catId' => 'string',
    ),
    'vendor' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '10000',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'query_vendor' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '10000',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
      'customerId' => 'string',
      'goodsId' => 'string',
      'storageId' => 'string',
      'categoryId' => 'string',
    ),
    'follow' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '9700',
      'cmd_id' => 'int16_t',
    ),
    'follows' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9700',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Report_Fund' => 
  array (
    'accountPayDetail' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '10810',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'get_accountPayDetail' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '10810',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
      'accountId' => 'string',
      'categoryId' => 'string',
    ),
    'accountProceedsDetail' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '10860',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'get_accountProceedsDetail' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '10860',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
      'accountId' => 'string',
      'categoryId' => 'string',
    ),
    'customersReconciliation' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '11100',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'get_customersReconciliation' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '11100',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
      'categoryId' => 'string',
      'showDetail' => 'string',
    ),
    'suppliersReconciliation' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '11200',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
    ),
    'get_suppliersReconciliation' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '11200',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
      'supplierId' => 'string',
      'showDetail' => 'string',
    ),
  ),
  'Finance_OtherType' => 
  array (
    'income' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'income_delete' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'income_type_id' => 'string',
    ),
    'income_manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'income_add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'income_type_name' => 'string',
      'income_type_desc' => 'string',
    ),
    'income_edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'income_type_id' => 'string',
      'income_type_name' => 'string',
    ),
    'expense' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'expense_manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'expense_add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'expense_type_name' => 'string',
    ),
    'expense_edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'expense_type_id' => 'string',
      'expense_type_name' => 'string',
    ),
    'expense_delete' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'expense_type_id' => 'string',
    ),
    'income_list' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'skey' => 'string',
    ),
    'expense_list' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'skey' => 'string',
    ),
  ),
  'Store_Base' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3000',
      'cmd_id' => 'int16_t',
    ),
    'baseList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3000',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3040',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3020',
      'cmd_id' => 'int16_t',
      'name' => 'string',
      'cloudType' => 'string',
      'cloudCoide' => 'string',
      'locationId' => 'string',
      'expressId' => 'string',
      'settacctId' => 'string',
      'addressId' => 'string',
      'uploadPercent' => 'string',
      'undoUpload' => 'string',
      'uploadInv' => 'string',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3040',
      'cmd_id' => 'int16_t',
      'name' => 'string',
      'cloudType' => 'string',
      'cloudCoide' => 'string',
      'locationId' => 'string',
      'expressId' => 'string',
      'settacctId' => 'string',
      'addressId' => 'string',
      'uploadPercent' => 'string',
      'undoUpload' => 'string',
      'uploadInv' => 'string',
      'id' => 'string',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3060',
      'cmd_id' => 'int16_t',
      'id' => 'string',
    ),
  ),
  'Express_Logistics' => 
  array (
    'logisticsList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3180',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3180',
      'cmd_id' => 'int16_t',
    ),
    'get' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3180',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3220',
      'cmd_id' => 'int16_t',
    ),
    'lists' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3180',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3220',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3200',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3240',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Store_Goods' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3080',
      'cmd_id' => 'int16_t',
    ),
    'goods' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3100',
      'cmd_id' => 'int16_t',
      'postData' => 'json',
    ),
    'goodsList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3160',
      'cmd_id' => 'int16_t',
      'cloudStoreId' => 'string',
      'sidx' => 'string',
      'showMatch' => 'string',
      'storeGoodsName' => 'string',
      'localGoodsName' => 'string',
    ),
    'download' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3300',
      'cmd_id' => 'int16_t',
      'settlement' => 'uint32',
      'remark' => 'string',
      'billId' => 'uint32',
      'nowCheck' => 'string',
      'notCheck' => 'string',
    ),
    'downgoods' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3300',
      'cmd_id' => 'int16_t',
      'sid' => 'string',
      'goodsStatus' => 'string',
      'beginDate' => 'string',
      'endDate' => 'string',
      'goodsNumber' => 'string',
      'goodsId' => 'string',
      'goodsName' => 'string',
    ),
  ),
  'Store_Refund' => 
  array (
    'downreorder' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3020',
      'cmd_id' => 'int16_t',
    ),
    'down' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3020',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3000',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Store_OrderBase' => 
  array (
    'remove' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3340',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3280',
      'cmd_id' => 'int16_t',
      'handle' => 'string',
    ),
    'orderList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3280',
      'cmd_id' => 'int16_t',
      'beginDate' => 'string',
      'endDate' => 'string',
      'checkStatus' => 'string',
      'status' => 'string',
      'sidx' => 'string',
      'orderIdCloud' => 'string',
      'invNameCloud' => 'string',
      'buyerNumber' => 'string',
      'deliveryName' => 'string',
      'mobile' => 'string',
      'buyerDesc' => 'string',
      'salerDesc' => 'string',
      'sellerFlag' => 'string',
      'cloudStoreId' => 'string',
    ),
    'get' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3280',
      'cmd_id' => 'int16_t',
      'orderId' => 'string',
    ),
    'update' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3320',
      'cmd_id' => 'int16_t',
      'postData' => 'string',
    ),
    'download' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '3300',
      'cmd_id' => 'int16_t',
    ),
    'downorders' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3300',
      'cmd_id' => 'int16_t',
      'sid' => 'string',
      'start_created' => 'string',
      'end_created' => 'string',
    ),
  ),
  'Goods_Gallery' => 
  array (
    'getImagesById' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5350',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Goods_WarehouseSku' => 
  array (
    'getSku' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '10450',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34097',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '10450',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Store_Order' => 
  array (
    'check' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3380',
      'cmd_id' => 'int16_t',
      'orderId' => 'string',
    ),
    'recheck' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3400',
      'cmd_id' => 'int16_t',
      'orderId' => 'string',
    ),
  ),
  'Goods_WarehouseInfo' => 
  array (
    'warehouseLists' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '10450',
      'cmd_id' => 'int16_t',
      'sidx' => 'string',
      'isDelete' => 'string',
      'locationId' => 'string',
      'categoryId' => 'string',
      'goods' => 'string',
      'showZero' => 'string',
      'isSerNum' => 'string',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Warehouse_AllocateBill' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
      'postData' => 'string',
    ),
  ),
  '' => 
  array (
    '' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Warehouse_Area' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'AreaList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
      'isDelete' => 'string',
      'skey' => 'string',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5900',
      'cmd_id' => 'int16_t',
      'id' => 'string',
      'warehouse_area_id' => 'string',
      'warehouse_area_status' => 'string',
      'warehouse_area_name' => 'string',
      'warehouse_area_number' => 'string',
      'warehouse_area_square_meter' => 'string',
      'warehouse_area_remark' => 'string',
      'warehouse_name' => 'string',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5850',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5950',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Warehouse_Base' => 
  array (
    'warehouseList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'BaseList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5850',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5950',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5900',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Warehouse_Shelf' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'ShelfList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
      'skey' => 'string',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5850',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5900',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5950',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Warehouse_Location' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'LocationList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
      'skey' => 'string',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '5800',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5900',
      'cmd_id' => 'int16_t',
      'warehouse_location_id' => 'string',
      'warehouse_location_number' => 'string',
      'warehouse_shelf_id' => 'string',
      'warehouse_shelf_name' => 'string',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5850',
      'cmd_id' => 'int16_t',
      'warehouse_shelf_name' => 'string',
      'warehouse_location_number' => 'string',
      'warehouse_shelf_id' => 'string',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '5950',
      'cmd_id' => 'int16_t',
      'warehouse_location_id' => 'string',
    ),
  ),
  'Database_Update' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34050',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34050',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Database_Backup' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34055',
      'cmd_id' => 'int16_t',
    ),
    'getBackupList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34055',
      'cmd_id' => 'int16_t',
    ),
    'restore' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34052',
      'cmd_id' => 'int16_t',
    ),
    'delete' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34053',
      'cmd_id' => 'int16_t',
    ),
    'backup' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34051',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Database_Maintain' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34057',
      'cmd_id' => 'int16_t',
    ),
    'TableList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34057',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34056',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_NumberSeq' => 
  array (
    'getNextNo' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34060',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Customer_Base' => 
  array (
    'select' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '4900',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Warehouse_Type' => 
  array (
    'queryAllType' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34069',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34069',
      'cmd_id' => 'int16_t',
    ),
    'TypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34069',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34069',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34070',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '34071',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Goods_SpecValue' => 
  array (
    'SpecValueList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '6650',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Report_Sale' => 
  array (
    'follow' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '9250',
      'cmd_id' => 'int16_t',
    ),
    'follows' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9250',
      'cmd_id' => 'int16_t',
    ),
    'saledetail' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '9250',
      'cmd_id' => 'int16_t',
    ),
    'findsList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9250',
      'cmd_id' => 'int16_t',
    ),
    'summary' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '9400',
      'cmd_id' => 'int16_t',
    ),
    'customer' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '9550',
      'cmd_id' => 'int16_t',
    ),
    'findSummary' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9400',
      'cmd_id' => 'int16_t',
    ),
    'findCustomer' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9550',
      'cmd_id' => 'int16_t',
    ),
    'autofinds' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9250',
      'cmd_id' => 'int16_t',
    ),
    'contactDebt' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '9250',
      'cmd_id' => 'int16_t',
    ),
    'contactDebtManage' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '9250',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Report_Settlement' => 
  array (
    'bank' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '10760',
      'cmd_id' => 'int16_t',
    ),
    'banks' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '10760',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Report_Warehouse' => 
  array (
    'balance' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34097',
      'cmd_id' => 'int16_t',
    ),
    'balances' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34097',
      'cmd_id' => 'int16_t',
    ),
    'detail' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34101',
      'cmd_id' => 'int16_t',
    ),
    'details' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34101',
      'cmd_id' => 'int16_t',
    ),
    'gather' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34105',
      'cmd_id' => 'int16_t',
    ),
    'gathers' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '34105',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Finance_VerificationBill' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '11510',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '11510',
      'cmd_id' => 'int16_t',
    ),
    'select' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '11510',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Base_SettlementAccountType' => 
  array (
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7010',
      'cmd_id' => 'int16_t',
    ),
    'SettlementAccountTypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7010',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '7030',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7040',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7030',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '7020',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Sale_Type' => 
  array (
    'AllTypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'index' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'manage' => 
    array (
      'typ' => 'e',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'edit' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'remove' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'add' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
    'TypeList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '0',
      'cmd_id' => 'int16_t',
    ),
  ),
  'Express_Base' => 
  array
  (
    'baseList' => 
    array (
      'typ' => 'json',
      'db' => 'master',
      'rid' => '3180',
      'cmd_id' => 'int16_t',
    ),
  ),
    'Api' =>
        array
        (
            'getIdea' =>
                array (
                    'typ' => 'json',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
            'getIdeaById' =>
                array (
                    'typ' => 'json',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
            'add' =>
                array (
                    'typ' => 'json',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
        ),
    'Service_Idea' =>
        array
        (
            'index' =>
                array (
                    'typ' => 'e',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
            'ideaList' =>
                array (
                    'typ' => 'json',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
            'manage' =>
                array (
                    'typ' => 'e',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
            'get' =>
                array (
                    'typ' => 'json',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
            'edit' =>
                array (
                    'typ' => 'json',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
            'remove' =>
                array (
                    'typ' => 'json',
                    'db' => 'master',
                    'rid' => '3180',
                    'cmd_id' => 'int16_t',
                ),
        ),
    'Purchase_Information' =>
    array
    (
        'index' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'save' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'manage' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'getList' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'list1' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'change' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
    ),
	'Intercon_Userinter' =>
    array
    (
        'userinter' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'getload' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
			'senduserinter' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
		
    ),
	'Reg_Regconfig' =>
    array
    (
        'member' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'reg_member'=>array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
    ),
	'Paycen_Payway' =>
    array
    (
        'payload' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'editPayLoad' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
		'alipay' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),	
		'tenpay' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
        ),
		'alipay_wap' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
        ),
		'wx_native' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
        ),
		'cash' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
        ),
		'cards' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
        ),
        'tenpay_wap' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
		'editPayStatus'=>
		array(
			 'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
    ),
	'Login' => array(
		'loginout'=>
		array(
			 'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
		'index'=>
		array(
			 'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
		'login'=>
		array(
			 'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
		
	),

	
	'PayWithdraw_Withdraw' => array(
		'withdraw'=>
		array(
			 'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
		'getWithdrawList'=>
		array(
			 'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
		'editWithdraw'=>
		array(
			 'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
		'edit'=>
		array(
			 'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
		'geteditw'=>
		array(
			 'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
		),
	),

  'Paycen_PayCard' =>
    array
    (
        'index' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
        'manage' =>
            array (
                'typ' => 'e',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
          'upload' =>
            array (
                'typ' => 'json',
                'db' => 'master',
                'rid' => '3180',
                'cmd_id' => 'int16_t',
            ),
    ),


);

//APPCAN,使用了网络请求 Request ，没有使用uexXmlHttpMgr, 新版本有改动，直接变为$_REQUEST
$input_data = trim(file_get_contents("php://input"));

$user_request_data = array();

if ($input_data)
{
     parse_str($input_data, $user_request_data);
}

if ($user_request_data)
{
    $_REQUEST = array_merge($user_request_data, $_REQUEST);
}

//
//if ($user_request_data)
//{
//    $_REQUEST = $_REQUEST + $user_request_data;
//}

?>

