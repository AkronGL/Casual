<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>


<article class="post" itemscope itemtype="http://schema.org/BlogPosting">
    <h1 class="post-title" itemprop="name headline"><?php $this->title() ?></h1>
    <div class="post-content" itemprop="articleBody">
        <?php $this->content(); ?>
    </div>
</article>
    <?php if ($this->is('page')) : $this->need('comments.php'); endif; ?>
<!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
