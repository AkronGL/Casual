<?php if(!defined('__TYPECHO_ADMIN__')) exit; ?>
<?php
$fields = isset($post) ? $post->getFieldItems() : $page->getFieldItems();
$defaultFields = isset($post) ? $post->getDefaultFieldItems() : $page->getDefaultFieldItems();
?>
                    