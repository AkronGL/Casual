
<?php
include 'common.php';
include 'header.php';
include 'menu.php';
$stat = Typecho_Widget::widget('Widget_Stat');

?>

    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">网站概要</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">控制台</a></li>
                                <li class="breadcrumb-item active" aria-current="page">概要</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Card stats -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">目前有文章</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php _e($stat->myPublishedPostsNum); ?> 篇</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                            <i class="ni ni-active-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php if($user->pass('contributor', true)): ?>
                                    <?php if($user->pass('administrator', true)): ?>
                                        <p class="mt-3 mb-0 text-sm">
                                            <a href="<?php $options->adminUrl('write-post.php'); ?>" class="text-success mr-2"><?php _e('撰写新文章'); ?></a>
                                            <a href="<?php $options->adminUrl('themes.php'); ?>" class="text-nowrap"><?php _e('更换外观'); ?></a>
                                        </p>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">并有评论</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php _e($stat->myPublishedCommentsNum); ?> 条</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                            <i class="ni  ni-like-2"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php if($user->pass('contributor', true)): ?>
                                    <?php if($user->pass('editor', true) && 'on' == $request->get('__typecho_all_comments') && $stat->spamCommentsNum > 0): ?>
                                        <p class="mt-3 mb-0 text-sm">
                                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php $stat->mySpamCommentsNum(); ?></span>
                                            <a href="<?php $options->adminUrl('manage-comments.php?status=spam'); ?>" class="text-nowrap"><?php _e('垃圾评论'); ?></a>
                                        </p>

                                    <?php elseif($stat->mySpamCommentsNum > 0): ?>
                                        <p class="mt-3 mb-0 text-sm">
                                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php $stat->mySpamCommentsNum(); ?></span>
                                            <a href="<?php $options->adminUrl('manage-comments.php?status=spam'); ?>" class="text-nowrap text-danger"><?php _e('垃圾评论'); ?></a>

                                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php $stat->myWaitingCommentsNum(); ?></span>
                                            <a href="<?php $options->adminUrl('manage-comments.php?status=waiting'); ?>" class="text-nowrap"><?php _e('待审核评论'); ?></a>
                                        </p>
                                    <?php  else :
                                        ?>


                                        <p class="mt-3 mb-0 text-sm">
                                            <span class="text-success mr-2"></span>
                                            <a href="<?php $options->adminUrl('manage-comments.php'); ?>" class="text-success"><?php _e('所有评论'); ?></a>
                                        </p>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <!-- Card body -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">所有分类</h5>
                                        <span class="h2 font-weight-bold mb-0"><?php _e($stat->categoriesNum); ?> 个</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                            <i class="ni  ni-planet"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php if($user->pass('contributor', true)): ?>
                                    <?php if($user->pass('administrator', true)): ?>
                                        <p class="mt-3 mb-0 text-sm">
                                            <a href="<?php $options->adminUrl('plugins.php'); ?>" class="text-success mr-2"><?php _e('插件管理'); ?></a>
                                            <a href="<?php $options->adminUrl('options-general.php'); ?>" class="text-nowrap "><?php _e('系统设置'); ?></a>
                                        </p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0"><?php _e('最近得到的回复'); ?></h5>
                    </div>
                    <!-- Card body -->
                    <div class="card-body p-0">
                        <!-- List group -->
                        <div class="list-group list-group-flush" >

                            <?php Typecho_Widget::widget('Widget_Comments_Recent', 'pageSize=8')->to($comments); ?>
                            <?php if($comments->have()): ?>
                                <?php while($comments->next()):

                                    ?>

                                    <a href="<?php $comments->permalink(); ?>" style="margin-bottom: -19px;" class="list-group-item list-group-item-action flex-column align-items-start py-4 px-4">
                                        <div class="d-flex w-100 justify-content-between">
                                            <div>
                                                <div class="d-flex w-100 align-items-center">
                                                    <img src="<?php echo Typecho_Common::gravatarUrl($comments->mail, 220, 'X', 'mm', $request->isSecure()) . '" alt="' . $user->screenName?>" alt="Image placeholder" class="avatar avatar-xs mr-2">
                                                    <h5 class="mb-1"><?php echo $comments->author?></h5>
                                                </div>
                                            </div>
                                            <small><?php $comments->date('n.j'); ?></small>
                                        </div>
                                        <p class="text-sm mb-0"><?php $comments->excerpt(35, '...'); ?></p>
                                    </a>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start py-4 px-4">
                                    <div class="d-flex w-100 justify-content-between">

                                    </div>
                                    <h4 class="mt-3 mb-1" style="text-align: center;"><span class="text-info">●</span> 暂无评论</h4>
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Image-Text card -->

                <!-- Members list group card -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0"><?php _e('最近发布的文章'); ?></h5>
                    </div>
                    <?php Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize=10')->to($posts); ?>

                    <!-- Card search -->
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- List group -->
                        <ul class="list-group list-group-flush list my--3">
                            <?php if($posts->have()): ?>
                                <?php while($posts->next()): ?>

                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">

                                            <div class="col ml--2">
                                                <span class="text-warning"> <?php $posts->date('n.j'); ?></span>
                                                <small> <a style="    color: #525f7f;" href="<?php $posts->permalink(); ?>"><?php $posts->title(); ?></a></small>
                                            </div>

                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center" style="text-align: center;">
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="#!">暂时没有文章</a>
                                            </h4>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0"><?php _e('官方最新日志'); ?></h5>
                    </div>
                    <?php Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize=10')->to($posts); ?>

                    <!-- Card search -->
                    <!-- Card body -->
                    <div class="card-body" id="typecho-message">
                        <!-- List group -->
                        <ul class="list-group list-group-flush list my--3" >
                            <?php  _e('读取中...'); ?>



                                <li class="list-group-item px-0">
                                    <div class="row align-items-center" style="text-align: center;">
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="#!">暂时没有文章</a>
                                            </h4>
                                        </div>
                                    </div>
                                </li>

                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <!-- Footer -->

        <?php include 'footer-html.php';?>
    </div>
