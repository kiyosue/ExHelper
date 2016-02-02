<?php

/**
 * ExHelperモデル
 * 主にページネーション周りの実装を担当
 *
 */

/**
 * Include files
 */
App::uses('ExHelperAppModel', 'ExHelper.Model');

/**
 * ブログタグモデル
 *
 * @package Blog.Model
 */
class ExHelper extends ExHelperAppModel {

/**
 * クラス名
 *
 * @var string
 * @access public
 */
	public $name = 'ExHelper';

/**
 * ビヘイビア
 * 
 * @var array
 * @access public
 */
	public $actsAs = false;


	public $useTable = false;

//	function paginate() {
//		$extra = func_get_arg(6);
//		$limit = func_get_arg(3);
//		$page = func_get_arg(4);
//
//		$sql = $extra['extra']['type'];
//		$sql .= ' LIMIT ' . $limit;
//		if ($page > 1){
//			$sql .= ' OFFSET ' . ($limit * ($page - 1));
//		}
//
//		return $this->query($sql);
//	}
//
//	function paginateCount() {
//		$extra = func_get_arg(2);
//		return count($this->query(
//			preg_replace(
//				'/LIMIT \d+ OFFSET \d+$/u',
//				'',
//				$extra['extra']['type']
//			)
//		));
//	}


}
