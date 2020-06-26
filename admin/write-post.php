
<?php
include 'common.php';
include 'header.php';
include 'menu.php';
Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);
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
</style>
<?php include 'menu_title.php'; ?>


<div class="container-fluid mt--6">
    <form action="<?php $security->index('/action/contents-post-edit'); ?>" method="post" name="write_post">
        <?php if ($post->draft && $post->draft['cid'] != $post->cid): ?>
            <?php $postModifyDate = new Typecho_Date($post->draft['modified']); ?>
            <cite class="edit-draft-notice"><?php _e('你正在编辑的是保存于 %s 的草稿, 你也可以 <a href="%s">删除它</a>', $postModifyDate->word(),
                    $security->getIndex('/action/contents-post-edit?do=deleteDraft&cid=' . $post->cid)); ?></cite>
        <?php endif; ?>
        <div class="row">
        <div class="col-lg-9">
            <div class="card-wrapper">
                <!-- Form controls -->
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <?php include 'page-title.php'; ?>
<!--                        <h3 class="mb-0">撰写新文章</h3>-->
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <form action="<?php $security->index('/action/contents-post-edit'); ?>" method="post" name="write_post">
                            <?php if ($post->draft && $post->draft['cid'] != $post->cid): ?>
                                <?php $postModifyDate = new Typecho_Date($post->draft['modified']); ?>
                                <cite class="edit-draft-notice"><?php _e('你正在编辑的是保存于 %s 的草稿, 你也可以 <a href="%s">删除它</a>', $postModifyDate->word(), $security->getIndex('/action/contents-post-edit?do=deleteDraft&cid=' . $post->cid)); ?></cite>
                            <?php endif; ?>

                            <div class="form-group">
                                <label class="form-control-label" for="exampleFormControlInput1">标题</label>
                                <input type="text" id="title" name="title" autocomplete="off" value="<?php $post->title(); ?>" placeholder="<?php _e('标题'); ?>" class="w-100 text title form-control" />
                            </div>

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
                            <div class="mono url-slug form-group" style="font-size: .8rem;">
                                <label for="slug" class="sr-only form-control-label"><?php _e('网址缩略名'); ?></label>
                                <?php echo preg_replace("/\{slug\}/i", $input, $permalink); ?>
                            </div>

                            <div class="form-group">
                                <label for="text"  class="form-control-label sr-only" ><?php _e('文章内容'); ?></label>
                                <textarea style="height: <?php $options->editorSize(); ?>px" autocomplete="off" id="text" name="text" class="w-100 mono form-control"><?php echo htmlspecialchars($post->text); ?></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <?php include 'custom-fields.php'; ?>

                <p class="submit clearfix" style="float: right">
                    <span class="right">
                        <input type="hidden" name="cid" value="<?php $post->cid(); ?>" />
                        <button type="submit" name="do" value="save" id="btn-save" class="btn btn-secondary" style="height: 35px; padding-top: 6px;"><?php _e('保存草稿'); ?></button>
                        <button type="submit" name="do" value="publish" class="btn btn-primary" style="height: 35px; padding-top: 6px;" id="btn-submit"><?php _e('发布文章'); ?></button>
                        <?php if ($options->markdown && (!$post->have() || $post->isMarkdown)): ?>
                            <input type="hidden" name="markdown" value="1" />
                        <?php endif; ?>
                    </span>
                </p>
            </div>
        </div>

        <div class="col-lg-3">

            <div class="card-wrapper">
