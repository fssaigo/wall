<?php
/********************************
 *  描述: 缺省控制器示例
 *  作者: kenny 
 *  创建: 2011-09-13
 ********************************/


/**
 * 缺省控制器类
 */
class ajaxController extends init
{

	public $json = Array('status'=>0, 'msg'=>'', 'data'=>Array());

	public function __construct($config, $controllerName, $actionName) {
	
		parent::__construct ( $config, $controllerName, $actionName );
		
	}
	
	public function userAction() {
		
		$json = Array('status'=>0, 'msg'=>'', 'data'=> Array());
		
		$this->id = intval($_GET['id']);

		$this->data = $this->db->getRow('SELECT * FROM '.$this->preFix.'user WHERE `uid` = '.$this->id);


		if ($this->data) {
			$json['status'] = 1;
			$json['data'] = $this->data;
		} else {
			$json['msg'] = '数据查询失败';
		}
		
		$this->json($json);
		
	}
	
	/**
	 * 报名
	 */
	public function joinAction() {

		$json = Array('status'=>0, 'msg'=>'', 'data'=>Array());

		$arrInsert = Array();
		$arrInsert['name'] = cutstr($this->getParam("name"), 0, 15);
		$arrInsert['mobile'] = cutstr($this->getParam("mobile"), 0, 11);
		$arrInsert['company'] = cutstr($this->getParam("zzcompany"), 0, 64);
		$arrInsert['address'] = cutstr($this->getParam("address"), 0, 64);

		if (TM_InputValidate::isEmpty($arrInsert['name'])) {
			$this->pjson('姓名不能为空!');
		}
		if (!TM_InputValidate::isMobile($arrInsert['mobile'])) {
			$this->pjson('手机号码不合法!');
		}

		if (!$user = $this->db->getRow('SELECT * FROM '.$this->preFix.'user WHERE `mobile` = "'.$arrInsert['mobile'].'"')) {
			$arrInsert['created_at'] = $this->nowTime;
			if ($this->db->insert($arrInsert, $this->preFix.'user')) {
				$arrInsert['uid'] = $this->db->getLastId();
				$json['status'] = 1;
				$json['data'] = $arrInsert;
			} else {
				$json['msg'] = '用户新增失败!';
			}
		} else {
			$this->db->update($arrInsert, ' `uid` = '.$user['uid'], $this->preFix.'user');
			$json['status'] = 1;
			$json['data'] = $user;
		}

		if ($json['status']) {
			scookie("userId", $json['data']['uid'], $expire = 86400);
		}

		print json_encode($json);

	}

