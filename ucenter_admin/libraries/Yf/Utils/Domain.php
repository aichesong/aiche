<?php

class Yf_Utils_Domain
{
	/**
	 * 顶级域名后缀
	 * @var array
	 */
	private $domain;

	public function __construct()
	{
		$this->domain   = array(
			'top'       => array(
				// 通用顶级域名列表(字母排序)
				'aero','arpa','asia',
				'biz',
				'cat','club','com','coop',
				'date',
				'edu',
				'firm',
				'gift','gov',
				'help',
				'info','int',
				'jobs',
				'link',
				'mil','mobi','mtn','museum',
				'name','net','news',
				'online','org',
				'part','photo','pics','post','pro',
				'rec','ren',
				'studio',
				'tel','top','trade','travel',
				'video',
				'wang','win','wtf',
				'xin','xxx','xyz',
				// 国家/地区顶级域名列表(字母排序)
				'ac','ad','ae','af','ag','ai','al','am','ao','aq','ar','as','at','au','aw','ax','az',
				'ba','bb','bd','be','bf','bg','bh','bi','bj','bm','bn','bo','br','bs','bt','bw','by','bz',
				'ca','cc','cd','cf','cg','ch','ci','ck','cl','cm','cn','co','cr','cu','cv','cw','cx','cy','cz',
				'de','dj','dk','dm','do','dz',
				'ec','ee','eg','er','es','et','eu',
				'fi','fj','fk','fm','fo','fr',
				'ga','gd','ge','gf','gg','gh','gi','gl','gm','gn','gp','gq','gr','gs','gt','gu','gw','gy',
				'hk','hm','hn','hr','ht','hu',
				'id','ie','il','im','in','io','iq','ir','is','it',
				'je','jm','jo','jp',
				'ke','kg','kh','ki','km','kn','kp','kr','kw','ky','kz',
				'la','lb','lc','li','lk','lr','ls','lt','lu','lv','ly',
				'ma','mc','md','me','mg','mh','mk','ml','mm','mn','mo','mp','mq','mr','ms','mt','mu','mv','mw','mx','my','mz',
				'na','nc','ne','nf','ng','ni','nl','no','np','nr','nu','nz',
				'om',
				'pa','pe','pf','pg','ph','pk','pl','pm','pn','pr','ps','pt','pw','py',
				'qa',
				're','ro','rs','ru','rw',
				'sa','sb','sc','sd','se','sg','sh','si','sk','sl','sm','sn','so','sr','ss','st','su','sv','sx','sy','sz',
				'tc','td','tf','tg','th','tj','tk','tl','tm','tn','to','tr','tt','tv','tw','tz',
				'ua','ug','uk','us','uy','uz',
				'va','vc','ve','vg','vi','vn','vu',
				'wf','ws',
				'ye','yt',
				'za','zm','zw',
			),
			// 二级顶级域名(主要针对cn域名)
			'double'    => array(
				'cn'    => array('com','net','org','gov'),
			),
		);
	}

	/**
	 * 返回任何url的域名
	 *
	 * @param  string $url url地址
	 * @return string      该url地址的域名
	 */
	public function getDomain($host)
	{
		// 翻转域名数组
		$domain_row = array_reverse(explode('.', $host));
		$count      = count($domain_row);

		if ($count == 1)
		{
			// eg:localhost
			return $domain_row[0];
		}
		elseif ($count == 2)
		{
			// eg:xxx.com  xxx.cn
			return $domain_row[1] . '.' . $domain_row[0];
		}
		else
		{
			if (isset($this->domain['double'][$domain_row[0]]))
			{
				if (in_array($domain_row[1], $this->domain['double'][$domain_row[0]]))
				{
					//eg:xxx.com.cn
					return $domain_row[2] . '.' . $domain_row[1] . '.' . $domain_row[0];
				}
				// eg:xxx.cn
				return $domain_row[1] . '.' . $domain_row[0];
			}
			elseif (in_array($domain_row[0], $this->domain['top']))
			{
				// eg:xxx.com
				return $domain_row[1] . '.' . $domain_row[0];
			}
			else
			{
				// eg:127.0.0.1, test.test
				return $host;
			}
		}
	}
}
