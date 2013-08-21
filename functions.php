<?php

function load_config() {
    return json_decode( file_get_contents(get_stylesheet_directory_uri().'/config.json') );
}

// Adding style
add_action('wp_head', 'scott_dev_style');

function scott_dev_style() {
    $config = load_config();
    $dev = $config->dev;
	$theme = get_stylesheet_directory_uri();
    $less_style = <<<EOF
    <link rel="stylesheet/less" type="text/css" href="{$theme}/stuff/style.less" />
    <script src="{$theme}/stuff/less.js" type="text/javascript"></script>
EOF;
	$css_style = <<<EOF
	<link rel="stylesheet" type="text/css" media="all" href="{$theme}/style.css" />
EOF;
    if( $dev ) echo $less_style;
    else echo $css_style;
}

// Adding script
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method() {
    if( !is_admin() ) wp_deregister_script('jquery');
    wp_enqueue_script( 'scott_script', get_stylesheet_directory_uri() . '/stuff/scott.js',  null, '1', true );
}

$silent_post = null;
function find_actual_project($var) {
    global $silent_post;
    return $var->post_name == $silent_post;
}
function get_actual_project() {
    global $silent_post, $wp_query;
    $actual = array_filter($wp_query->posts,'find_actual_project');
    return array_shift(array_values($actual));
}
function is_project_page() {
    global $wp_query;
    return ( (isset($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] == 'project') );
}

function srd_title( $prefix = true) {
    $begin = $prefix ? 'Scott Riker Duncombe :: ' : '';
    if( is_project_page() && !is_home() ) {
        $actual = get_actual_project();
        $end = $actual->post_title;
    } else if( is_home() ) $end = "Projects";
    else $end = wp_title("",false);

    return $begin.$end;
}
function srd_description() {
    if( is_project_page() && !is_home()  ) {
        $actual = get_actual_project();
        return str_replace("\n","",strip_tags( $actual->post_content));
    } else return get_bloginfo('description');
}
function srd_thumbnail() {
    if( is_project_page() && !is_home()  ) {
        $actual = get_actual_project();
        return the_post_thumbnail_src( $actual->ID);
    } else return get_stylesheet_directory_uri()."/stuff/me.jpeg";
}
function srd_url() {
    if( is_project_page()  && !is_home() ) {
        $actual = get_actual_project();
        return 'project/'.$actual->post_name.'/';
    } else if( is_home() ) return '';
    else {
        global $wp_query;
        return $wp_query->query_vars['name'].'/';
    }
}
function the_post_thumbnail_src($id = null) {
  return (preg_match('~\bsrc="([^"]++)"~', get_the_post_thumbnail($id,'small'), $matches)) ? $matches[1] : '';
}

add_theme_support( 'post-thumbnails' );

add_action('pre_get_posts', 'only_and_all_projects' );
function only_and_all_projects( $wp_query ) {
    global $silent_post;
    if( is_home() || is_project_page() ) {
        set_query_var('post_type', 'project');
        set_query_var('post_status', 'publish');
        set_query_var('posts_per_page', -1);
    }
	if( is_project_page() ) {
        if( isset($wp_query->query_vars['project']) ) $silent_post = $wp_query->query_vars['project'];
        $wp_query->query_vars['project'] = null;
        $wp_query->query_vars['name'] = null;
	}
}

add_action( 'init', 'register_cpt_project' );
function register_cpt_project() {

    $labels = array(
        'name' => _x( 'Projects', 'Project' ),
        'singular_name' => _x( 'Project', 'Project' ),
        'add_new' => _x( 'Add New', 'Project' ),
        'add_new_item' => _x( 'Add New Project', 'Project' ),
        'edit_item' => _x( 'Edit Project', 'Project' ),
        'new_item' => _x( 'New Project', 'Project' ),
        'view_item' => _x( 'View Project', 'Project' ),
        'search_items' => _x( 'Search projects', 'Project' ),
        'not_found' => _x( 'No Projects found', 'Project' ),
        'not_found_in_trash' => _x( 'No Projects found in Trash', 'Project' ),
        'parent_item_colon' => _x( 'Parent project:', 'Project' ),
        'menu_name' => _x( 'Projects', 'Project' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'taxonomies' => array( 'category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'Project', $args );
}
add_filter( 'use_default_gallery_style', '__return_false' );
function do_project_loop() {
    ?>
        <div id="content" >

        <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="container" >
                        <div class="project" data-title="<?php the_title(); ?>" data-slug="<?php the_permalink(); ?>">
                            <div class="thumbnail" style="background-image:url(<?php echo the_post_thumbnail_src(); ?>);">
                                <h1><?php the_title(); ?></h1>
                            </div>
                            <div class="inside">
                                <div class="content">
                                    <a class="close control" href="#">close</a>
                                    <a class="prev control" href="#"><</a>
                                    <a class="next control" href="#">></a>
                                    <h1><?php the_title(); ?></h1>
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    </div>


                <?php endwhile; ?>

        <?php endif; ?>

    </div><!-- #content -->
    <script type="text/javascript">gridPage = true;</script>

    <?php
}

function open_graph_crap() {
    $title = srd_title();
    $description = srd_description();
    $thumbnail = srd_thumbnail();
    $link = srd_url();
    $crap = <<<EOF
    <meta property='og:locale' content='en_US'/>
    <meta property='og:type' content='article'/>
    <meta property='og:title' content="$title"/>
    <meta property='og:description' content="$description"/>
    <meta property='og:url' content='http://scottduncombe.com/$link'/>
    <meta property='og:site_name' content="Scott Riker Duncombe Web Design"/>
    <meta property='article:publisher' content='http://facebook.com/srduncombe'/>
    <meta property='og:image' content='$thumbnail'/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="@sduncombe"/>
    <meta name="twitter:domain" content="ScottDuncombe"/>
    <meta name="twitter:creator" content="@sduncombe"/>
    <meta name="twitter:image:src" content="$thumbnail"/>
EOF;
    echo $crap;
}