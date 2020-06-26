<?php
/**
 * @param string $class
 * @param string $childClass
 * @param $menu
 */
function get_menu($class = 'active', $childClass = 'focus' ,$menu){
    $result_data = $menu->output('','',true);
    $arr_menu = $result_data['menu'];
    $_currentParent = $result_data['currentParent'];
    $_currentChild = $result_data['currentChild'];
    $_currentUrl ='';
    $arr_ic = array('ni-shop text-primary','ni-ungroup text-orange','ni-single-copy-04 text-pink','ni-ui-04 text-info');
    $i=1;
    foreach ($arr_ic as $v){
        $arr_ni[$i++] = $v;
    }

    foreach ($arr_menu as $key => $node) {
        if (!$node[1] || !$key) {
            continue;
        }
        foreach ($node[3] as $v_h){
            $sub_href = $v_h[3].$key;
        }
        echo '<li class="nav-item">
                        <a class="nav-link  '.($key == $_currentParent? ' ' . $class : NULL).'" href="#'.$sub_href.'" data-toggle="collapse" role="button"  aria-expanded="'.($key == $_currentParent ?'true' : 'false').'" aria-controls="navbar-dashboards">
                            <i class="ni '.$arr_ni[$key].'"></i>
                            <span class="nav-link-text">'.$node[0].'</span>
                        </a>
                        <div class="collapse ' . ($key == $_currentParent ? ' ' . $childClass : NULL).'" id="'.$sub_href.'" style="">
                        <ul class="nav nav-sm flex-column">
                     ';
        $last = 0;

        foreach ($node[3] as $inKey => $inNode) {
            if (!$inNode[4]) {
                $last = $inKey;
            }
        }
        foreach ($node[3] as $inKey => $inNode) {
            if ($inNode[4]) {
                continue;
            }
            $classes = array();
            if ($key == $_currentParent && $inKey == $_currentChild) {
                $classes[] = $childClass;
            } else if ($inNode[6]) {
                continue;
            }

            if ($inKey == $last) {
                $classes[] = 'last';
            }
            $color = $inKey == $_currentChild ? "color: brown":"";
            echo ' <li class="nav-item" >
                        <a href="'.($key == $_currentParent && $inKey == $_currentChild ? $_currentUrl : $inNode[2]).'" class="nav-link" style="'.$color .'">'.$inNode[0].'</a>
                   </li>';
        }

        echo'  </ul></div></li>';
    }
}