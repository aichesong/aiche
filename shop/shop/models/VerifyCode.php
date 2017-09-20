<?php

/**
 * 验证码生成管理类
 *
 *
 * @category   Framework
 * @package    Zero
 * @author     Xinze <xinze@live.cn>
 * @copyright  Copyright (c) 2010, 黄新泽
 * @version    1.0
 * @todo
 */
class VerifyCode
{

	private static $_prefix = 'm|zero|';

	/**
	 * 构造函数
	 *
	 * @access    private
	 */
	public function __construct()
	{
	}

	/**
	 *
	 * 多台服务器的话,需要使用分布式存储, 或者存入数据库, 可以修改为远程调用
	 *
	 *
	 * @param string $key 随机key值, 如果手机短信,则为手机号码 , 邮件同理
	 * @var   int $code_type 数字\字母\中文
	 * @var   int $type 类型
	 * @return void
	 * @access public
	 */
	public static function getCode($key, $code_type = null)
	{
		$user_code = rand(1000, 9999);

		$cache_key = self::$_prefix . $key;

		$cache = Yf_Cache::create('verify_code');
		$cache->save($user_code, $cache_key);

		return $user_code;
	}

	/**
	 * 验证输入code是否正确, 可以修改为远程调用
	 *
	 * @param  string $key 组名称
	 * @param  mixed $user_code 当前页码
	 * @return bool 返回结果
	 * @access public
	 */
	public static function checkCode($key, $user_code = null)
	{
		$key = self::$_prefix . $key;

		$cache = Yf_Cache::create('verify_code');
		$code  = $cache->get($key);

		if ($code == $user_code)
		{
			//$flag = $cache->remove($key);
			return true;
		}
		else
		{
			return false;
		}

	}

	/**
	 * 成功后删除验证码
	 *
	 * @param  string $key 组名称
	 * @param  mixed $user_code 当前页码
	 * @return bool 返回结果
	 * @access public
	 */
	public static function removeCode($key, $user_code = null)
	{
		$key = self::$_prefix . $key;

		$cache = Yf_Cache::create('verify_code');

		return $cache->remove($key);
	}
}

?>