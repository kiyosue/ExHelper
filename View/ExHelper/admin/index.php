<?php
/**
 * [ADMIN] Ajaxページ一覧
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2015, baserCMS Users Community <http://sites.google.com/site/baserusers/>
 *
 * @copyright		Copyright 2008 - 2015, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.View
 * @since			baserCMS v 2.0.0
 * @license			http://basercms.net/license/index.html
 */
?>



<!-- ListTable -->
<table cellpadding="0" cellspacing="0" class="list-table sort-table" id="ListTable">
	<thead>
	<tr>
		<th>ヘルパー名</th>
		<th>利用箇所</th>
		<th>説明</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td colspan="3">
			※同じメソッド名がコアヘルパーに存在する場合は、そちらが優先されます。
			（読み込み順位の問題）
		</td>
	</tr>
	<tr>
		<td>isBlog()</td>
		<td>全体</td>
		<td>
			<pre>
				&lt;?php $this-BcBaser->isBlog();?&gt;
			</pre>
				blogコンテンツかどうか判別します。
		</td>
	</tr>
	<tr>
		<td>allBlogPosts()</td>
		<td>全体</td>
		<td>
			<pre>
				&lt;?php $this-BcBaser->allBlogPosts($options);?&gt;
				// Blog配下で利用可能(上記はこちらの alias )
				&lt;?php $this-ExBlog->allBlogPosts($options);?&gt;
			</pre>
			様々な条件で、ブログの情報を取得します。(拡張途中・・・)<br />
			$options['tag'] タグで絞り込む場合にタグIDを指定。複数の場合は配列で指定。（初期値 : null）<br />
			$options['content'] content.id(ブログのID) で絞り込む場合に id を指定。複数の場合は配列で指定。（初期値 : null）<br />
			$options['post'] post.id(ブログ記事のID) で絞り込む場合に id を指定。複数の場合は配列で指定。（初期値 : null）<br />
			ex)
			<pre>
				&lt;?php
				    // optionsは指定しなくてもOK
				    $options = array(
				        'tag' => array(5,3,1,2),// タグのID
				        'content' => 3, // ブログのID
				        'post' => array(1,2,3,4,5,6,7,8,9,10) // ブログ記事のID
				    );
				    $contents = $this->BcBaser->allBlogPosts($options);
				    //該当の記事のデータが $contentsに配列で入っているのでゴニョゴニョする。
				?&gt;<br />
			</pre>
		</td>
	</tr>

	</tbody>
</table>

