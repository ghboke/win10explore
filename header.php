<!doctype html>
<head>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php get_blog_title_obj() ?></title>
    <?php obj_seo_set(); ?>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/static/layui/css/layui.css' ?>"
          type="text/css"/>
    <link rel="stylesheet"
          href="<?php echo get_stylesheet_directory_uri() . '/static/font-awesome/css/font-awesome.css' ?>"
          type="text/css"/>
    <?php wp_head(); ?>
</head>
<body>
<header>

</header>