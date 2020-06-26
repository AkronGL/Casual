<?php
include 'common.php';
include 'header.php';
include 'menu.php';
?>
<?php include 'menu_title.php'; ?>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="main col">
            <div class="body container card">
                <div class="card-header">
                    <h3 class="mb-0"> <div class="typecho-page-title">
                            <?php include 'page-title.php'; ?>
                        </div>
                    </h3>
                </div>
                <div class="row typecho-page-main" role="form">
                    <div class="col-mb-12 col-tb-8 col-tb-offset-2">
                        <?php Typecho_Widget::widget('Widget_Options_Reading')->form()->render(); ?>
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
?>
<script>
$('#frontPage-recent,#frontPage-page,#frontPage-file').change(function () {
    var t = $(this);
    if (t.prop('checked')) {
        if ('frontPage-recent' == t.attr('id')) {
            $('.front-archive').addClass('hidden');
        } else {
            $('.front-archive').insertAfter(t.parent()).removeClass('hidden');
        }
    }
});
</script>
<?php
include 'footer.php';
?>
