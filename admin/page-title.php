<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<div class="typecho-page-title">
    <h3><?php echo $menu->title; ?><?php
    if (!empty($menu->addLink)) {
        echo "<a href=\"{$menu->addLink}\">" . _t("新增") . "</a>";
    }
    ?></h3>
</div>
