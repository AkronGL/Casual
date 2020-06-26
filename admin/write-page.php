
<?php
include 'common.php';
include 'header.php';
include 'menu.php';
Typecho_Widget::widget('Widget_Contents_Page_Edit')->to($page);
?>

<style>
    .description{
        margin-bottom: -3px;
    }
    #custom-field td label{
        font-size: .88em;
        font-weight: normal;
    }
    .typecho-post-option{
        margin-bottom: -28px;
        padding: 9px;
        font-size: .84rem;
    }
    #advance-panel{
        font-size: .85rem;
    }
    #visibility{
        margin-bottom: 9px;
        font-size: .89rem;
    }
    .primary{
        height: 35px;
        padding-top: 7px;
    }
    .btn-s{
        height: 35px;
        padding-top: 7px;
    }
    .upload-area{
        font-size: .81rem;
    }
    #file-list{
        font-size: .81rem;
    }
    .input_with div{
        width: 20%;
    }
</style>
<?php include 'menu_title.php'; ?>


<div class="container-fluid mt--6">
    <form action="<?php $security->index('/action/contents-page-edit'); ?>" method="post" name="write_page">
        <?php if ($page->draft && $page->draft['cid'] != $page->cid): ?>
            <?php $pageModifyDate = new Typecho_Date($page->draft['modified']); ?>
            <cite class="edit-draft-notice"><?php _e('当前正在编辑的是保存于%s的草稿, 你可以<a href="%s">删除它</a>', $pageModifyDate->word(),
                    $security->getIndex('/action/contents-page-edit?do=deleteDraft&cid=' . $page->cid)); ?></cite>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-9">
                <div class="card-wrapper">
                    <!-- Form controls -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <?php include 'page-title.php'; ?>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <form action="<?php $security->index('/action/contents-post-edit'); ?>" method="post" name="write_post">
                                <?php if ($page->draft && $page->draft['cid'] != $page->cid): ?>
                                    <?php $postModifyDate = new Typecho_Date($page->draft['modified']); ?>
                                    <cite class="edit-draft-notice"><?php _e('你正在编辑的是保存于 %s 的草稿, 你也可以 <a href="%s">删除它</a>', $postModifyDate->word(), $security->getIndex('/action/contents-post-edit?do=deleteDraft&cid=' . $page->cid)); ?></cite>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1"><?php _e('标题'); ?></label>
                                    <input type="text" id="title" name="title" autocomplete="off" value="<?php $page->title(); ?>" placeholder="<?php _e('标题'); ?>" class="w-100 text title form-control" />
                                </div>

                                <?php $permalink = Typecho_Common::url($options->routingTable['page']['url'], $options->index);
                                list ($scheme, $permalink) = explode(':', $permalink, 2);
                                $permalink = ltrim($permalink, '/');
                                $permalink = preg_replace("/\[([_a-z0-9-]+)[^\]]*\]/i", "{\\1}", $permalink);
                                if ($page->have()) {
                                    $permalink = str_replace('{cid}', $page->cid, $permalink);
                                }
                                $input = '<input type="text" id="slug" style="height: 26px;width: 48px;background: #FFFBCC; margin-top: -8px;" name="slug" autocomplete="off" value="' . htmlspecialchars($page->slug) . '" class="mono" />';
                                ?>
                                <div class="mono url-slug form-group input_with" style="font-size: .8rem;">
                                    <label for="slug" class="sr-only form-control-label"><?php _e('网址缩略名'); ?></label>

                                    <?php echo preg_replace("/\{slug\}/i", $input, $permalink); ?>
                                </div>

                                <div class="form-group">
                                    <label for="text"  class="form-control-label sr-only" ><?php _e('文章内容'); ?></label>
                                    <textarea style="height: <?php $options->editorSize(); ?>px" autocomplete="off" id="text" name="text" class="w-100 mono form-control"><?php echo htmlspecialchars($page->text); ?></textarea>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php include 'custom-fields.php'; ?>

                    <p class="submit clearfix" style="float: right">
                        <span class="right">
                            <input type="hidden" name="cid" value="<?php $page->cid(); ?>" />
                            <button type="submit" name="do" value="save" id="btn-save" class="btn btn-s btn-secondary"><?php _e('保存草稿'); ?></button>
                            <button type="submit" name="do" value="publish" class="btn primary  btn-s btn-primary" id="btn-submit"><?php _e('发布页面'); ?></button>
                            <?php if ($options->markdown && (!$page->have() || $page->isMarkdown)): ?>
                                <input type="hidden" name="markdown" value="1" />
                            <?php endif; ?>
                        </span>
                    </p>
                    <?php Typecho_Plugin::factory('admin/write-page.php')->content($page); ?>

                </div>
            </div>

            <div class="col-lg-3">

                <div class="card-wrapper">
                    <div class="card">
                        <!-- Card header -->
                        <div id="edit-secondary" class="" role="complementary">
                            <ul class="typecho-option-tabs clearfix card-header" >
                                <li class="active w-50"><a href="#tab-advance"><?php _e('选项'); ?></a></li>
                                <li class="w-50"><a href="#tab-files" id="tab-files-btn"><?php _e('附件'); ?></a></li>
                            </ul>