<?php include 'footer.php';?>

<script>
    $(document).ready(function () {
        var ul = $('#typecho-message ul'), cache = window.sessionStorage,
//            html = cache ? cache.getItem('feed') : '',
//            update = cache ? cache.getItem('update') : '';
//        console.log(cache);
//
//        if (!!html) {
//            ul.html(html);
//        } else {
             html = '';
            $.get('<?php $options->index('/action/ajax?do=feed'); ?>', function (o) {
                for (var i = 0; i < o.length; i ++) {
                    var item = o[i];
                    html += '<li class="list-group-item px-0"> <div class="row align-items-center"> <div class="col ml--2"> <span class="text-warning"> ' + item.date + '</span> <small> <a style="    color: #525f7f;" href="' + item.link + '">' + item.title + '</a></small> </div> </div> </li>';
//                    html += '<li><span>' + item.date + '</span> <a href="' + item.link + '" target="_blank">' + item.title + '</a></li>';
                }
                ul.html(html);
                cache.setItem('feed', html);
            }, 'json');
//        }
//
//        function applyUpdate(update) {
//            if (update.available) {
//                $('<div class="update-check message error"><p>'
//                    + '<?php //_e('您当前使用的版本是 %s'); ?>//'.replace('%s', update.current) + '<br />'
//                    + '<strong><a href="' + update.link + '" target="_blank">'
//                    + '<?php //_e('官方最新版本是 %s'); ?>//'.replace('%s', update.latest) + '</a></strong></p></div>')
//                    .insertAfter('.typecho-page-title').effect('highlight');
//            }
//        }
//
//        if (!!update) {
//            applyUpdate($.parseJSON(update));
//        } else {
//            $.get('<?php //$options->index('/action/ajax?do=checkVersion'); ?>//', function (o, status, resp) {
//                applyUpdate(o);
//                cache.setItem('update', resp.responseText);
//            }, 'json');
//        }
    });

</script>

