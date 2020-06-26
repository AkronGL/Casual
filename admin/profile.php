<?php
include 'common.php';
include 'header.php';
include 'menu.php';

$stat = Typecho_Widget::widget('Widget_Stat');
?>
<style>
    .profile-avatar{
        max-width: 100%;
        border-top-left-radius: calc(.375rem - 1px);
        border-top-right-radius: calc(.375rem - 1px);
    }
    .typecho-option .description{
        font-size:.81857em;
    }
    p ,label{
        font-size:.86857em;
    }

    .typecho-label {
        font-size:.86857em;
    }
    .primary{
        height: 35px;
        padding-top: 7px;
    }
</style>

<?php include 'menu_title.php'; ?>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="main col">
            <div class="body container card">
                <div class="card-header">
                    <h3 class="mb-0"> <?php include 'page-title.php'; ?></h3>
                </div>

                <div class="row typecho-page-main table-responsive py-4 tab-content card-body">
                    <div class="col-mb-12 col-tb-3" style="padding-left: 1.3rem;">
                        <p>
                            <a href="http://gravatar.com/emails/" title="<?php _e('在 Gravatar 上修改头像'); ?>"><?php echo '<img class="profile-avatar" src="' . Typecho_Common::gravatarUrl($user->mail, 220, 'X', 'mm', $request->isSecure()) . '" alt="' . $user->screenName . '" />'; ?></a></p>
                        <h2><?php $user->screenName(); ?></h2>
                        <p><?php $user->name(); ?></p>
                        <p><?php _e('目前有 <em>%s</em> 篇日志, 并有 <em>%s</em> 条关于你的评论在 <em>%s</em> 个分类中.',
                                $stat->myPublishedPostsNum, $stat->myPublishedCommentsNum, $stat->categoriesNum); ?></p>
                        <p><?php
                            if ($user->logged > 0) {
                                $logged = new Typecho_Date($user->logged);
                                _e('最后登录: %s', $logged->word());
                            }
                            ?></p>
                    </div>

                    <div class="col-mb-12 col-tb-6 col-tb-offset-1 typecho-content-panel" role="form">
                        <section>
                            <h3><?php _e('个人资料'); ?></h3>
                            <?php Typecho_Widget::widget('Widget_Users_Profile')->profileForm()->render(); ?>
                        </section>

                        <?php if($user->pass('contributor', true)): ?>
                            <br>
                            <section id="writing-option">
                                <h3><?php _e('撰写设置'); ?></h3>
                                <?php Typecho_Widget::widget('Widget_Users_Profile')->optionsForm()->render(); ?>
                            </section>
                        <?php endif; ?>

                        <br>

                        <section id="change-password">
                            <h3><?php _e('密码修改'); ?></h3>
                            <?php Typecho_Widget::widget('Widget_Users_Profile')->passwordForm()->render(); ?>
                        </section>

                        <?php Typecho_Widget::widget('Widget_Users_Profile')->personalFormList(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer-html.php';?>

</div>



<?php
//include 'copyright.php';
include 'common-js.php';
include 'form-js.php';
Typecho_Plugin::factory('admin/profile.php')->bottom();
include 'footer.php';
?>
