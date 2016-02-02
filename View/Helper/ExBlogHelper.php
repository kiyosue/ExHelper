<?php
/**
 * ExBlogHelper
 *
 * BcBaserHelper にたりないと思う機能を追加したもの
 *
 * @package ExHelper.View.Helper
 *
 * @property BlogPost $BlogPost
 * @property BcBaser $BcBaser
 * @property ExHelper $ExHelper
 */

App::uses('BlogHelper', 'Blog.View/Helper');
App::uses('ComponentCollection', 'Controller');
App::uses('PaginatorComponent', 'Controller/Component');
App::uses('ExHelperController', 'ExHelper.Controller');
App::uses('ExHelper', 'ExHelper.Model');


class ExBlogHelper extends BlogHelper {

	var $allBlogPagination = null;

	public $helpers = array('Html', 'BcTime', 'BcBaser', 'BcUpload', 'BcBaser');

	/**
	 * コンストラクタ
	 *
	 * @param View $View ビュークラス
	 * @param array $settings ヘルパ設定値（BcBaserHelper では利用していない）
	 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}


	/**
	 * 指定ブログで公開状態の記事を取得
	 *
	 * ページ編集画面等で利用する事ができる。
	 * ビュー: lib/Baser/Plugin/Blog/View/blog/{コンテンツテンプレート名}/posts.php
	 *
	 * 《利用例》
	 * $this->BcBaser->allBlogPosts('news', 3)
	 *
	 * @param int $contentsName 管理システムで指定したコンテンツ名
	 * @param int $num 記事件数（初期値 : 5）
	 * @param array $options オプション（初期値 : array()）
	 *	- `tag` : タグで絞り込む場合にタグ名を指定（初期値 : null）
	 *	- `content` : content.id(ブログのID) で絞り込む場合に id を指定（初期値 : null）
	 *	- `post` : post.id(ブログ記事のID) で絞り込む場合に id を指定（初期値 : null）
	 *	- `category` : カテゴリで絞り込む場合にアルファベットのカテゴリ名指定（初期値 : null）
	 *	- `year` : 年で絞り込む場合に年を指定（初期値 : null）
	 *	- `month` : 月で絞り込む場合に月を指定（初期値 : null）
	 *	- `day` : 日で絞り込む場合に日を指定（初期値 : null）
	 *	- `keyword` : キーワードで絞り込む場合にキーワードを指定（初期値 : null）
	 *	- `template` : 読み込むテンプレート名を指定する場合にテンプレート名を指定（初期値 : null）
	 *	- `direction` : 並び順の方向を指定 [昇順:ASC or 降順:DESC]（初期値 : null）
	 *	- `sort` : 並び替えの基準となるフィールドを指定（初期値 : null）
	 *	- `page` : ページ数を指定（初期値 : null）
	 * @return void
	 */
	public function allBlogPosts($options = array()){

		$options = array_merge(array(
			'category' => null,
			'tag' => null,
			'year' => null,
			'month' => null,
			'day' => null,
			'content' => null,
			'post' => null,
			'keyword' => null,
			'template' => null,
			'direction' => null,
			'page' => null,
			'sort' => null
		), $options);

		$BlogPost = ClassRegistry::init('Blog.BlogPost');

		$conditions = $BlogPost->getConditionAllowPublish() ;


		if( $options['content'] !== null ){
			$conditions['BlogContent.id'] = $options['content'] ;
		}

		if( $options['post'] !== null ){
			$conditions['BlogPost.id'] = $options['post'] ;
		}

		if( $options['tag'] !== null ){
			//SELECT blog_post_id FROM mysite_pg_blog_posts_blog_tags WHERE blog_tag_id IN (1,2,3) GROUP BY blog_post_id;
			$BlogPostsBlogTag = ClassRegistry::init('ExHelper.BlogPostsBlogTag');
			$tags = $BlogPostsBlogTag->find('all',array(
					'fields' => array(
						'BlogPostsBlogTag.blog_post_id'
					),
					'conditions' => array(
						'BlogPostsBlogTag.blog_tag_id' => $options['tag'],
					),
					'group' => 'BlogPostsBlogTag.blog_post_id',
					'cache' => false //キャッシュはオフに
				)
			);
			if(is_array($tags)){
				$tagId = null;
				foreach($tags as $val){
					$tagId[] = $val['BlogPostsBlogTag']['blog_post_id'];
				}
			}
			if(! empty($conditions['BlogPost.id']) ){
				$postId = null;
				if( is_numeric($conditions['BlogPost.id'])){
					foreach($tagId as $val){
						if($val == $conditions['BlogPost.id']){
							$postId = $val;
							break ;
						}
					}
				} else if( is_array($conditions['BlogPost.id'])){
					foreach($tagId as $val){
						if(in_array($val, $conditions['BlogPost.id'])){
							$postId[] = $val;
						}
					}
				}
				$conditions['BlogPost.id'] = $postId ;
			} else {
				$conditions['BlogPost.id'] = $tagId ;
			}
		}

		//PetitCustomField に対応。。。 alter table形式のヤツがいいなやっぱり。

		$posts = $BlogPost->find('all', array(
			'fields' => array(
				'BlogPost.id',
				'BlogPost.name',
			),
			'conditions' => $conditions,
			'order' => array('BlogPost.posts_date DESC'), //公開日順にソート
			'limit' => 100, //取得記事数
			'cache' => false //キャッシュはオフに
		));

		//pagination用セッティング
		$settings =  array(
			'page' => 1,
			'limit' => 2,
			'maxLimit' => 100,
			'paramType' => 'querystring'
		);

		$ExHelperController = new ExHelperController();
//		var_dump($this->request);exit;
		$ExHelperController->request = $this->request; //pagination componentで使っているため
		$ExHelperController->request->params['controller'] = substr($this->BcBaser->getUrl(),1);
		$ExHelperController->request->params['action'] = null;

		$ComponentCollection = new ComponentCollection();
		$ComponentCollection->init($ExHelperController); //利用するControllerをセットしてあげる。
		$this->Paginator = new PaginatorComponent($ComponentCollection, $settings);

		$posts = $this->Paginator->paginate('BlogPost', $conditions);

		// 出力関数しかないので一回制御
		ob_start();
		$this->BcBaser->pagination(); // @todo 第2引数のdataの中身を解析する必要有
		$this->allBlogPagination = ob_get_contents();
		ob_end_clean();

		return $posts ;
	}

