<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" && ($this->is('post')||$this->is('page')) && stripos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])) {
   header('HTTP/1.1 200 OK');
   ini_set("display_errors", 1);
   $this->response($this->need('comments.php'));
   
}
?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <meta name="renderer" content="webkit">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="icon" href="<?php $this->options->themeUrl('favicon.png'); ?>">
	<link rel="apple-touch-icon" href="<?php $this->options->themeUrl('favicon.png'); ?>">
    <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
    <!-- 使用url函数转换相关路径 -->
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?php $this->options->themeUrl('lightgallery/css/lightgallery.min.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php $this->options->themeUrl('style.css?'.date('YmdHi')); ?>" />
    <!--[if lt IE 9]>
    <script src="//cdnjscn.b0.upaiyun.com/libs/html5shiv/r29/html5.min.js"></script>
    <script src="//cdnjscn.b0.upaiyun.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
</head>
<body>
<!--[if lt IE 8]>
    <div class="browsehappy" role="dialog"><?php _e('当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/">升级你的浏览器</a>'); ?>.</div>
<![endif]-->
<header class="header">
	<?php if($this->is('post')): ?>
	<a class="header-post-back" href="javascript:history.go(-1);"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></a>
	<?php endif; ?>
	<h1 class="header-title anti-select"><a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a></h1>
</header>