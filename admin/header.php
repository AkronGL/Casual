<?php
if (!defined('__TYPECHO_ADMIN__')) {
    exit;
}

$header = '<link rel="stylesheet" href="' . Typecho_Common::url('normalize.css?v=' . $suffixVersion, $options->adminStaticUrl('css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('grid.css?v=' . $suffixVersion, $options->adminStaticUrl('css')) . '">
<link rel="stylesheet" href="' . Typecho_Common::url('style.css?v=' . $suffixVersion, $options->adminStaticUrl('css')) . '">
<!--[if lt IE 9]>
<script src="' . Typecho_Common::url('html5shiv.js?v=' . $suffixVersion, $options->adminStaticUrl('js')) . '"></script>
<script src="' . Typecho_Common::url('respond.js?v=' . $suffixVersion, $options->adminStaticUrl('js')) . '"></script>
<![endif]-->';

/** 注册一个初始化插件 */
$header = Typecho_Plugin::factory('admin/header.php')->header($header);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="<?php $options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php _e('%s - %s - Powered by Typecho', $menu->title, $options->title); ?></title>
    <meta name="robots" content="noindex, nofollow">
    <?php echo $header; ?>
    <!-- Argon CSS -->
    <script src="./simple/js/jquery.min.js"></script>
    <!-- Favicon -->
        <link rel="stylesheet" href="./simple/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="./simple/css/all.min.css" type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="./simple/css/fullcalendar.min.css">
    <link rel="stylesheet" href="./simple/css/sweetalert2.min.css">
    <link rel="stylesheet" href="./simple/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./simple/css/argon.min.css?v=1.0.0" type="text/css">
    <link rel="stylesheet" href="./simple/css/admin-css.css" type="text/css">

</head>
<body>