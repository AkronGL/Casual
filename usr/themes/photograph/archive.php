<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="content">
	<div class="archive-title">
		<h3 class="archive-title"><?php $this->archiveTitle(array(
			'category'  =>  _t('分类 %s 下的文章'),
			'search'    =>  _t('包含关键字 %s 的文章'),
			'tag'       =>  _t('标签 %s 下的文章'),
			'author'    =>  _t('%s 发布的文章')
		), '', ''); ?></h3>
	</div>
	<?php if ($this->have()): ?>
	<div id="masonry" class="archive row">
		<?php while($this->next()): ?>
		<div class="item col-xs-6 col-sm-4 col-md-3">
			<img class="item-img" src="<?php echo $this->fields->thumb != "" ? $this->fields->thumb : getPostImg($this)[0]['url']; ?>" alt="<?php $this->title() ?>" />
			<div class="item-title"><a class="item-link" href="<?php $this->permalink() ?>"><div class="item-link-text"><?php $this->title() ?></div></a><span class="item-num">[<?php echo count(getPostImg($this)); ?>P] <span class="glyphicon glyphicon-picture" aria-hidden="true"></span></span></div>
		</div>
		<?php endwhile; ?>
	</div>
	<?php $this->pageNav('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'); ?>
	<?php else: ?>
		<div class="archive-msg">
			<h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
		</div>
	<?php endif; ?>
</div>
<!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
