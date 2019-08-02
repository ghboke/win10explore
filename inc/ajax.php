<?php
function fun_save_set()
{
    global $theme_option;
    $theme_option['seo'] = $_POST['seo'];
    $theme_option['autoseo'] = $_POST['autoseo'];
    $theme_option['site_description'] = $_POST['site_description'];
    $theme_option['site_key'] = $_POST['site_key'];
    $theme_option['index_title'] = $_POST['index_title'];
    $theme_option['site_name'] = $_POST['site_name'];
    $theme_option['single_icon'] = $_POST['single_icon'];
    $theme_option['title_icon'] = $_POST['title_icon'];
    update_option(THEME_ID_SET, json_encode($theme_option));
    echo 1;
    wp_die();
}
function fun_check_version(){
    $http = new WP_Http;
    $result = $http->request( 'https://www.lovestu.com/api/theme.php?a=checkversion&theme=win10exp' );

    $result= json_decode($result['body'], true);
    if (is_array($result)){
        echo $result['version'];
    }else{
        echo '0';
    }
    wp_die();
}
add_action('wp_ajax_save_set', 'fun_save_set');
add_action('wp_ajax_check_version', 'fun_check_version');