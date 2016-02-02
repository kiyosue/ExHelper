<?php
/**
 * [ADMIN] ダッシュボードメニュー
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2015, baserCMS Users Community <http://sites.google.com/site/baserusers/>
 *
 * @copyright		Copyright 2008 - 2015, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @package			Baser.View
 * @since			baserCMS v 0.1.0
 * @license			http://basercms.net/license/index.html
 */
?>


<tr>
	<th>管理メニュー</th>
	<td>
		<ul class="cleafix">
			<li>
				<?php $this->bcBaser->link('マニュアル表示', array('controller' => 'ex_helper', 'action' => 'index')) ?>
			</li>
		</ul>
	</td>
</tr>