<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Contents
{
    static public function parseContent($data, $widget, $last)
    {
		$db=Typecho_Db::get();
        $load_image = $db->fetchAll($db->select('value')->from('table.options')->where('name = %s', "theme:Miracles")->limit(1));
        $load_image = explode("\";",explode("\"",explode("\"loading_image\";",$load_image[0]["value"],2)[1],2)[1],2)[0];
        $text = empty($last) ? $data : $last;
        if ($widget instanceof Widget_Archive) {
			//ParseOther
			$text = Contents::parsePicShadow(Contents::parseNotice(Contents::parseKbd(Contents::parseCode(Contents::parseImages(Contents::parseHeadings(Contents::parseTextColor(Contents::parseRuby(Contents::parseTip($text)))))))));
			//LazyLoad
	        $text = preg_replace('/<img (.*?)src(.*?)(\/)?>/','<img $1src="/usr/themes/Miracles/images/loading/'.$load_image.'.gif" data-original$2 />',$text);
			//owo
			$text = Contents::parseEmo($text);
			//Links
			$text = Contents::parseLink($text);
        }
        return $text;
    }
	static public function parseImages($text){
	    $text = preg_replace('/<img(.*?)src="(.*?)"(.*?)alt="(.*?)"(.*?)>/s','<center><a data-fancybox="gallery" href="${2}" class="gallery-link"><img${1}src="${2}"${3}></a><span class="post-img-alt">${4}</span></center>',$text); 
		return $text;
    }
	static public function parseTextColor($text){
		$text = preg_replace('/\&\{(.*?)\|(.*?)\|(.*?)\}/s','<span style="color:${2};background:${3}">${1}</span>',$text);
		return $text;
	}
	static public function parseRuby($text){
		$reg = '/\{\{(.*?):(.*?)\}\}/s';
        $rp = '<ruby>${1}<rp>(</rp><rt>${2}</rt><rp>)</rp></ruby>';
        $text = preg_replace($reg,$rp,$text);
		
		return $text;
	}
	static public function parseTip($text){
		$text = preg_replace('/\[tip\](.*?)\[\/tip\]/s','<div class="tip"><div class="container-fluid"><div class="row"><div class="col-1 tip-icon"><i class="iconfont icon-info"></i></div><div class="col-11 tip-content">${1}</div></div></div></div>',$text);
		$text = preg_replace('/\[tip type="(.*?)"\](.*?)\[\/tip\]/s','<div class="tip ${1}"><div class="container-fluid"><div class="row"><div class="col-1 tip-icon"><i class="iconfont icon-info"></i></div><div class="col-11 tip-content">${2}</div></div></div></div>',$text);
		$text = preg_replace('/\[tip\-group\](.*?)\[\/tip\-group\]/s','<div class="tip-group">${1}</div>',$text);
		return $text;
	}
	static public function parseNotice($text){
		$text = preg_replace('/\[notice\](.*?)\[\/notice\]/s','<div class="notice" role="note">${1}</div>',$text);
		return $text;
	}
	static public function parsePicShadow($text){
		$text = preg_replace('/\[shadow\](.*?)\[\/shadow\]/s','<div class="post-img-shadow">${1}</div>',$text);
		return $text;
	}
    static public function parseLink($text)
    {
        $reg = '/\[links\](.*?)\[\/links\]/s';
        $rp = '<div class="links-box container-fluid"><div class="row">${1}</div></div>';
        $text = preg_replace($reg, $rp, $text);
        $reg = '/\[(.*?)\]\{(.*?)\}\((.*?)\)\+\((.*?)\)/s';
        $rp = '<div class="col-lg-2 col-6 col-md-3 links-container">
		    <a href="${2}" title="${4}" target="_blank" class="links-link">
			  <div class="links-item">
			    <div class="links-img"><img src="/usr/themes/Miracles/images/loading/avatar.jpg" data-original=\'${3}\'></div>
				<div class="links-title">
				  <h4>${1}</h4>
				</div>
		      </div>
			  </a>
			</div>';
        $text = preg_replace($reg, $rp, $text);
        $reg = '/\[links data="(.*?)"\]/';
        $dataLink = preg_match_all($reg, $text, $matches);
        if (!$dataLink) return $text;
        $http = Typecho_Http_Client::get();
        if (false == $http) {
            $text = str_replace($matches[0][0],  '<br>对不起, 您的主机不支持 php-curl 扩展而且没有打开 allow_url_fopen 功能, 无法正常使 json 友链功能', $text);
            return $text;
        }
        for ($j = 0; $j <= $dataLink; $j++) {
            $match = $matches[1][$j];
            try {
                $result = $http->send($match);
            } catch (Typecho_Http_Client_Exception $ex) {
                $text = str_replace($matches[0][$j],  '对不起,json外链请求失败! 错误信息:' . $ex->getMessage(), $text);
                continue;
            }
            $data = json_decode($result, true);
            if ($data == false) {
                $text = str_replace($matches[0][$j],  '对不起,json外链解析失败!', $text);
                continue;
            }
            $linkItemNum = count($data);
            $linksList = '';
            for ($i = 0; $i < $linkItemNum; $i++) {
                $name = $data[$i]['name'];
                $link = $data[$i]['link'];
                $avatar = $data[$i]['avatar'];
                $des = $data[$i]['des'];
                $linksList .= '<div class="col-lg-2 col-6 col-md-3 links-container">
		    <a href="' . $link . '" title="' . $des . '" target="_blank" class="links-link">
			  <div class="links-item">
			    <div class="links-img"><img src="/usr/themes/Miracles/images/loading/avatar.jpg" data-original=\''.$avatar.'\'></div>
				<div class="links-title">
				  <h4>' . $name . '</h4>
				</div>
		      </div>
			  </a>
			</div>';
            }
            $text = str_replace($matches[0][$j], '<div class="links-box container-fluid"><div class="row">' . $linksList . '</div></div>', $text);
        }
        return $text;
    }
	static public function parseEmo($content) {
		$content = preg_replace_callback('/\:\:\(\s*(呵呵|哈哈|吐舌|太开心|笑眼|花心|小乖|乖|捂嘴笑|滑稽|你懂的|不高兴|怒|汗|黑线|泪|真棒|喷|惊哭|阴险|鄙视|酷|啊|狂汗|what|疑问|酸爽|呀咩爹|委屈|惊讶|睡觉|笑尿|挖鼻|吐|犀利|小红脸|懒得理|勉强|爱心|心碎|玫瑰|礼物|彩虹|太阳|星星月亮|钱币|茶杯|蛋糕|大拇指|胜利|haha|OK|沙发|手纸|香蕉|便便|药丸|红领巾|蜡烛|音乐|灯泡|开心|钱|咦|呼|冷|生气|弱|吐血)\s*\)/is',
        array('Contents', 'parsePaopaoBiaoqingCallback'), $content);
        $content = preg_replace_callback('/\:\@\(\s*(高兴|小怒|脸红|内伤|装大款|赞一个|害羞|汗|吐血倒地|深思|不高兴|无语|亲亲|口水|尴尬|中指|想一想|哭泣|便便|献花|皱眉|傻笑|狂汗|吐|喷水|看不见|鼓掌|阴暗|长草|献黄瓜|邪恶|期待|得意|吐舌|喷血|无所谓|观察|暗地观察|肿包|中枪|大囧|呲牙|抠鼻|不说话|咽气|欢呼|锁眉|蜡烛|坐等|击掌|惊喜|喜极而泣|抽烟|不出所料|愤怒|无奈|黑线|投降|看热闹|扇耳光|小眼睛|中刀)\s*\)/is',
        array('Contents', 'parseAruBiaoqingCallback'), $content);
        $content = preg_replace_callback('/\:\&\(\s*(.*?)\s*\)/is',
        array('Contents', 'parseTweBiaoqingCallback'), $content);

        return $content;
	}
    private static function parsePaopaoBiaoqingCallback($match)
    {
        return '<img class="owo-img" src="/usr/themes/Miracles/images/loading/owo.png" data-original="/usr/themes/Miracles/images/biaoqing/paopao/'. str_replace('%', '', urlencode($match[1])) . '_2x.png">';
    }
    private static function parseAruBiaoqingCallback($match)
    {
        return '<img class="owo-img" src="/usr/themes/Miracles/images/loading/owo.png" data-original="/usr/themes/Miracles/images/biaoqing/aru/'. str_replace('%', '', urlencode($match[1])) . '_2x.png">';
    }
    private static function parseTweBiaoqingCallback($match)
    {
        return '<img class="owo-img" src="/usr/themes/Miracles/images/loading/owo.png" data-original="/usr/themes/Miracles/images/biaoqing/twemoji/'. str_replace('%', '', $match[1]) . '.png">';
    }
    static public function parseCode($text) {
		$text = preg_replace('/<pre><code>/s','<pre><code class="language-html">',$text);
		return $text;
	}
    static public function parseKbd($text) {
		$text = preg_replace('/\~(.*?)\~/s','<kbd>${1}</kbd>',$text);
		return $text;
	}
	static public function parseHeadings($text){
		$reg='/\<h([2-3])(.*?)\>(.*?)\<\/h.*?\>/s';
        $text = preg_replace_callback($reg, array('Contents', 'parseHeaderCallback'), $text);
		
		return $text;
	}
    static private $CurrentTocID = 0;
    static public function parseHeaderCallback($matchs)
    {
        $id = $matchs[3];
		$id = str_replace(' ','_',$id);
		$id = str_replace('&','_',$id);
		$id = str_replace('?','_',$id);
		$id = str_replace("'",'_',$id);
		$id = str_replace('"','_',$id);
		$id = str_replace('’','_',$id);
		$id = str_replace('“','_',$id);
		$id = str_replace('?','_',$id);
        return '<h'.$matchs[1].$matchs[2].' id="'.$id.'">'.$matchs[3].'<a href="#'.$id.'" title="章节链接" class="post-toc-link no-line"><i class="iconfont icon-paragraph"></i></a></h'.$matchs[1].'>';
    }
	static public function paresNav($data, $type) {
		$de_json = json_decode($data, true);
		$count_json = count($de_json);
        for ($i = 0; $i < $count_json; $i++) {
            $title = $de_json[$i]['title'];
            $link = $de_json[$i]['link'];
			if($type=="top-nav") {
			    echo '<a href="'. $link .'">'. $title .'</a>';
			}
			elseif($type=="mobile") {
				echo '<div class="col-6"><a href="'. $link .'">'. $title .'</a></div>';
			}
			elseif($type=="drawer") {
				echo '<a href="'. $link .'" onclick="toggleDrawer()">'. $title .'</a>';
			}
        }
	}
	/**
     * 根据 id 返回对应的对象
     * 此方法在 Typecho 1.2 以上可以直接调用 Helper::widgetById();
     * 但是 1.1 版本尚有 bug，因此单独提出放在这里
     * 
     * @param string $table 表名, 支持 contents, comments, metas, users
     * @return Widget_Abstract
     */
    public static function widgetById($table, $pkId)
    {
        $table = ucfirst($table);
        if (!in_array($table, array('Contents', 'Comments', 'Metas', 'Users'))) {
            return NULL;
        }
        $keys = array(
            'Contents'  =>  'cid',
            'Comments'  =>  'coid',
            'Metas'     =>  'mid',
            'Users'     =>  'uid'
        );
        $className = "Widget_Abstract_{$table}";
        $key = $keys[$table];
        $db = Typecho_Db::get();
        $widget = new $className(Typecho_Request::getInstance(), Typecho_Widget_Helper_Empty::getInstance());
        
        $db->fetchRow(
            $widget->select()->where("{$key} = ?", $pkId)->limit(1),
                array($widget, 'push'));
        return $widget;
    }
    public static function title(Widget_Archive $archive)
    {
        $archive->archiveTitle(array(
            'category'  =>  '分类 %s 下的文章',
            'search'    =>  '包含关键字 %s 的文章',
            'tag'       =>  '标签 %s 下的文章',
            'author'    =>  '%s 发布的文章'
        ), '', ' - ');
        Helper::options()->title();
    }
}