<!--                            card-body-->
                            <div id="tab-advance" class="tab-content ">
                                <section  class="typecho-post-option" role="application">
                                    <label for="date" class="typecho-label form-control-label"><?php _e('发布日期'); ?></label>
                                    <p><input class="typecho-date w-100 form-control form-control-sm" type="text" name="date" id="date" value="<?php $page->have() ? $page->date('Y-m-d H:i') : ''; ?>" /></p>
                                </section>


                                <section class="typecho-post-option">
                                    <label for="order" class="typecho-label form-control-label"><?php _e('页面顺序'); ?></label>
                                    <p><input type="text" id="order" name="order" value="<?php $page->order(); ?>" class="w-100" /></p>
                                    <p class="description" style="margin-bottom: 17px;"><?php _e('为你的自定义页面设定一个序列值以后, 能够使得它们按此值从小到大排列'); ?></p>
                                </section>

                                <section  class="typecho-post-option">
                                    <label for="template" class="typecho-label form-control-label"><?php _e('自定义模板'); ?></label>
                                    <p>
                                        <select name="template" id="template">
                                            <option value=""><?php _e('不选择'); ?></option>
                                            <?php $templates = $page->getTemplates(); foreach ($templates as $template => $name): ?>
                                                <option value="<?php echo $template; ?>"<?php if($template == $page->template): ?> selected="true"<?php endif; ?>><?php echo $name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </p>
                                    <p class="description" style="margin-bottom: 17px;"><?php _e('如果你为此页面选择了一个自定义模板, 系统将按照你选择的模板文件展现它'); ?></p>
                                </section>


                                <?php Typecho_Plugin::factory('admin/write-page.php')->option($page); ?>
                                <button type="button" id="advance-panel-btn" style="margin: 16px;height: 40px;"  class="btn btn-xs btn-warning"><?php _e('高级选项'); ?> <i class="i-caret-down"></i></button>
                                <div id="advance-panel">
                                    <section class="typecho-post-option visibility-option">
                                        <label for="visibility" class="typecho-label"><?php _e('公开度'); ?></label>
                                        <p>
                                            <select id="visibility" name="visibility">
                                                <option value="publish"<?php if ($page->status == 'publish' || !$page->status): ?> selected<?php endif; ?>><?php _e('公开'); ?></option>
                                                <option value="hidden"<?php if ($page->status == 'hidden'): ?> selected<?php endif; ?>><?php _e('隐藏'); ?></option>
                                            </select>
                                        </p>
                                    </section>

                                    <section class="typecho-post-option allow-option">
                                        <label class="typecho-label"><?php _e('权限控制'); ?></label>
                                        <ul>
                                            <li><input id="allowComment" name="allowComment" type="checkbox" value="1" <?php if($page->allow('comment')): ?>checked="true"<?php endif; ?> />
                                                <label for="allowComment"><?php _e('允许评论'); ?></label></li>
                                            <li><input id="allowPing" name="allowPing" type="checkbox" value="1" <?php if($page->allow('ping')): ?>checked="true"<?php endif; ?> />
                                                <label for="allowPing"><?php _e('允许被引用'); ?></label></li>
                                            <li><input id="allowFeed" name="allowFeed" type="checkbox" value="1" <?php if($page->allow('feed')): ?>checked="true"<?php endif; ?> />
                                                <label for="allowFeed"><?php _e('允许在聚合中出现'); ?></label></li>
                                        </ul>
                                    </section>

                                    <?php Typecho_Plugin::factory('admin/write-page.php')->advanceOption($page); ?>
                                </div>
                                <?php if($page->have()): ?>
                                    <?php $modified = new Typecho_Date($page->modified); ?>
                                    <section class="typecho-post-option">
                                        <p class="description">
                                            <br>&mdash;<br>
                                            <?php _e('本页面由 <a href="%s">%s</a> 创建',
                                                Typecho_Common::url('manage-pages.php?uid=' . $page->author->uid, $options->adminUrl), $page->author->screenName); ?><br>
                                            <?php _e('最后更新于 %s', $modified->word()); ?>
                                        </p>
                                    </section>
                                <?php endif; ?>
                            </div><!-- end #tab-advance -->

                            <div id="tab-files" class="tab-content hidden">
                                <?php include 'file-upload.php'; ?>
                            </div><!-- end #tab-files -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Footer -->
    <?php include 'footer-html.php';?>

</div>




<?php
include 'common-js.php';
include 'form-js.php';
include 'write-js.php';

Typecho_Plugin::factory('admin/write-page.php')->trigger($plugged)->richEditor($page);
if (!$plugged) {
    include 'editor-js.php';
}

include 'file-upload-js.php';
include 'custom-fields-js.php';
Typecho_Plugin::factory('admin/write-page.php')->bottom($page);
include 'footer.php';
?>

