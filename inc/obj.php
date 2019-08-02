<?php
function catlist()
{
    //分类列表
    ?>
    <div class="sidebar-cat">
        <div class="sidebar-cat-title">
            <div class="">分类目录</div>
        </div>
        <div class="sidebar-cat-list">
            <?php
            $catlist = get_categories(8);
            foreach ($catlist as $cat) {
                ?>
                <li><a href="<?php echo get_category_link($cat->cat_ID) ?>"><?php echo $cat->name; ?></a></li>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}

function cat_post_list($catid)
{
    postlist($catid);
}

function postlist($cateid)
{
    //分类ID取文章
    global $post;
    $postlist = get_posts(array('numberposts' => 10, 'category' => $cateid));
    foreach ($postlist as $post) {
        setup_postdata($post);
        ?>

        <tr class="postlist-table-list">
            <td><img class="postlist-table-icon"
                     src="<?php echo get_stylesheet_directory_uri() . '/static/img/txt.png' ?>"><a
                        href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
            <td><?php the_time('Y-m-d/D G:i') ?></td>
            <td>
                <div class="view"><?php the_views(true); ?></div>
            </td>
        </tr>
        <?php
    }

}


function default_post()
{

    if (!have_posts()) {
        ?>
        <div><p style="padding-left: 20px">啥也没有</p></div>
        <?php
        return;
    }
    global $post;
    global $theme_option;
    if ($theme_option['single_icon'] == '') {
        $single_icon_src = getImgDir('txt.png');

    } else {
        $single_icon_src = $theme_option['single_icon'];
    }
    ?>
    <div class="layui-row">
        <div class="layui-col-md8 post-namelist-title">名称</div>
        <div class="layui-col-md2 post-namelist-title <?php get_self_adaption_css() ?>">修改日期</div>
        <div class="layui-col-md2 post-namelist-title <?php get_self_adaption_css() ?>">阅读</div>
    </div>
    <?php
    while (have_posts()) {
        the_post();
        ?>
        <div class="layui-row post-list-post">
            <div class="layui-col-md7 layui-col-sm12 layui-col-xs12"><img class="postlist-table-icon"
                                                                          src="<?php echo $single_icon_src; ?>"><a
                        href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
            <div class="layui-col-md3 <?php get_self_adaption_css() ?>"><?php the_time('Y-m-d/D G:i') ?></div>
            <div class="layui-col-md2 <?php get_self_adaption_css() ?>"><?php the_views(true); ?></div>
        </div>
        <?php
    }
}

function get_search_obj()
{
    ?>
    <form class="search-form" action="//<?php echo $_SERVER['SERVER_NAME']; ?>" method="get" role="search">
        <div class="toolbar-search"><input type="text" name="s" value="" placeholder="搜索内容"></div>
    </form>
    <?php
}

function get_blog_title_obj()
{
    global $theme_option;
    $blogname = get_bloginfo('name');
    if (is_home()) {
        if ($theme_option['seo'] != 1) {
            echo $blogname;
        } else {
            if ($theme_option['index_title'] == '') {
                echo $blogname;
            } else {
                echo $theme_option['index_title'];
            }

        }
    } elseif (is_category()) {
        single_cat_title();
        if ($theme_option['seo'] != 1) {
            echo ' - ' . $blogname;
        } else {
            echo ' - ' . $theme_option['site_name'];
        }

    } elseif (is_single() || is_page()) {
        single_post_title();
        if ($theme_option['seo'] != 1) {
            echo ' - ' . $blogname;
        } else {
            echo ' - ' . $theme_option['site_name'];
        }
    } else {
        wp_title('', true);
    }
}

function get_nav_menu_obj()
{
    wp_nav_menu(array(
        'theme_location' => 'header_menu',
        'menu_class' => 'menu_header',
        'container_class' => 'menu_nav',
        'container' => 'div',
        'depth' => 2

    )); //调用第一个菜单
}

function get_self_adaption_css($where = 'all')
{
    if ($where == 'all') {
        echo 'layui-hide-xs layui-hide-sm layui-show-md-block';
    } elseif ($where == 'toolbar') {
        echo 'layui-show-md-block';
    }

}

function aurelius_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment; ?>
    <li class="comment" id="li-comment-<?php comment_ID(); ?>">
        <div class="gravatar"> <?php if (function_exists('get_avatar') && get_option('show_avatars')) {
                echo get_avatar($comment, 48);
            } ?>
            <?php comment_reply_link(array_merge($args, array('reply_text' => '回复', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?> </div>
        <div class="comment_content" id="comment-<?php comment_ID(); ?>">
            <div class="clearfix">
                <?php printf(__('<cite class="author_name">%s</cite>'), get_comment_author_link()); ?>
                <div class="comment-meta commentmetadata">发表于：<?php echo get_comment_time('Y-m-d H:i'); ?></div>
                &nbsp;&nbsp;&nbsp;<?php edit_comment_link('修改'); ?>
            </div>
            <div class="comment_text">
                <?php if ($comment->comment_approved == '0') : ?>
                    <em>你的评论正在审核，稍后会显示出来！</em><br/>
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
        </div>
    </li>
<?php }

function obj_seo_set()
{
    global $theme_option;

    if ($theme_option['seo'] != 1) {
        return;
    }
    $description = '';
    $keywords = '';

    if (is_home()) {
        $description = $theme_option['site_description'];
        if ($theme_option['site_description'] == '') {
            $description = bloginfo('description');
        }
        $keywords = $theme_option['site_key'];
    } elseif (is_single() || is_page()) {

        if ($theme_option['autoseo'] != 1) {
            return;
        }
        global $post;
        $description = str_replace("\n", "", mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));

        // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述

        // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词

        $tags = wp_get_post_tags($post->ID);
        foreach ($tags as $tag) {
            $keywords = $keywords . $tag->name . ", ";
        }
        $keywords = rtrim($keywords, ', ');

    } elseif (is_category()) {
        // 分类的description可以到后台 - 文章 -分类目录，修改分类的描述
        $description = category_description();
        $keywords = single_cat_title('', false);
    } elseif (is_tag()) {
        // 标签的description可以到后台 - 文章 - 标签，修改标签的描述
        $description = tag_description();
        $keywords = single_tag_title('', false);
    }
    $description = trim(strip_tags($description));
    $keywords = trim(strip_tags($keywords));
    ?>
    <meta name="keywords" content="<?php echo $keywords; ?>"/>
    <meta name="description" content="<?php echo $description; ?>"/>
    <?php
}

function obj_title_icon()
{
    global $theme_option;
    if ($theme_option['title_icon'] == '') {
        $src = getImgDir('folder.ico');
    } else {
        $src = $theme_option['title_icon'];
    }
    ?>
    <img class="toobar-icon"
         src="<?php echo $src ?>"
         alt="">
    <?php

}

?>

