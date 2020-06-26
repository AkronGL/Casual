<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Widget_Contents_Post_Size extends Widget_Abstract_Contents
{
    public function execute()
    {
        $this->parameter->setDefault(array('pageSize' => $this->options->postsListSize));
        $this->db->fetchAll($this->select()
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.created < ?', $this->options->time)
        ->where('table.contents.type = ?', 'post')
        ->order('LENGTH(text)', Typecho_Db::SORT_DESC)
        ->limit($this->parameter->pageSize), array($this, 'push'));
    }
}