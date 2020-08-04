<?php
/**
 * 香菇编写的 Typecho 摄影/相册主题
 * 
 * @package Photograph Theme for Typecho
 * @author siitake
 * @version 20180715
 * @link http://siitake.cn
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>
<div class="content">
	<div id="masonry" class="row">
		<?php while($this->next()): ?>
		<div class="item col-xs-6 col-sm-4 col-md-3">
			<img class="item-img" src="<?php echo $this->fields->thumb != "" ? $this->fields->thumb : getPostImg($this)[0]['url']; ?>" alt="<?php $this->title() ?>" />
			<div class="item-title"><a class="item-link" href="<?php $this->permalink() ?>"><div class="item-link-text"><?php $this->title() ?></div></a><span class="item-num">[<?php echo count(getPostImg($this)); ?>P] <span class="glyphicon glyphicon-picture" aria-hidden="true"></span></span></div>
		</div>
		<?php endwhile; ?>
	</div>
	<?php $this->pageNav('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'); ?>
</div>
<!-- end #main-->

<?php //$this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
