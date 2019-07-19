<?php
if (!is_active_sidebar('exsidebar_index')){
    catlist();
    return;
}
dynamic_sidebar('exsidebar_index');