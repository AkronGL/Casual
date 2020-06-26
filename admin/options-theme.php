<?php
include 'common.php';
include 'header.php';
include 'menu.php';
?>
<style>
    .multiline input:checked ~ .box:before, .multiline input:checked ~ label:before
    {
        margin-left: -72px;
    }
    .multiline .box:before, .multiline label:before{
        margin-left: -72px;
    }
</style>
<?php include 'menu_title.php'; ?>
<div class="container-fluid mt--6">
    <div class="row ">
        <div class="main col">
            <div class="body container card">

                <!-- Card header -->
                <div class="card-header">
                    <ul class="typecho-option-tabs fix-tabs clearfix">
                        <li><a href="<?php $options->adminUrl('themes.php'); ?>"><?php _e('可以使用的外观'); ?></a></li>
                        <?php if (!defined('__TYPECHO_THEME_WRITEABLE__') || __TYPECHO_THEME_WRITEABLE__): ?>
                            <li><a href="<?php $options->adminUrl('theme-editor.php'); ?>"><?php _e('编辑当前外观'); ?></a></li>
                        <?php endif; ?>
                        <li class="current"><a href="<?php $options->adminUrl('options-theme.php'); ?>"><?php _e('设置外观'); ?></a></li>
                    </ul>
                </div>
                <div class="row typecho-page-main" role="main">
                    <div class="col-mb-12 col-tb-8 col-tb-offset-2" role="form">
                        <?php Typecho_Widget::widget('Widget_Themes_Config')->config()->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer-html.php';?>
</div>



<?php
include 'common-js.php';
include 'form-js.php';
include 'footer.php';
?>
