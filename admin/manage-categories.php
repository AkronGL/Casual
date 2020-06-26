<?php
include 'common.php';
include 'header.php';
include 'menu.php';

Typecho_Widget::widget('Widget_Metas_Category_Admin')->to($categories);
?>

<?php include 'menu_title.php'; ?>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <div class="clearfix">
                        <h3 style="float: left;margin-right: 16px;">管理分类</h3>
                        <a href="/admin/category.php" class="btn btn-primary btn-sm">新增</a>
<!--                        --><?php //include 'page-title.php'; ?>
                    </div>
                    <p class="text-sm mb-0">
                    </p>
                </div>
                <div class="table-responsive py-4">
                    <div id="datatable-buttons_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <form method="post" name="manage_categories" class="operate-form">

                        <div class="dt-buttons btn-group">
                                <div class="operate" style="margin-bottom: 4px;">
                                    <label><i class="sr-only"><?php _e('全选'); ?></i><input type="checkbox" class="typecho-table-select-all" /></label>
                                    <div class="btn-group btn-drop">
                                        <button class="btn dropdown-toggle btn-s" type="button"><i class="sr-only"><?php _e('操作'); ?></i><?php _e('选中项'); ?></button>
                                        <ul class="dropdown-menu">
                                            <li><a lang="<?php _e('此分类下的所有内容将被删除, 你确认要删除这些分类吗?'); ?>" href="<?php $security->index('/action/metas-category-edit?do=delete'); ?>"><?php _e('删除'); ?></a></li>
                                            <li><a lang="<?php _e('刷新分类可能需要等待较长时间, 你确认要刷新这些分类吗?'); ?>" href="<?php $security->index('/action/metas-category-edit?do=refresh'); ?>"><?php _e('刷新'); ?></a></li>
                                            <li class="multiline">
                                                <button type="button" class="btn merge btn-s" rel="<?php $security->index('/action/metas-category-edit?do=merge'); ?>"><?php _e('合并到'); ?></button>
                                                <select name="merge">
                                                    <?php $categories->parse('<option value="{mid}">{name}</option>'); ?>
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="datatable-buttons_filter" class="dataTables_filter">

                            </div>
                        <table class="table align-items-center table-flush table-hover typecho-list-table">
                            <thead class="thead-light">
                            <tr class="nodrag">
                                <th> </th>
                                <th><?php _e('名称'); ?></th>
                                <th><?php _e('子分类'); ?></th>
                                <th><?php _e('缩略名'); ?></th>
                                <th> </th>
                                <th><?php _e('文章数'); ?></th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php if($categories->have()): ?>
                                <?php while ($categories->next()): ?>
                                    <tr id="mid-<?php $categories->theId(); ?>">
                                        <td><input type="checkbox" value="<?php $categories->mid(); ?>" name="mid[]"/></td>
                                        <td><a href="<?php $options->adminUrl('category.php?mid=' . $categories->mid); ?>"><?php $categories->name(); ?></a>
                                            <a href="<?php $categories->permalink(); ?>" title="<?php _e('浏览 %s', $categories->name); ?>"><i class="i-exlink"></i></a>
                                        </td>
                                        <td>

                                            <?php if (count($categories->children) > 0): ?>
                                                <a href="<?php $options->adminUrl('manage-categories.php?parent=' . $categories->mid); ?>"><?php echo _n('一个分类', '%d个分类', count($categories->children)); ?></a>
                                            <?php else: ?>
                                                <a href="<?php $options->adminUrl('category.php?parent=' . $categories->mid); ?>"><?php echo _e('新增'); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php $categories->slug(); ?></td>
                                        <td>
                                            <?php if ($options->defaultCategory == $categories->mid): ?>
                                                <?php _e('默认'); ?>
                                            <?php else: ?>
                                                <a class="hidden-by-mouse" href="<?php $security->index('/action/metas-category-edit?do=default&mid=' . $categories->mid); ?>" title="<?php _e('设为默认'); ?>"><?php _e('默认'); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><a class="balloon-button left size-<?php echo Typecho_Common::splitByCount($categories->count, 1, 10, 20, 50, 100); ?>" href="<?php $options->adminUrl('manage-posts.php?category=' . $categories->mid); ?>"><?php $categories->count(); ?></a></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6"><h6 class="typecho-list-table-title"><?php _e('没有任何分类'); ?></h6></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer-html.php';?>
</div>
<?php
include 'common-js.php';
?>

<script type="text/javascript">
    (function () {
        $(document).ready(function () {
            var table = $('.typecho-list-table').tableDnD({
                onDrop : function () {
                    var ids = [];

                    $('input[type=checkbox]', table).each(function () {
                        ids.push($(this).val());
                    });

                    $.post('<?php $security->index('/action/metas-category-edit?do=sort'); ?>',
                        $.param({mid : ids}));

                    $('tr', table).each(function (i) {
                        if (i % 2) {
                            $(this).addClass('even');
                        } else {
                            $(this).removeClass('even');
                        }
                    });
                }
            });

            table.tableSelectable({
                checkEl     :   'input[type=checkbox]',
                rowEl       :   'tr',
                selectAllEl :   '.typecho-table-select-all',
                actionEl    :   '.dropdown-menu a'
            });

            $('.btn-drop').dropdownMenu({
                btnEl       :   '.dropdown-toggle',
                menuEl      :   '.dropdown-menu'
            });

            $('.dropdown-menu button.merge').click(function () {
                var btn = $(this);
                btn.parents('form').attr('action', btn.attr('rel')).submit();
            });

            <?php if (isset($request->mid)): ?>
            $('.typecho-mini-panel').effect('highlight', '#AACB36');
            <?php endif; ?>
        });
    })();
</script>
<?php include 'footer.php'; ?>


