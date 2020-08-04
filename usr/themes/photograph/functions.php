<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeConfig($form) {
	$notice = new Typecho_Widget_Helper_Form_Element_Textarea('notice', NULL, NULL, _t('网站公告'), _t('填写网站公告，留空则不显示。'));
	$form->addInput($notice);
	$statistics = new Typecho_Widget_Helper_Form_Element_Textarea('statistics', NULL, NULL, _t('统计代码'), _t('填写统计平台生成的统计代码，该内容在页面隐藏生效，留空则不生效。'));
	$form->addInput($statistics);
}

//文章缩略图 (废弃)
function showThumb($obj, $link = false) {
    preg_match_all( "/<[img|IMG].*?src=[\'|\"](.*?)[\'|\"].*?[\/]?>/", $obj->content, $matches);
    $thumb = '';
    $options = Typecho_Widget::widget('Widget_Options');
    $attach = $obj->attachments(1)->attachment; 
    if (isset($attach->isImage) && $attach->isImage == 1) {
        $thumb = $attach->url;   //附件是图片 输出附件
    } elseif (isset($matches[1][0])) {
        $thumb = $matches[1][0];  //文章内容中抓到了图片 输出链接
    }
	//空的话输出默认随机图
	$thumb = empty($thumb) ? $options->themeUrl .'/img/' . rand(1, 14) . '.jpg' : $thumb;	
    if($link) {
        return $thumb;
    }
	else {
		$thumb='<img src="'.$thumb.'">';
		return $thumb;
	}
}

//获取附件图片v1 (废弃)
function getAttachImg($cid) {
	$db = Typecho_Db::get();
	$rs = $db->fetchAll($db->select('table.contents.text')
			->from('table.contents')
			->where('table.contents.parent=?', $cid)
			->order('table.contents.cid', Typecho_Db::SORT_ASC));
	$attachPath = array();
	foreach($rs as $attach) {
		$attach = unserialize($attach['text']);
		if($attach['mime'] == 'image/jpeg') {
			$attachPath[] = array($attach['name'], $attach['path']);
		}
    }
	return $attachPath;
}

//获取文章附件图
function getPostImg($obj) {
	$imgs = array();
	if($obj->fields->src == 0) {
		$imgs = getPostAttImg($obj);
	}elseif($obj->fields->src == 1) {
		$imgs = getPostHtmImg($obj);
	}elseif($obj->fields->src == 2) {
		$imgs = array_merge(getPostHtmImg($obj), getPostAttImg($obj));
	}
	return $imgs;
}

//获取文章内容图
function getPostImg($obj) {
	$imgs = array();
	if($obj->fields->src == 0) {
		$imgs = getPostAttImg($obj);
	}elseif($obj->fields->src == 1) {
		$imgs = getPostHtmImg($obj);
	}elseif($obj->fields->src == 2) {
		$imgs = array_merge(getPostHtmImg($obj), getPostAttImg($obj));
	}
	return $imgs;
}

//获取文章图片 整合 getPostAttImg() 与 getPostHtmImg()
function getPostImg($obj) {
	$imgs = array();
	if($obj->fields->src == 0) {
		$imgs = getPostAttImg($obj);
	}elseif($obj->fields->src == 1) {
		$imgs = getPostHtmImg($obj);
	}elseif($obj->fields->src == 2) {
		$imgs = array_merge(getPostHtmImg($obj), getPostAttImg($obj));
	}
	return $imgs;
}

//后期软件
function afterSoftware() {
	return array(
		_t('未知'),
		_t('Photoshop'),
		_t('Google Picasa'),
		_t('Snapseed'),
		_t('泼辣修图'),
		_t('美图秀秀'),
		_t('Camera 360'),
		_t('天天P图'),
		_t('黄油相机'),
		_t('Enlight'),
		_t('Facetune'),
		_t('Prisma'),
		_t('PicsArt'),
		_t('Pixlr'),
		_t('VSCO'),
		_t('Instagram'),
    );
}

//自定义字段
