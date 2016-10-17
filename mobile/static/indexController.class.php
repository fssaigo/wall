<?php
/********************************
 *  描述: 缺省控制器示例
 *  作者: kenny 
 *  创建: 2011-09-13
 ********************************/


/**
 * 缺省控制器类
 */
class indexController extends init
{
	
	/**
	 * 缺省首页展示Action
	 */
	public function indexAction() {

		//最新活动,[根据推荐属性筛选],栏目为活动栏目,根据更新时间降序
		$this->jingxuan = $this->db->getAll('SELECT * FROM '.$this->preFix.'works WHERE `sort` > 0 AND `state` = 1 ORDER BY `sort` ASC LIMIT 0,8');

		$this->render('templates/default/pc/'.$this->cName.'/'.$this->aName.'.php');
		
	}

	public function promptAction() {

		

		$this->render('templates/default/pc/'.$this->cName.'/'.$this->aName.'.php');

	}

	/**
	 * 报名
	 */
	public function joinAction() {

		$id = intval(gcookie("userId"));

		$workId = intval($_GET["workId"]);

		if ($workId) {
			$data = $this->db->getRow('SELECT * FROM '.$this->preFix.'works WHERE `work_id` = '.$workId.' AND `state` = 1');
			$data['ablum'] = $this->db->getAll('SELECT * FROM '.$this->preFix.'work_ablum WHERE `work_id` = '.$workId.' AND `is_enabled` = 1 ORDER BY `main` DESC, `work_ablum_id` ASC');
			$id = $data['uid'];
			$this->data = $data;
			$this->photoIds = '';
			foreach ($data['ablum'] as $record) {
				$this->photoIds .= $record['work_ablum_id'].',';
			}
		}

		if ($id) {
			$this->user = $this->db->getRow('SELECT * FROM '.$this->preFix.'user WHERE `uid` = '.$id);
		}

		$this->workId = $workId;
		
		$this->render('templates/default/pc/'.$this->cName.'/'.$this->aName.'.php');

	}

	/**
	 * 作品列表
	 */
	public function worksAction() {

		$this->pageUrl = '/?c='.$this->cName.'&a='.$this->aName;

		$random = $_GET['random'];

		$keyword = trim($_GET['keyword']);
		$companyId = intval($_GET['companyId']);

		$filter = ' 1 ';

		$this->editPms = 0;

		if ($keyword) {
			if (TM_InputValidate::isMobile($keyword)) {
				$uid = $this->db->getOne('SELECT `uid` FROM '.$this->preFix.'user WHERE `mobile` = "'.$keyword.'"');
				if ($uid) {
					$filter .= ' AND `uid` = '.$uid;
					$this->editPms = 1;
				}
			} else {
				$filter .= ' AND (`title` LIKE "%'.fsql($keyword).'%" 
							OR `company` LIKE "%'.fsql($keyword).'%" 
							OR `adviser` LIKE "%'.fsql($keyword).'%"
							OR `design` LIKE "%'.fsql($keyword).'%"
							OR `construction` LIKE "%'.fsql($keyword).'%"
							OR `design_man` LIKE "%'.fsql($keyword).'%"
							OR `construction_man` LIKE "%'.fsql($keyword).'%"
							OR `construction_man` LIKE "%'.fsql($keyword).'%"
							OR `material` LIKE "%'.fsql($keyword).'%"
							)';
			}
		} else {
			if ($companyId) {
				$filter .= ' AND `company_id` = '.$companyId;
			}
		}

		$filter .= ' AND `state` = 1';

		$num = $this->db->getOne('SELECT COUNT(*) AS `cnt` FROM '.$this->preFix.'works WHERE '.$filter);

		$offset= intval($_GET['offset']);
		$size= intval($_GET['size']);
		$size = $size ? $size : 12;
		$pageCount = ceil($num/$size);
		$page = intval($_GET['page']);
		$page = ($page > $pageCount) ? $pageCount : $page;
		$page = ($page > 0) ? $page : 1;

		if ($offset) {
			$begin = $offset;
		} else {
			$begin = ($page-1) * $size;
		}

		$this->lists = $this->db->getAll('SELECT * FROM '.$this->preFix.'works WHERE '.$filter.' ORDER BY `created_at` DESC LIMIT '.$begin.','.$size);

		$this->pageView = $this->wwwPage($this->pageUrl, $page, $pageCount, $num);

		$this->num = $num;
		$this->keyword = $keyword;

