<?php
include 'common.php';
include 'header.php';
include 'menu.php';

$stat = Typecho_Widget::widget('Widget_Stat');
?>
<?php Typecho_Widget::widget('Widget_Contents_Attachment_Admin')->to($attachments); ?>

<?php include 'menu_title.php'; ?>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="clearfix">
                        <?php include 'page-title.php'; ?>
                    </div>
                    <p class="text-sm mb-0">
                    </p>
                </div>
                <div class="table-responsive py-4">
                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <form method="get">
                            <div class="dt-buttons btn-group">
                                <div class="operate" style="margin-bottom: 4px;">
                                    <label><i class="sr-only"><?php _e('全选'); ?></i><input type="checkbox" class="typecho-table-select-all" /></label>
                                    <div class="btn-group btn-drop">
                                        <button class="btn dropdown-toggle btn-s" type="button" style="margin-right: 6px;"><i class="sr-only"><?php _e('操作'); ?></i><?php _e('选中项'); ?></button>
                                        <ul class="dropdown-menu">
                                            <li><a lang="<?php _e('你确认要删除这些文件吗?'); ?>" href="<?php $security->index('/action/contents-attachment-edit?do=delete'); ?>"><?php _e('删除'); ?></a></li>
                                        </ul>
                                        <button class="btn btn-s btn-warn btn-operate" href="<?php $security->index('/action/contents-attachment-edit?do=clear'); ?>" lang="<?php _e('您确认要清理未归档的文件吗?'); ?>"><?php _e('清理未归档文件'); ?></button>
                                    </div>
                                </div>
                            </div>
                            <div id="datatable-buttons_filter" class="dataTables_filter">
                                <div class="search" role="search">
                                    <?php if ('' != $request->keywords): ?>
                                        <a href="<?php $options->adminUrl('manage-medias.php'); ?>"><?php _e('&laquo; 取消筛选'); ?></a>
                                    <?php endif; ?>
                                    <input type="text" class="text-s" placeholder="<?php _e('请输入关键字'); ?>" value="<?php echo htmlspecialchars($request->keywords); ?>"<?php if ('' == $request->keywords): ?> onclick="value='';name='keywords';" <?php else: ?> name="keywords"<?php endif; ?>/>
                                    <button type="submit" class="btn btn-s"><?php _e('筛选'); ?></button>
                                </div>
                            </div>
                        </form>
                        <form method="post" name="manage_medias" class="operate-form">
                         <table class="table align-items-center table-flush table-hover typecho-list-table">
                            <thead class="thead-light">
                            <tr>
                                <th> </th>
                                <th> </th>
                                <th><?php _e('文件名'); ?></th>
                                <th><?php _e('上传者'); ?></th>
                                <th><?php _e('所属文章'); ?></th>
                                <th><?php _e('发布日期'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if($attachments->have()): ?>
                                <?php while($attachments->next()): ?>
                                    <?php $mime = Typecho_Common::mimeIconType($attachments->attachment->mime); ?>
                                    <tr id="<?php $attachments->theId(); ?>">
                                        <td><input type="checkbox" value="<?php $attachments->cid(); ?>" name="cid[]"/></td>
                                        <td><a href="<?php $options->adminUrl('manage-comments.php?cid=' . $attachments->cid); ?>" class="balloon-button size-<?php echo Typecho_Common::splitByCount($attachments->commentsNum, 1, 10, 20, 50, 100); ?>"><?php $attachments->commentsNum(); ?></a></td>
                                        <td>
                                            <i class="mime-<?php echo $mime; ?>"></i>
                                            <a href="<?php $options->adminUrl('media.php?cid=' . $attachments->cid); ?>"><?php $attachments->title(); ?></a>
                                            <a href="<?php $attachments->permalink(); ?>" title="<?php _e('浏览 %s', $attachments->title); ?>"><i class="i-exlink"></i></a>
                                        </td>
                                        <td><?php $attachments->author(); ?></td>
                                        <td>
                                            <?php if ($attachments->parentPost->cid): ?>
                                                <a href="<?php $options->adminUrl('write-' . (0 === strpos($attachments->parentPost->type, 'post') ? 'post' : 'page') . '.php?cid=' . $attachments->parentPost->cid); ?>"><?php $attachments->parentPost->title(); ?></a>
                                            <?php else: ?>
                                                <span class="description"><?php _e('未归档'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php $attachments->dateWord(); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6"><h6 class="typecho-list-table-title"><?php _e('没有任何文件'); ?></h6></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        </form>
                        <div class="row" style="border-top: 1px solid #e9ecef;padding-top: 10px;">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="datatable-basic_info" role="status" aria-live="polite">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="datatable-basic_paginate">

                                    <?php if($attachments->have()): ?>
                                        <ul class="typecho-pager">
                                            <?php $attachments->pageNav(); ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer-html.php';?>
</div>
<?php
include 'common-js.php';
include 'table-js.php';
include 'footer.php';
?>
