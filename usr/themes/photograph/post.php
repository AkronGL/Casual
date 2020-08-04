<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>

<div class="content">
	<div id="masonry" class="post row">
<?php
	$imgs = getPostImg($this);
	$titleflag = 1;
/*	if($this->fields->src == 0) {
		$imgs = getPostAttImg($this);
	}elseif($this->fields->src == 1) {
		$imgs = getPostHtmImg($this);
	}elseif($this->fields->src == 2) {
		$imgs = array_merge(getPostHtmImg($this), getPostAttImg($this));
	}*/
	foreach($imgs as $img) {
		echo '<div class="post-item col-xs-6 col-sm-4 col-md-3" data-src="'.$img['url'].'"><img src="'.$img['url'].'" title="'.($this->fields->title == 1 ? $img['name'] : ($this->title.' ['.$titleflag++.']')).'" class="post-item-img"></div>';
	}
?>
	</div>

</div>

<!--a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title() ?></a-->

<!-- end #main-->

<?php //$this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>