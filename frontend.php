<?php

function ohw_process_request(){
    global $wp_query;
    
    if (! $_GET['json'] || ! $_GET['callback']){
        return;
    }

    $action = $_GET['json'];
    $data = array();

    switch ($action) {
        case 'post_list':
            $data = ohw_get_post_list();
        break;

        case 'post_detail':
            $data = ohw_get_post_detail();
        break;

        case 'page_list':
            $data = ohw_get_page_list();
        break;

        case 'page_detail':
            $data = ohw_get_page_detail();
        break;

        case 'menu':
            $data = ohw_get_menu();
        break;

        default:
            $data = ohw_get_post_list();
        break;
    }
    ohw_response($data);
}

add_action( 'template_redirect', 'ohw_process_request' );


// output jsonp
function ohw_response($data){
    header("content-type: text/javascript; charset=utf-8");
    header("access-control-allow-origin: *");
    echo htmlspecialchars($_GET['callback']) . '(' . json_encode($data, JSON_UNESCAPED_UNICODE) . ')';
    die();
}

// get post list
function ohw_get_post_list() {

    $api_posts = new wp_query(
        array(
            'post_type'   => 'post',
            'post_status' => 'publish',
            'paged'       => intval($_GET['page'])
        )
    );

    $response = new stdClass();
    $response->total_pages = $api_posts->max_num_pages;

    // get post data
    $posts_data = array();
    if ($api_posts->have_posts()){
        while($api_posts->have_posts()){
            $api_posts->the_post();
            $new_post            = new stdClass();
            $new_post->id        = get_the_ID();
            $new_post->title     = get_the_title();
            $new_post->excerpt   = get_the_excerpt();
            $new_post->content   = get_the_content('');
            $new_post->thumbnail = get_the_post_thumbnail_url(get_the_ID());
            $posts_data[]        = $new_post;
        }
    }
    wp_reset_query();

    $response->posts = $posts_data;

    return $response;
}


// get post detail
function ohw_get_post_detail(){

    $post_id = intval($_GET['post_id']);
    $post    = get_post($post_id);
    
    $return_post            = new stdClass();
    $return_post->id        = $post->ID;
    $return_post->title     = $post->title;
    $return_post->excerpt   = $post->excerpt;
    $return_post->content   = nl2br($post->post_content);
    $return_post->thumbnail = get_the_post_thumbnail_url($post_id);
    return $return_post;
}

// get page list
function ohw_get_page_list(){
    $pages = get_pages();

    $return_pages = array();
    foreach ($pages as $page) {
        $new_page            = new stdClass();
        $new_page->id        = $page->ID;
        $new_page->title     = $page->post_title;
        $new_page->excerpt   = $page->excerpt;
        $new_page->content   = nl2br($page->post_content);
        $new_page->thumbnail = get_the_post_thumbnail_url($page->ID);
        $return_pages[]      = $new_page;
    }

    return $return_pages;
}

// get page detail
function ohw_get_page_detail(){
    $page_id = intval($_GET['page_id']);
    $page = get_page($page_id);
    
    $return_page            = new stdClass();
    $return_page->id        = $page->ID;        
    $return_page->title     = $page->post_title;
    $return_page->excerpt   = $page->excerpt;
    $return_page->content   = nl2br($page->post_content);
    $return_page->thumbnail = get_the_post_thumbnail_url($page_id);
    return $return_page;
}

// get side menu
function ohw_get_menu(){
    $ohw_option = get_option('openhybridwordpress_option');
    $page_ids = (isset($ohw_option['menu'])) ? $ohw_option['menu'] : array();
    $pages = get_pages(
        array(
            'include'     => $page_ids,
            'post_status' => 'publish',
            'sort_column' => 'post_date',
            'sort_order ' => 'desc'
        )
    );

    $return_menus = array();
    foreach ($pages as $page) {
        $new_menu            = new stdClass();
        $new_menu->id        = $page->ID;
        $new_menu->title     = $page->post_title;
        $return_menus[]      = $new_menu;
    }

    ohw_response($return_menus);
}

?>