		if ($random) {
			$json = Array('status'=>0, 'msg'=>'', 'data'=> Array());
			$json['status'] = 1;
			$json['data'] = $this->lists;
			$this->json($json);
		} else {
			$this->render('templates/default/pc/'.$this->cName.'/'.$this->aName.'.php');
		}

	}

	/**
	 * 作品详细
	 */
	public function showAction() {

		$this->id = intval($_GET['id']);

		$result = $this->data = $this->db->getRow('SELECT * FROM '.$this->preFix.'works WHERE `work_id` = '.$this->id.' AND `state` = 1');


		$random = $_GET['random'];

		if ($random) {
			$json = Array('status'=>0, 'msg'=>'', 'data'=> Array());
			if ($this->data) {
				$result['design'] = empty($result['design']) ? '核实中……' : $result['design'];
				$result['design_man'] = empty($result['design_man']) ? '核实中……' : $result['design_man'];
				$result['construction'] = empty($result['construction']) ? '核实中……' : $result['construction'];
				$result['construction_man'] = empty($result['construction_man']) ? '核实中……' : $result['construction_man'];
				$result['project_man'] = empty($result['project_man']) ? '核实中……' : $result['project_man'];
				#$result['description'] = str_replace("\r\n",'<br/>&#12288;&#12288;', $result['description']);
				
				$json['status'] = 1;
				$json['data'] = $result;
				$json['ablum'] = $this->db->getAll('SELECT * FROM '.$this->preFix.'work_ablum WHERE `work_id` = '.$this->id.' AND `is_enabled` = 1 ORDER BY `work_ablum_id` ASC');
			} else {
				$json['msg'] = '数据查询失败';
			}
			$this->json($json);
		} else {
			if ($this->data) {

				#$this->seoTitle = $this->data['title'].'-'.$this->typeName.'-'.$this->MG['site_name'];
				#$this->seoKeyword = $this->data['tag'];
				#$this->seoDescription = $this->data['abstract'];

				$this->pageUrl = '/?c='.$this->cName.'&a='.$this->aName.'&id='.$this->id;
				//查询作品
				$this->ablum = $this->db->getAll('SELECT * FROM '.$this->preFix.'work_ablum WHERE `work_id` = '.$this->id.' AND `is_enabled` = 1 ORDER BY `work_ablum_id` ASC');

				//查询评论
				$filter = '`work_id` = '.$this->id.' AND `state` = 1';

				$num = $this->db->getOne('SELECT COUNT(*) AS `cnt` FROM '.$this->preFix.'work_comment WHERE '.$filter);

				$offset= intval($_GET['offset']);
				$size= intval($_GET['size']);
				$size = $size ? $size : 10;
				$pageCount = ceil($num/$size);
				$page = intval($_GET['page']);
				$page = ($page > $pageCount) ? $pageCount : $page;
				$page = ($page > 0) ? $page : 1;

				if ($offset) {
					$begin = $offset;
				} else {
					$begin = ($page-1) * $size;
				}

				$this->lists = $this->db->getAll('SELECT * FROM '.$this->preFix.'work_comment WHERE '.$filter.' ORDER BY `created_at` DESC LIMIT '.$begin.','.$size);

				$this->pageView = $this->wwwPage($this->pageUrl, $page, $pageCount, $num);

				$this->num = $num;

				$this->render('templates/default/pc/' . $this->cName . '/' . $this->aName . '.php');
				
			} else {
				$this->invalid();
			}

		}

	}

	public function commentAction() {

		$id = intval($_GET['id']);

		if (!$id) {
			$this->pjson("参数异常");
		}

		$filter = ' `work_id` = '.$id.' AND `state` = 1';

		$num = $this->db->getOne('SELECT COUNT(*) AS `cnt` FROM '.$this->preFix.'work_comment WHERE '.$filter);

		$page = intval($_GET['page']);
		$offset= intval($_GET['offset']);
		$size= intval($_GET['size']);
		$size = $size ? $size : 10;
		$pageCount = ceil($num/$size);
		$page = ($page > $pageCount) ? $pageCount : $page;
		$page = ($page > 0) ? $page : 1;

		if ($offset) {
			$begin = $offset;
		} else {
			$begin = ($page-1) * $size;
		}

		$this->lists = $this->db->getAll('SELECT * FROM '.$this->preFix.'work_comment WHERE '.$filter.' ORDER BY `created_at` DESC LIMIT '.$begin.','.$size);

		$this->pageView = $this->wwwPage($this->pageUrl, $page, $pageCount, $num);

		$this->num = $num;

		$random = $_GET['random'];

		if ($random) {
			$json = Array('status'=>0, 'msg'=>'', 'data'=> Array());
			$json['status'] = 1;
			$json['data'] = $this->lists;
			$this->json($json);
		} else {
			$this->render('templates/default/pc/'.$this->cName.'/'.$this->aName.'.php');
		}
	}

}