<!--                <div class="card">-->
<!--                    <div class="card-header">-->
<!--                        <h3 class="mb-0">Sizes</h3>-->
<!--                    </div>-->
<!--                    <div class="card-body">-->
<!--                        <div class="form-group">-->
<!--                            <label class="form-control-label">Small input</label>-->
<!--                            <input class="form-control form-control-sm" type="text" placeholder=".form-control-sm">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="card">
                    <!-- Card header -->
                    <div id="edit-secondary" class="" role="complementary">
                        <ul class="typecho-option-tabs clearfix card-header" >
                            <li class="active w-50"><a href="#tab-advance"><?php _e('选项'); ?></a></li>
                            <li class="w-50"><a href="#tab-files" id="tab-files-btn"><?php _e('附件'); ?></a></li>
                        </ul>


                        <div id="tab-advance" class="tab-content ">
                            <section class="typecho-post-option card-body" role="application">
                                <label for="date" class="typecho-label form-control-label"><?php _e('发布日期'); ?></label>
                                <p><input class="typecho-date w-100 form-control form-control-sm" type="text" name="date" id="date" value="<?php $post->have() ? $post->date('Y-m-d H:i') : ''; ?>" /></p>
                            </section>
								<section class="typecho-post-option">
    									<label for="order" class="typecho-label"><?php _e('置顶');?></label>
   				 						<p>
        								<select id="order" name="order" class="w-100">
            							<option value="0" <?php if ($post->order == '0' || !$post->order): ?>
                						selected<?php endif;?>><?php _e('否');?></option>
            							<option value="1" <?php if ($post->order == '1'): ?> selected<?php endif;?>>
                						<?php _e('是');?></option>
        								</select>
    									</p>
								</section>
                            <section class="typecho-post-option category-option card-body">
                                <label class="typecho-label"><?php _e('分类'); ?></label>
                                <?php Typecho_Widget::widget('Widget_Metas_Category_List')->to($category); ?>
                                <ul>
                                    <?php
                                    if ($post->have()) {
                                        $categories = Typecho_Common::arrayFlatten($post->categories, 'mid');
                                    } else {
                                        $categories = array();
                                    }
                                    ?>
                                    <?php while($category->next()): ?>
                                        <li><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->levels); ?><input type="checkbox" id="category-<?php $category->mid(); ?>" value="<?php $category->mid(); ?>" name="category[]" <?php if(in_array($category->mid, $categories)): ?>checked="true"<?php endif; ?>/>
                                            <label for="category-<?php $category->mid(); ?>"><?php $category->name(); ?></label></li>
                                    <?php endwhile; ?>
                                </ul>
                            </section>

                            <section class="typecho-post-option card-body">
                                <label for="token-input-tags" class="typecho-label"><?php _e('标签'); ?></label>
                                <p><input id="tags" name="tags" type="text" value="<?php $post->tags(',', false); ?>" class="w-100 text form-control form-control-sm" /></p>
                                <div id="exist-tags">
				<p style="background: #fff;border: 1px solid #D9D9D6;display: block;padding: 2px 4px;">
				<?php
				$stack = Typecho_Widget::widget('Widget_Metas_Tag_Cloud')->stack;
				$i = 0; 
				while (isset($stack[$i])) {
  					echo "<a id=\"mydiv$i\" style=\"cursor:pointer;padding: 0px 6px;margin: 2px 0;display: inline-block;\" onclick=\"mytag=document.getElementById('mydiv$i');mytag.style.backgroundColor='#E9E9E6';t=document.getElementById('tags').value;c=t?',':'';document.getElementById('tags').value=t+c+'",$stack[$i]['name'],"'\">",$stack[$i]['name'], "</a>";
  					$i++;
  				if (isset($stack[$i])) echo "  ";
				}
				?>
				</p>
				</div>
                            </section>

                            <?php Typecho_Plugin::factory('admin/write-post.php')->option($post); ?>

                            <button type="button" id="advance-panel-btn" style="margin: 16px;height: 40px;" class="btn btn-xs btn-warning"><?php _e('高级选项'); ?> <i class="i-caret-down"></i></button>
                            <div id="advance-panel" class="card-body">
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
                                            <input type="text" name="password" id="protect-pwd" class="text-s form-control form-control-sm" value="<?php $post->password(); ?>" size="16" placeholder="<?php _e('内容密码'); ?>" />
                                        </p>
                                    </section>

                                     

                                <?php endif; ?>

                                <section class="typecho-post-option allow-option" style="margin-top: 3px;">
                                    <label class="typecho-label"><?php _e('权限控制'); ?></label>
                                    <ul>
                                        <li><input id="allowComment" name="allowComment" type="checkbox" value="1" <?php if($post->allow('comment')): ?>checked="true"<?php endif; ?> />
                                            <label for="allowComment"><?php _e('允许评论'); ?></label></li>
                                        <li><input id="allowPing" name="allowPing" type="checkbox" value="1" <?php if($post->allow('ping')): ?>checked="true"<?php endif; ?> />
                                            <label for="allowPing"><?php _e('允许被引用'); ?></label></li>
                                        <li><input id="allowFeed" name="allowFeed" type="checkbox" value="1" <?php if($post->allow('feed')): ?>checked="true"<?php endif; ?> />
                                            <label for="allowFeed"><?php _e('允许在聚合中出现'); ?></label></li>
                                    </ul>
                                </section>

                               

                                <section class="typecho-post-option">
                                    <label for="trackback" class="typecho-label"><?php _e('引用通告'); ?></label>
                                    <p><textarea id="trackback" class="w-100 mono" name="trackback" rows="2"></textarea></p>
                                    <p class="description"><?php _e('每一行一个引用地址, 用回车隔开'); ?></p>
                                </section>

                                <?php Typecho_Plugin::factory('admin/write-post.php')->advanceOption($post); ?>
                            </div><!-- end #advance-panel -->

                            <?php if($post->have()): ?>
                                <?php $modified = new Typecho_Date($post->modified); ?>
                                <section class="typecho-post-option card-body">
                                    <p class="description" style="margin-bottom: 43px;">
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

Typecho_Plugin::factory('admin/write-post.php')->trigger($plugged)->richEditor($post);
if (!$plugged) {
    include 'editor-js.php';
}

include 'file-upload-js.php';
include 'custom-fields-js.php';
Typecho_Plugin::factory('admin/write-post.php')->bottom($post);

include 'footer.php';

?>

