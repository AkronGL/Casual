<?php
include 'common.php';
if ($user->hasLogin()) {
    $response->redirect($options->adminUrl);
}
$rememberName = htmlspecialchars(Typecho_Cookie::get('__typecho_remember_name'));
Typecho_Cookie::delete('__typecho_remember_name');

$bodyClass ='body-100';

include 'header.php';
?>
<style type="text/css">

body {
text-align: center;
     /*替换背景*/
    background-image: url(https://cdn.jsdelivr.net/gh/Catalpablog/handsome/img/XBG.webp); 
    background-position: center;
}
</style>
<!--手机不加载canvas-->
<script>
if (screen && screen.width >768 ) {
document.write('<script   src="https://cdn.jsdelivr.net/gh/Catalpablog/handsome/js/canvas-nest.min.js" type="text/javascript"><\/script>');
}
</script>
<!--canvas结束-->
<div style="display: table;margin: 0 auto;height: 100%;">
    <div style="display: block;padding: 30px 15px;border-radius: 15px;margin-top: 20vh;box-shadow: 0 0 10px #00000040;width: 350px;">
        <!--登录界面头像-->
        <img style="border-radius:50px;width: 110px;" src="https://q2.qlogo.cn/headimg_dl?dst_uin=1034630181&spec=100">
        <form action="<?php $options->loginAction(); ?>" method="post" name="login" role="form"><br>
            <p>
                <label for="name" class="sr-only"><?php _e('用户名'); ?></label>
                <input type="text" id="name" name="name" value="<?php echo $rememberName; ?>" placeholder="<?php _e('用户名'); ?>" class="text-l w-100" autofocus />
            </p>
            <p>
                <label for="password" class="sr-only"><?php _e('密码'); ?></label>
                <input type="password" id="password" name="password" class="text-l w-100" placeholder="<?php _e('密码'); ?>" />
            </p>
            <p class="submit">
                <button type="submit" style="display: inline-block;background-color: #008eff;border: none;color: #ffffff;font-size: 25px;padding: 5px;width: 110px;border-radius: 10px;"><?php _e('登录'); ?></button>
                <input type="hidden" name="referer" value="<?php echo htmlspecialchars($request->get('referer')); ?>" />
            </p>
              <div class="custom-control custom-control-alternative custom-checkbox">
                 <input class="custom-control-input checkbox" name="remember" id=" customCheckLogin" type="checkbox" value="1">
                   <label class="custom-control-label" for=" customCheckLogin">
                       <span class="text-muted"><?php _e('下次自动登录'); ?></span>
                          </label>
                            </div>
        </form>
        <p class="more-link" style="margin-top: 10px;">
            <a href="<?php $options->siteUrl(); ?>"><?php _e('返回首页'); ?></a>
            <?php if($options->allowRegister): ?>
            &bull;
            <a href="<?php $options->registerUrl(); ?>"><?php _e('用户注册'); ?></a>
            <?php endif; ?>
        </p>
    </div>
</div>
<?php 
include 'common-js.php';
?>
<script>
$(document).ready(function () {
    $('#name').focus();
});
</script>
<?php
include 'footer.php';
?>
