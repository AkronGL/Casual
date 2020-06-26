<?php if(!defined('__TYPECHO_ADMIN__')) exit;
include 'functions.php';
$stat = Typecho_Widget::widget('Widget_Stat');
?>



<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">

    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
                <img src="./img/simple.png" class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">

                  
                    <?php   $arr = get_menu('active','show',$menu); ?>

                    <li class="nav-item">
                        <a class="nav-link"  href="/admin/write-post.php">
                            <i class=" ni ni-align-left-2 text-d texlt"></i>
                            <span class="nav-link-text">撰写新文章</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/manage-comments.php?status=spam">
                            <i class="ni ni-map-big text-primary"></i>
                            <span class="nav-link-text">垃圾评论</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php $options->adminUrl('themes.php'); ?>">
                            <i class="ni ni-archive-2 text-green"></i>
                            <span class="nav-link-text"><?php _e('更换外观'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php $options->adminUrl('plugins.php'); ?>">
                            <i class="ni ni-chart-pie-35 text-info"></i>
                            <span class="nav-link-text"><?php _e('插件管理'); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php $options->adminUrl('options-general.php'); ?>">
                            <i class="ni ni-calendar-grid-58 text-red"></i>
                            <span class="nav-link-text"><?php _e('系统设置'); ?></span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>


<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Search form -->
                <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                    <div class="form-group mb-0">
                        <div class="input-group input-group-alternative input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" placeholder="Search" type="text">
                        </div>
                    </div>
                    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </form>
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center ml-md-auto">
                    <li class="nav-item d-xl-none">
                        <!-- Sidenav toggler -->
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item d-sm-none">
                        <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                            <i class="ni ni-zoom-split-in"></i>
                        </a>
                    </li>

                </ul>
                <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                          <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="<?php echo Typecho_Common::gravatarUrl($user->mail, 220, 'X', 'mm', $request->isSecure()) ?>">
                          </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold" title="<?php
                                if ($user->logged > 0) {
                                    $logged = new Typecho_Date($user->logged);
                                    _e('最后登录: %s', $logged->word());
                                }
                                ?>"><?php $user->screenName(); ?></span>
                            </div>
                            </div>
                        </a>
                    </li>
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <li class="nav-item dropdown">
                        <a href="<?php $options->logoutUrl(); ?>" class="btn btn-danger btn-sm">登出</a>
                        <a href="<?php $options->siteUrl(); ?>" class="btn btn-secondary btn-sm ">网站</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

