<?php

/**
 * BlogPostBlogTagモデル
 *
 */

/**
 * Include files
 */
App::uses('BlogAppModel', 'Blog.Model');

/**
 * ブログタグモデル
 *
 * @package Blog.Model
 */
class BlogPostsBlogTag extends BlogAppModel {

/**
 * クラス名
 *
 * @var string
 * @access public
 */
	public $name = 'BlogPostsBlogTag';

/**
 * ビヘイビア
 * 
 * @var array
 * @access public
 */
	public $actsAs = false;



}
