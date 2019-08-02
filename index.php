<?php
include_once 'inc/obj.php';
get_header();

?>

<div class="layui-container" id="main">
    <div class="blog-title"><?php obj_title_icon();
        bloginfo('name'); ?>
        <div class="close"><a href="javascript:window.opener=null;window.open('','_self');window.close();"><i
                        class="layui-icon layui-icon-close"></i></a>

        </div>
    </div>

    <div class="toolbar">
        <div class="layui-row">
            <div class="obj_menu_header">
                <?php get_nav_menu_obj(); ?>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="layui-row">
            <div class="layui-col-md1 <?php get_self_adaption_css() ?>">
                <div class="toobar-col"><i class="fa fa-arrow-left" aria-hidden="true"
                                           onclick="javascript :history.back(-1)"></i>
                    <i class="fa fa-arrow-right" aria-hidden="true" onclick="javascript :history.forward()"></i><i
                            class="fa fa-arrow-up" aria-hidden="true"></i></div>
            </div>
            <div class="layui-col-md9 layui-col-xs-12 layui-col-sm-12">
                <div class="toolbar-url"><img class="toobar-icon" src="<?php echo getImgDir('folder.ico') ?>"
                                              alt=""><span><a
                                href="//<?php echo $_SERVER['SERVER_NAME']; ?>">本网站</a></span>><span>最新文章</span>
                </div>
            </div>
            <div class="layui-col-md2 <?php get_self_adaption_css() ?>">
                <?php get_search_obj(); ?>
            </div>
        </div>

    </div>
    <div class="layui-row content">
        <div class="layui-col-md2 sidebar <?php get_self_adaption_css() ?>">
            <?php get_sidebar(); ?>
        </div>
        <div class="layui-col-md10 postlist">
            <?php default_post(); ?>
        </div>
        <div class="posts-nav">
            <?php posts_nav_link(' - '); ?>
        </div>
    </div>

</div>
<?php get_footer() ?>
<?php wp_footer(); ?>
</body>
</html>