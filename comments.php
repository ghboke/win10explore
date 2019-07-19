<?php
if ( post_password_required() )
    return;
?>
<div id="comments" class="responsesWrapper">

    <?php if(comments_open()){
        $comment_form_args = array(
            'submit_button' => '<div style="text-align: right"><input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" /></div>',
            'comment_notes_before' => '',
            'class_submit' => 'button_submit',
            'label_submit' => __('提交评论', 'win10exp'),
            'comment_notes_after' => '',
            'id_form' => 'form_comment',
            'cancel_reply_link' => __('取消回复', 'win10exp'),
            'comment_field' => '<div class="comment_form_textarea_box layui-row"><textarea class="comment_form_textarea layui-col-md12 layui-col-xs12" name="comment" id="comment" placeholder="发表你的看法吧~~~啦啦啦"></textarea></div>',
            'fields' => apply_filters('comment_form_default_fields', array(
                'author' => '<div class="layui-row comment_form_input"><input class="layui-col-md4 layui-col-xs12" placeholder="昵称" type="text" id="author" name="author" value="' . esc_attr($comment_author) . '" ' . ($req ? "required" : '') . '>',
                'email' => '<input class="layui-col-md4 layui-col-xs12" type="email" id="email" name="email" placeholder="邮箱地址" value="' . esc_attr($comment_author_email) . '" ' . ($req ? "required" : '') . '>',
                'url' => '<input class="layui-col-md4 layui-col-xs12" type="url" id="url" name="url" placeholder="网址(选填)" value="' . esc_attr($comment_author_url) . '"></div>',
            )));
        comment_form($comment_form_args);

    } ?>

    <meta content="UserComments:<?php echo number_format_i18n( get_comments_number() );?>" itemprop="interactionCount">
    <h3 class="comments-title">共有 <span class="commentCount"><?php echo number_format_i18n( get_comments_number() );?></span> 条评论</h3>
    <ol class="commentlist">
        <?php
        wp_list_comments( array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 48,
            'type'        =>'comment',
            'callback'    =>'my_comment',
        ) );
        ?>
    </ol>
    <nav class="navigation comment-navigation u-textAlignCenter" data-fuck="<?php the_ID();?>">
        <?php paginate_comments_links(array('prev_next'=>true)); ?>
    </nav>
</div>