	/**
	 * 直前に実行された allBlogPosts のpaginationを出力
	 *
	 */
	public function allBlogPagination(){
		echo $this->allBlogPagination ;
	}


	/**
	 * 直前に実行された allBlogPosts のpaginationを取得
	 *
	 */
	public function getAllBlogPagination(){
		return $this->allBlogPagination ;
	}


	/**
	 * get_the_post_thumbnail wordpressの関数互換 getEyeCatch相当の物
	 *
	 */
	public function getThePostThumbnail(){

		$this->BcBaser->getEeyCatch($post, $options);
	}

	/**
	 * wordpress 互換関数、
	 * 指定した ID を持つ投稿の公開ステータスを取得します。
	 * <?php get_post_status( $ID ) ?>
	 *      （整数|WP_Post） （オプション） 投稿 ID または投稿オブジェクト。未指定（空文字）の場合は現在の投稿が対象になります。
	 * 初期値： ''（空文字）
	 *
	 * 'publish' - 公開済
	 * 'pending' - 承認待ち
	 * 'draft' - 下書き
	 * 'auto-draft' - 新規作成された投稿。まだコンテンツがない。
	 * 'future' - 予約済（未来に投稿される）
	 * 'private' - 非公開（ログインしていないユーザーから見えない）
	 * 'inherit' - リビジョン。get_children() を見てください。
	 * 'trash' - ゴミ箱にある投稿。バージョン 2.9 で追加された。
	 *
	 */
	public function get_post_status(){
		// blog postsにselectしてから状況を取得してどれかｎ文字列を返す。
	}
}