	/**
	 * 提交作品
	 */
	public function workAction() {

		$json = Array('status'=>0, 'msg'=>'', 'data'=>Array());
		
		$workId = intval($_POST["workId"]);
		
		$photoIds = substr($this->getParam("photoIds"), 0, -1);

		$arrInsert = Array();
		$arrInsert['uid'] = intval($this->getParam("uid"));
		$arrInsert['title'] = cutstr($this->getParam("title"), 0, 80);
		if (!$workId) {
			$arrInsert['picture'] = '';
		}
		$arrInsert['description'] = cutstr($this->getParam("description"), 0, 20000);
		$arrInsert['company'] = cutstr($this->getParam("yzcompany"), 0, 200);
		$arrInsert['adviser'] = cutstr($this->getParam("adviser"), 0, 200);
		$arrInsert['design'] = cutstr($this->getParam("design"), 0, 200);
		$arrInsert['design_man'] = cutstr($this->getParam("design_man"), 0, 60);
		$arrInsert['construction'] = cutstr($this->getParam("construction"), 0, 200);
		$arrInsert['construction_man'] = cutstr($this->getParam("construction_man"), 0, 60);
		$arrInsert['project_man'] = cutstr($this->getParam("project_man"), 0, 60);
		$arrInsert['material'] = cutstr($this->getParam("material"), 0, 200);
		if (!sqlId($photoIds)) {
			$this->pjson('请先上传作品!');
		}
		if (TM_InputValidate::isEmpty($arrInsert['uid'])) {
			$this->pjson('服务器异常!');
		}
		if (TM_InputValidate::isEmpty($arrInsert['title'])) {
			$this->pjson('标题不能为空!'.print_r($_POST,1));
		}
		if (TM_InputValidate::isEmpty($arrInsert['description'])) {
			$this->pjson('作品描述不能为空!');
		}

		if ($this->db->getOne('SELECT `uid` FROM '.$this->preFix.'user WHERE `uid` = "'.$arrInsert['uid'].'"')) {
			if ($workId) {
				$arrInsert['state'] = 0;
				$arrInsert['updated_at'] = $this->nowTime;
				$this->db->update($arrInsert, ' `work_id` = '.$workId, $this->preFix.'works');
				$this->db->execute('UPDATE '.$this->preFix.'work_ablum SET `is_enabled` = 0 WHERE `work_id` = '.$workId.' AND `work_ablum_id` NOT IN ('.$photoIds.')');
				$this->db->execute('UPDATE '.$this->preFix.'work_ablum SET `work_id` = '.$workId.' WHERE `work_ablum_id` IN ('.$photoIds.')');
				if (!$this->db->getRow('SELECT * FROM '.$this->preFix.'work_ablum WHERE `work_id` = '.$workId.' AND `main` = 1 AND `is_enabled` = 1')) {
					$ablum = $this->db->getRow('SELECT * FROM '.$this->preFix.'work_ablum WHERE `work_id` = '.$workId.' AND `is_enabled` = 1 ORDER BY `work_ablum_id` ASC LIMIT 1');
					if ($ablum) {
						$this->db->execute('UPDATE '.$this->preFix.'work_ablum SET `main` = 1 WHERE `work_ablum_id` = '.$ablum['work_ablum_id']);
						$this->db->execute('UPDATE '.$this->preFix.'works SET `picture` = "'.$ablum['src'].'" WHERE `work_id` = '.$workId);
					} else {
						$this->pjson('sql rong!');
					}
				}
				$json['status'] = 1;
			} else {
				$arrInsert['created_at'] = $this->nowTime;
				if ($this->db->insert($arrInsert, $this->preFix.'works')) {
					$workId = $this->db->getLastId();
					$this->db->execute('UPDATE '.$this->preFix.'work_ablum SET `work_id` = '.$workId.' WHERE `work_ablum_id` IN ('.$photoIds.') AND `work_id` = 0');
					$updateNum = $this->db->getAffectedRows();
					if ($updateNum > 0) {
						if (!$this->db->getRow('SELECT * FROM '.$this->preFix.'work_ablum WHERE `work_id` = '.$workId.' AND `main` = 1')) {
							$ablum = $this->db->getRow('SELECT * FROM '.$this->preFix.'work_ablum WHERE `work_id` = '.$workId.' ORDER BY `work_ablum_id` ASC LIMIT 1');
							$this->db->execute('UPDATE '.$this->preFix.'work_ablum SET `main` = 1 WHERE `work_ablum_id` = '.$ablum['work_ablum_id']);
							$this->db->execute('UPDATE '.$this->preFix.'works SET `picture` = "'.$ablum['src'].'" WHERE `work_id` = '.$workId);
						}
						$json['status'] = 1;
					} else {
						$this->db->execute('DELETE FROM '.$this->preFix.'works WHERE `work_id` = '.$workId);
						$json['msg'] = '重复的提交!';
					}
				} else {
					$json['msg'] = '作品新增失败!';
				}
			}
		} else {
			$json['msg'] = '用户查询失败!';
		}

		print json_encode($json);

	}

