<?php
//获取设置
define('THEME_ID', 'lovestutheme01'); // 主题ID，请勿修改,否则可能导致配置错误
define('THEME_VERSION', '1.3.0'); // 主题内部版本号，请勿修改，否则可能导致配置错误
define('THEME_ID_SET', 'lovestutheme01_set');

global $theme_option;

theme_int_set();
include_once 'inc/obj.php';
include_once 'inc/ajax.php';
//add_filter('get_avatar', 'my_custom_avatar', 1, 5);
function my_custom_avatar($avatar, $id_or_email, $size, $default, $alt)
{
    //屏蔽自带头像
    if (!empty($id_or_email->user_id)) {
        $avatar = getImgDir('avatar.png');
    } else {
        $avatar = getImgDir('avatar.png');
    }
    $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

    return $avatar;
}

function getImgDir($name)
{
    //获取图片路径
    return get_stylesheet_directory_uri() . '/static/img/' . $name;
}

$foldercat = getImgDir('foldercat.png');
register_sidebar(array(
    'name' => '首页侧边栏',
    'id' => 'exsidebar_index',
    'description' => '首页侧边栏',
    'class' => 'sidebar_A',
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="sidebar-cat-title"><img width="19" src="' . $foldercat . '">',
    'after_title' => '</div>'));

if (function_exists('add_theme_support')) {
//开启导航菜单主题支持
    add_theme_support('top-nav-menus');
//注册一个导航菜单
    register_nav_menus(array(
        'header_menu' => '顶部导航菜单'
    ));
}
//自定义评论
function my_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    $reply = '';
    if ($depth > 0 && $comment->comment_parent) {
        $reply = get_comment_author($comment->comment_parent);

        if ($reply) {
            $reply = '<span class="comment-from">@<a href="#comment-' . $comment->comment_parent . '">' . $reply . '</a></span>';
        } else {
            $reply = '';
        }

    }
    ?>
<li class="comment" id="li-comment-<?php comment_ID(); ?>">
    <div class="media">
        <div class="media-left">
            <?php if (function_exists('get_avatar') && get_option('show_avatars')) {
                echo get_avatar($comment, 48);
            } ?>
        </div>
        <div class="media-body">
            <?php echo __('<p class="author_name">') . get_comment_author_link() . $reply . '</p>'; ?>
            <?php if ($comment->comment_approved == '0') : ?>
                <em>评论等待审核...</em><br/>
            <?php endif; ?>
            <?php echo comment_text(); ?>
        </div>
    </div>
    <div class="comment-metadata">
        <span class="comment-pub-time">
   				<?php echo get_comment_time('Y-m-d H:i'); ?>
   			</span>
        <span class="comment-btn-reply">
 				<i class="fa fa-reply"></i> <?php comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
   			</span>
    </div>

    <?php
}

add_action('admin_menu', 'theme_options_menu');
function theme_options_menu()
{
    add_menu_page('主题设置', '主题设置', 'administrator', 'theme_options_menu', 'theme_settings_admin', 'dashicons-admin-appearance');
}

function theme_settings_admin()
{
    include_once get_template_directory() . "/inc/page-options.php";
}


function theme_int_set()
{
    global $theme_option;
    $theme_option = get_option(THEME_ID_SET);
    if ($theme_option == false || $theme_option == '{}') {
        $theme_option = array('seo' => 0, 'single_icon' => '', 'index_title' => '', 'site_description' => '', 'site_key' => '', 'autoseo' => 0,'version'=>THEME_VERSION);

        update_option(THEME_ID_SET, json_encode($theme_option));
        $theme_option = json_decode(json_encode($theme_option), true);
    } else {
        $theme_option = json_decode($theme_option, true);
    }

}

?>