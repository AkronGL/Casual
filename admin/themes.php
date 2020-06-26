<?php
include 'common.php';
include 'header.php';
include 'menu.php';
?>


<?php include 'menu_title.php'; ?>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <ul class="typecho-option-tabs fix-tabs clearfix">
                        <li class="current"><a href="<?php $options->adminUrl('themes.php'); ?>"><?php _e('可以使用的外观'); ?></a></li>
                        <?php if (!defined('__TYPECHO_THEME_WRITEABLE__') || __TYPECHO_THEME_WRITEABLE__): ?>
                            <li><a href="<?php $options->adminUrl('theme-editor.php'); ?>"><?php _e('编辑当前外观'); ?></a></li>
                        <?php endif; ?>
                        <?php if (Widget_Themes_Config::isExists()): ?>
                            <li><a href="<?php $options->adminUrl('options-theme.php'); ?>"><?php _e('设置外观'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="table-responsive py-4">
                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4">

                        <form method="get">
                            <div class="dt-buttons btn-group">
                                <div class="operate" style="margin-bottom: 4px;">
                                    <?php include 'page-title.php'; ?>
                                </div>
                            </div>
                        </form>
                        <table class="table align-items-center table-flush table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th><?php _e('截图'); ?></th>
                                <th><?php _e('详情'); ?></th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php Typecho_Widget::widget('Widget_Themes_List')->to($themes); ?>
                            <?php while($themes->next()): ?>
                                <tr id="theme-<?php $themes->name(); ?>" class="<?php if($themes->activated): ?>current<?php endif; ?>">
                                    <td valign="top" style="width: 40%;"><img src="<?php $themes->screen(); ?>" alt="<?php $themes->name(); ?>" style="max-width: 100%;max-height: 240px;margin: 1em 0;" /></td>
                                    <td valign="top">
                                        <h3><?php '' != $themes->title ? $themes->title() : $themes->name(); ?></h3>
                                        <span>
                                            <?php if($themes->author): ?><?php _e('作者'); ?>: <?php if($themes->homepage): ?><a href="<?php $themes->homepage() ?>"><?php endif; ?><?php $themes->author(); ?><?php if($themes->homepage): ?></a><?php endif; ?> &nbsp;&nbsp;<?php endif; ?>
                                            <?php if($themes->version): ?><?php _e('版本'); ?>: <?php $themes->version() ?><?php endif; ?>
                                        </span>
                                        <p><?php echo nl2br($themes->description); ?></p>
                                        <?php if($options->theme != $themes->name): ?>
                                            <p>
                                                <?php if (!defined('__TYPECHO_THEME_WRITEABLE__') || __TYPECHO_THEME_WRITEABLE__): ?>
                                                    <a class="edit btn btn-outline-primary btn-sm" href="<?php $options->adminUrl('theme-editor.php?theme=' . $themes->name); ?>" ><?php _e('编辑'); ?></a> &nbsp;
                                                <?php endif; ?>
                                                <a class="activate btn btn-outline-success btn-sm" href="<?php $security->index('/action/themes-edit?change=' . $themes->name); ?>"><?php _e('启用'); ?></a>
                                            </p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer-html.php';?>
</div>

<?php
include 'common-js.php';
include 'footer.php';
?>
