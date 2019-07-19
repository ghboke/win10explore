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
    ?>
    <div class="layui-row">
        <div class="layui-col-md8 post-namelist-title">名称</div>
        <div class="layui-col-md2 post-namelist-title <?php get_self_adaption_css()?>">修改日期</div>
        <div class="layui-col-md2 post-namelist-title <?php get_self_adaption_css()?>">阅读</div>
    </div>
    <?php
    while (have_posts()) {
        the_post();
        ?>
        <div class="layui-row post-list-post">
            <div class="layui-col-md7 layui-col-sm12 layui-col-xs12"><img class="postlist-table-icon"
                                                           src="<?php echo get_stylesheet_directory_uri() . '/static/img/txt.png' ?>"><a
                            href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
            <div class="layui-col-md3 <?php get_self_adaption_css()?>"><?php the_time('Y-m-d/D G:i') ?></div>
            <div class="layui-col-md2 <?php get_self_adaption_css()?>"><?php the_views(true); ?></div>
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
    $blogname = get_bloginfo('name');
    if (is_home()) {
        echo $blogname;
    } elseif (is_category()) {
        single_post_title();
        echo ' - '.$blogname;
    } elseif (is_single()) {
        single_post_title();
        echo ' - '.$blogname;
    } elseif (is_page()) {
        single_post_title();
        echo ' - '.$blogname;

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

function get_self_adaption_css($where='all')
{
    if ($where=='all'){
        echo 'layui-hide-xs layui-hide-sm layui-show-md-block';
    }elseif ($where=='toolbar'){
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
<?php } ?>