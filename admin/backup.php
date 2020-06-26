<?php
include 'common.php';
include 'header.php';
include 'menu.php';

$actionUrl = $security->getTokenUrl(
    Typecho_Router::url('do', array('action' => 'backup', 'widget' => 'Backup'),
        Typecho_Common::url('index.php', $options->rootUrl)));

$backupFiles = Typecho_Widget::widget('Widget_Backup')->listFiles();
?>
<?php include 'menu_title.php'; ?>

<div class="container-fluid mt--6">
    <div class="row">

        <div class="col-lg-8 card-wrapper">
            <!-- Paragraphs -->
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">备份数据</h3>
                </div>
                <form action="<?php echo $actionUrl; ?>" method="post">
                    <div class="card-body">
                    <div class="row py-2 align-items-center">
                        <div class="col-sm-2">
                            <small class="text-uppercase font-weight-bold">备份您的数据</small>
                        </div>
                        <div class="col-sm-9">
                            <p class="mb-0">此备份操作仅包含内容数据, 并不会涉及任何设置信息</p>
                        </div>
                    </div>
                    <div class="row py-2 align-items-center">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-9">
                            <p class=" mb-0">如果您的数据量过大, 为了避免操作超时, 建议您直接使用数据库提供的备份工具备份数据</p>
                        </div>
                    </div>

                    <div class="row py-2 align-items-center">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-9">
                            <p class="text-warning mb-0">为了缩小备份文件体积, 建议您在备份前删除不必要的数据</p>
                        </div>
                    </div>
                    <p><button class="btn primary" type="submit"><?php _e('开始备份 &raquo;'); ?></button></p>
                    <input tabindex="1" type="hidden" name="do" value="export">
                </div>
                </form>
            </div>
        </div>

        <div class="main col">
            <div class="body container card">
                <div class="card-header" >
                    <h3 class="mb-0"><?php _e('恢复数据'); ?></h3>
                </div>
                <div class="row typecho-page-main card-body" role="main">
                    <div id="backup-secondary" class="col-mb-12 col-tb-12 " style="margin-top: -13px;" role="form">
                        <ul class="typecho-option-tabs clearfix">
                            <li class="active w-50"><a href="#from-upload">上传</a></li>
                            <li class="w-50"><a href="#from-server">从服务器</a></li>
                        </ul>
                        <form action="<?php echo $actionUrl; ?>" id="from-upload" class="tab-content" method="post" enctype="multipart/form-data">
                            <ul class="typecho-option">
                                <li>
                                    <input tabindex="2" style="font-size: 8px;" id="backup-upload-file" name="file" type="file" class="file">
                                </li>
                            </ul>
                            <ul class="typecho-option typecho-option-submit">
                                <li>
                                    <button tabindex="3" type="submit" class="btn primary"><?php _e('上传并恢复 &raquo;'); ?></button>
                                    <input type="hidden" name="do" value="import">
                                </li>
                            </ul>
                        </form>

                        <form action="<?php echo $actionUrl; ?>" id="from-server" class="tab-content hidden" method="post">
                            <ul class="typecho-option">
                                <li>
                                    <?php if (empty($backupFiles)): ?>
                                        <p class="description" style="font-size: .789rem"><?php _e('将备份文件手动上传至服务器的 %s 目录下后, 这里会出现文件选项', __TYPECHO_BACKUP_DIR__); ?></p>
                                    <?php else: ?>
                                        <label class="typecho-label" for="backup-select-file"><?php _e('选择一个备份文件恢复数据'); ?></label>
                                        <select name="file" id="backup-select-file">
                                            <?php foreach ($backupFiles as $file): ?>
                                                <option value="<?php echo $file; ?>"><?php echo $file; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </li>
                            </ul>
                            <ul class="typecho-option typecho-option-submit">
                                <li>
                                    <button tabindex="5" type="submit" class="btn primary"><?php _e('选择并恢复 &raquo;'); ?></button>
                                    <input type="hidden" name="do" value="import">
                                </li>
                            </ul>
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
<?php include 'footer.php'; ?>

<script>
    $('#backup-secondary .typecho-option-tabs li').click(function() {
        $('#backup-secondary .typecho-option-tabs li').removeClass('active');
        $(this).addClass('active');
        $(this).parents('#backup-secondary').find('.tab-content').addClass('hidden');

        var selected_tab = $(this).find('a').attr('href');
        $(selected_tab).removeClass('hidden');

        return false;
    });

    $('#backup-secondary form').submit(function (e) {
        if (!confirm('<?php _e('恢复操作将清除所有现有数据, 是否继续?'); ?>')) {
            return false;
        }
    });
</script>
