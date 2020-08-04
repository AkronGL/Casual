<?php
include 'common.php';
include 'header.php';
include 'menu.php';
Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
?>
<div class="main">
    <div class="body container">
        <?php include 'page-title.php'; ?>
        <div class="row typecho-page-main typecho-post-area" role="form">
            <form action="<?php $security->index('/action/contents-post-edit'); ?>" method="post" name="write_post">
                <div class="col-mb-12 col-tb-9" role="main">
                    <?php if ($post->draft && $post->draft['cid'] != $post->cid): ?>
                    <?php $postModifyDate = new Typecho_Date($post->draft['modified']); ?>
                    <cite class="edit-draft-notice"><?php _e('你正在编辑的是保存于 %s 的草稿, 你也可以 <a href="%s">删除它</a>', $postModifyDate->word(), 
                    $security->getIndex('/action/contents-post-edit?do=deleteDraft&cid=' . $post->cid)); ?></cite>
                    <?php endif; ?>

                    <p class="title">
                        <label for="title" class="sr-only"><?php _e('标题'); ?></label>
                        <input type="text" id="title" name="title" autocomplete="off" value="<?php $post->title(); ?>" placeholder="<?php _e('标题'); ?>" class="w-100 text title" />
                    </p>
                    <?php $permalink = Typecho_Common::url($options->routingTable['post']['url'], $options->index);
                    list ($scheme, $permalink) = explode(':', $permalink, 2);
                    $permalink = ltrim($permalink, '/');
                    $permalink = preg_replace("/\[([_a-z0-9-]+)[^\]]*\]/i", "{\\1}", $permalink);
                    if ($post->have()) {
                        $permalink = str_replace(array(
                            '{cid}', '{category}', '{year}', '{month}', '{day}'
                        ), array(
                            $post->cid, $post->category, $post->year, $post->month, $post->day
                        ), $permalink);
                    }
                    $input = '<input type="text" id="slug" name="slug" autocomplete="off" value="' . htmlspecialchars($post->slug) . '" class="mono" />';
                    ?>
                    <p class="mono url-slug">
                        <label for="slug" class="sr-only"><?php _e('网址缩略名'); ?></label>
                        <?php echo preg_replace("/\{slug\}/i", $input, $permalink); ?>
                    </p>
                    <p>
                        <label for="text" class="sr-only"><?php _e('文章内容'); ?></label>
                        <textarea style="height: <?php $options->editorSize(); ?>px" autocomplete="off" id="text" name="text" class="w-100 mono"><?php echo htmlspecialchars($post->text); ?></textarea>
                    </p>
                    
                    <?php include 'custom-fields.php'; ?>

                    <p class="submit clearfix">
                        <span class="right">
                            <input type="hidden" name="cid" value="<?php $post->cid(); ?>" />
                            <button type="submit" name="do" value="save" id="btn-save" class="btn"><?php _e('保存草稿'); ?></button>
                            <button type="submit" name="do" value="publish" class="btn primary" id="btn-submit"><?php _e('发布文章'); ?></button>
                            <?php if ($options->markdown && (!$post->have() || $post->isMarkdown)): ?>
                            <input type="hidden" name="markdown" value="1" />
                            <?php endif; ?>
                        </span>
                    </p>

                    <?php Typecho_Plugin::factory('admin/write-post.php')->content($post); ?>
                </div>

                <div id="edit-secondary" class="col-mb-12 col-tb-3" role="complementary">
                   


                    <div id="tab-advance" class="tab-content">
                        <section class="typecho-post-option" role="application">
                            <label for="date" class="typecho-label"><?php _e('发布日期'); ?></label>
                            <p><input class="typecho-date w-100" type="text" name="date" id="date" value="<?php $post->have() ? $post->date('Y-m-d H:i') : ''; ?>" /></p>
                        </section>


                        <?php Typecho_Plugin::factory('admin/write-post.php')->option($post); ?>


                            <?php if($user->pass('editor', true)): ?>
                            <section class="typecho-post-option visibility-option">
                                <label for="visibility" class="typecho-label"><?php _e('公开度'); ?></label>
                                <p>
                                <select id="visibility" name="visibility">
                                    <?php if ($user->pass('editor', true)): ?>
                                    <option value="publish"<?php if (($post->status == 'publish' && !$post->password) || !$post->status): ?> selected<?php endif; ?>><?php _e('公开'); ?></option>
                                    <option value="hidden"<?php if ($post->status == 'hidden'): ?> selected<?php endif; ?>><?php _e('隐藏'); ?></option>
                                    <option value="password"<?php if (strlen($post->password) > 0): ?> selected<?php endif; ?>><?php _e('密码保护'); ?></option>
                                    <option value="private"<?php if ($post->status == 'private'): ?> selected<?php endif; ?>><?php _e('私密'); ?></option>
                                    <?php endif; ?>
                                    <option value="waiting"<?php if (!$user->pass('editor', true) || $post->status == 'waiting'): ?> selected<?php endif; ?>><?php _e('待审核'); ?></option>
                                </select>
                                </p>
                                <p id="post-password"<?php if (strlen($post->password) == 0): ?> class="hidden"<?php endif; ?>>
                                    <label for="protect-pwd" class="sr-only">内容密码</label>
                                    <input type="text" name="password" id="protect-pwd" class="text-s" value="<?php $post->password(); ?>" size="16" placeholder="<?php _e('内容密码'); ?>" />
                                </p>
                            </section>
                            <?php endif; ?>

                            <?php Typecho_Plugin::factory('admin/write-post.php')->advanceOption($post); ?>
                       

                        <?php if($post->have()): ?>
                        <?php $modified = new Typecho_Date($post->modified); ?>
                        <section class="typecho-post-option">
                            <p class="description">
                                <br>&mdash;<br>
                                <?php _e('本文由 <a href="%s">%s</a> 撰写',
                                Typecho_Common::url('manage-posts.php?uid=' . $post->author->uid, $options->adminUrl), $post->author->screenName); ?><br>
                                <?php _e('最后更新于 %s', $modified->word()); ?>
                            </p>
                        </section>
                        <?php endif; ?>
                    </div><!-- end #tab-advance -->

                    <div id="tab-files" class="tab-content hidden">
                        <?php include 'file-upload.php'; ?>
                    </div><!-- end #tab-files -->
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#wmd-button-row").removeClass("wmd-visualhide");
</script>
<?php
include 'copyright.php';
include 'common-js.php';
include 'form-js.php';
include 'write-js.php';

Typecho_Plugin::factory('admin/write-post.php')->trigger($plugged)->richEditor($post);
if (!$plugged) {
    include 'editor-js.php';
}

include 'file-upload-js.php';
include 'custom-fields-js.php';
Typecho_Plugin::factory('admin/write-post.php')->bottom($post);
include 'footer.php';
?>