	/**
	 * 点赞
	 */
	public function voteAction() {
		
		$json = Array('status'=>0, 'msg'=>'', 'data'=>Array());
		
		//60秒内不能重复投票
		$frezeTime = 7200;
		
		$id = intval($_GET['id']);
		
		if ($id) {
			if ($this->db->getOne('SELECT * FROM `'.$this->preFix.'works` WHERE `work_id` = '.$id.' AND `state` = 1')) {
				$ip = $this->onlineIp;
				$voteTime = $this->db->getOne('SELECT `created_at` FROM '.$this->preFix.'works_zan WHERE `work_id` = '.$id.' AND `ip` = "'.fsql($ip).'" ORDER BY `created_at` DESC LIMIT 1');
				if ($this->nowTime - $frezeTime > $voteTime) {
					$this->db->execute('UPDATE '.$this->preFix.'works SET `zan` = `zan` + 1 WHERE `work_id` = '.$id);
					$json['status'] = 1;
					$arrInsert = Array();
					$arrInsert['work_id'] = $id;
					$arrInsert['ip'] = $this->onlineIp;
					$arrInsert['created_at'] = $this->nowTime;
					$this->db->insert($arrInsert, $this->preFix.'works_zan');
				} else {
					$json['msg'] = '您已经点过赞了，2小时之内只能点一次哦';
				}
			} else {
				$json['msg'] = '未知的点赞对象!';
			}
		} else {
			$json['msg'] = '参数异常!';
		}
		
		print json_encode($json);
		
	}

	/**
	 * 保存评论
	 */
	public function commentAction() {

		$json = Array('status'=>0, 'msg'=>'', 'data'=>Array());

		$arrInsert = Array();
		$arrInsert['work_id'] = intval($this->getParam("id"));
		$arrInsert['mobile'] = cutstr($this->getParam("mobile"), 0, 11);
		$arrInsert['content'] = cutstr($this->getParam("speak"), 0, 140);
		$arrInsert['ip'] = $this->onlineIp;
		$arrInsert['created_at'] = $this->nowTime;

		if (TM_InputValidate::isEmpty($arrInsert['work_id'])) {
			$this->pjson('未知的作品!');
		}
		if (!TM_InputValidate::isMobile($arrInsert['mobile'])) {
			$this->pjson('手机号码不能为空!');
		}
		if (TM_InputValidate::isEmpty($arrInsert['content'])) {
			$this->pjson('评价内容不能为空!');
		}

		if ($this->db->getOne('SELECT `work_id` FROM '.$this->preFix.'works WHERE `work_id` = "'.$arrInsert['work_id'].'" AND `state` = 1')) {
			if ($this->db->insert($arrInsert, $this->preFix.'work_comment')) {
				#$commentNum = $this->db->getOne('SELECT COUNT(*) FROM '.$this->preFix.'work_comment WHERE `work_id` = '.$arrInsert['work_id']);
				#$this->db->execute('UPDATE '.$this->preFix.'works SET `comment` = '.$commentNum.' WHERE `work_id` = '.$arrInsert['work_id']);
				#$updateNum = $this->db->getAffectedRows();
				#$updateNum > 0
				if (1) {
					$json['status'] = 1;
				} else {
					$json['msg'] = '评论保存失败啦!';
				}
			} else {
				$json['msg'] = '评论保存失败!';
			}
		} else {
			$json['msg'] = '作品查询失败!';
		}

		print json_encode($json);
	}

	/**
	 * 设置预览图片
	 */
	public function previewAction() {

		$json = Array('status'=>0, 'msg'=>'', 'data'=>Array());

		$id = intval($_GET['id']);

		if ($id) {
			$ablum = $this->db->getRow('SELECT * FROM '.$this->preFix.'work_ablum WHERE `work_ablum_id` = '.$id);
			if ($ablum) {
				if ($ablum['work_id']) {
					$this->db->execute('UPDATE '.$this->preFix.'work_ablum SET `main` = 1 WHERE `work_ablum_id` = '.$id);
					$this->db->execute('UPDATE '.$this->preFix.'work_ablum SET `main` = 0 WHERE `work_id` = '.$ablum['work_id'].', AND `work_ablum_id` != '.$id);
					$this->db->execute('UPDATE '.$this->preFix.'work SET `picture` = "'.$ablum['src'].'" WHERE `work_ablum_id` = '.$id);
					$json['status'] = 1;
				} else {
					$json['msg'] = '主题查询失败!';
				}
			} else {
				$json['msg'] = '作品查询失败!';
			}
		} else {
			$json['msg'] = '参数异常!';
		}

		print json_encode($json);

	}

}
