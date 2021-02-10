<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines constants to help enqueue scripts and styles.
define('CHILD_THEME_HANDLE', sanitize_title_with_dashes(wp_get_theme()->get('Name')));
define('CHILD_THEME_VERSION', wp_get_theme()->get('Version'));

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action('after_setup_theme', 'genesis_sample_localization_setup');
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup()
{

    load_child_theme_textdomain('genesis-sample', get_stylesheet_directory() . '/languages');

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action('after_setup_theme', 'genesis_child_gutenberg_support');
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support()
{ // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
    require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

add_action('wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles');
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles()
{

    wp_enqueue_style(
        'genesis-sample-fonts',
        '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700',
        array(),
        CHILD_THEME_VERSION
    );

    wp_enqueue_style('dashicons');

    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    wp_enqueue_script(
        'genesis-sample-responsive-menu',
        get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
        array('jquery'),
        CHILD_THEME_VERSION,
        true
    );

    wp_localize_script(
        'genesis-sample-responsive-menu',
        'genesis_responsive_menu',
        genesis_sample_responsive_menu_settings()
    );

    wp_enqueue_script(
        'genesis-sample',
        get_stylesheet_directory_uri() . '/js/genesis-sample.js',
        array('jquery'),
        CHILD_THEME_VERSION,
        true
    );

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function genesis_sample_responsive_menu_settings()
{

    $settings = array(
        'mainMenu' => __('Menu', 'genesis-sample'),
        'menuIconClass' => 'dashicons-before dashicons-menu',
        'subMenu' => __('Submenu', 'genesis-sample'),
        'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
        'menuClasses' => array(
            'combine' => array(
                '.nav-primary',
            ),
            'others' => array(),
        ),
    );

    return $settings;

}

// Adds support for HTML5 markup structure.
add_theme_support('html5', genesis_get_config('html5'));

// Adds support for accessibility.
add_theme_support('genesis-accessibility', genesis_get_config('accessibility'));

// Adds viewport meta tag for mobile browsers.
add_theme_support('genesis-responsive-viewport');

// Adds custom logo in Customizer > Site Identity.
add_theme_support('custom-logo', genesis_get_config('custom-logo'));

// Renames primary and secondary navigation menus.
add_theme_support('genesis-menus', genesis_get_config('menus'));

// Adds image sizes.
add_image_size('sidebar-featured', 75, 75, true);

// Adds support for after entry widget.
add_theme_support('genesis-after-entry-widget-area');

// Adds support for 3-column footer widgets.
add_theme_support('genesis-footer-widgets', 3);

// Removes header right widget area.
unregister_sidebar('header-right');

// Removes secondary sidebar.
unregister_sidebar('sidebar-alt');

// Removes site layouts.
genesis_unregister_layout('content-sidebar-sidebar');
genesis_unregister_layout('sidebar-content-sidebar');
genesis_unregister_layout('sidebar-sidebar-content');

// Removes output of primary navigation right extras.
remove_filter('genesis_nav_items', 'genesis_nav_right', 10, 2);
remove_filter('wp_nav_menu_items', 'genesis_nav_right', 10, 2);

add_action('genesis_theme_settings_metaboxes', 'genesis_sample_remove_metaboxes');
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function genesis_sample_remove_metaboxes($_genesis_admin_settings)
{

    remove_meta_box('genesis-theme-settings-header', $_genesis_admin_settings, 'main');
    remove_meta_box('genesis-theme-settings-nav', $_genesis_admin_settings, 'main');

}

add_filter('genesis_customizer_theme_settings_config', 'genesis_sample_remove_customizer_settings');
/**
 * Removes output of header and front page breadcrumb settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function genesis_sample_remove_customizer_settings($config)
{

    unset($config['genesis']['sections']['genesis_header']);
    unset($config['genesis']['sections']['genesis_breadcrumbs']['controls']['breadcrumb_front_page']);
    return $config;

}

// Displays custom logo.
add_action('genesis_site_title', 'the_custom_logo', 0);

// Repositions primary navigation menu.
remove_action('genesis_after_header', 'genesis_do_nav');
add_action('genesis_header', 'genesis_do_nav', 12);

// Repositions the secondary navigation menu.
remove_action('genesis_after_header', 'genesis_do_subnav');
add_action('genesis_footer', 'genesis_do_subnav', 10);

add_filter('wp_nav_menu_args', 'genesis_sample_secondary_menu_args');
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args($args)
{

    if ('secondary' !== $args['theme_location']) {
        return $args;
    }

    $args['depth'] = 1;
    return $args;

}

add_filter('genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar');
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar($size)
{

    return 90;

}

add_filter('genesis_comment_list_args', 'genesis_sample_comments_gravatar');
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar($args)
{

    $args['avatar_size'] = 60;
    return $args;

}

add_action('genesis_header', 'genesis_secondary_header', 13);
function genesis_secondary_header()
{
    $header_open = genesis_markup(
        [
            'open' => sprintf("<div %s>", genesis_attr('site-secondary-header')),
            'context' => 'second-header',
            'echo' => true,
        ]
    );

    $category_names = "";
    $categories = get_terms(array(
        'taxonomy' => 'question_category',
        'parent' => 0,
        'number' => 10,
        'hide_empty' => false,
    ));
    foreach ($categories as $cat) {
        category_list_item($cat);
    }

    $header_close = genesis_markup(
        [
            'close' => '</div>',
            'context' => 'second-header',
            'echo' => true,
        ]
    );

    //return $header_open . $categorie_headers . $header_close;
}

function category_list_item($cat)
{
    $category_list_item_open = genesis_markup([
        'open' => sprintf("<a href=\"%s\">", "/questions/categories/" . $cat->slug),
        'close' => '</a>',
        'content' => $cat->name,
        'echo' => true,
    ]);
}

add_action('genesis_before_content', 'generate_hot_people_section', 6);
function generate_hot_people_section()
{
    if (is_front_page()) {
        $hot_people_section_open = genesis_markup(
            [
                'open' => sprintf("<div %s>", genesis_attr('hot-people-section')),
                'echo' => true,
            ]
        );

        $category_names = "";
        $categories = get_terms(array(
            'taxonomy' => 'question_category',
            'parent' => 0,
            'number' => 10,
            'hide_empty' => false,
        ));
        foreach ($categories as $cat) {
            $sub_categories = get_terms(array(
                'taxonomy' => 'question_category',
                'parent' => $cat->term_id,
                'number' => 10,
                'hide_empty' => false,
            ));
            foreach ($sub_categories as $sub_cat) {
                //for ($i = 0; $i < 18; $i++) {
                # code...

                $cat_image = get_term_meta($sub_cat->term_id, 'ap_category', true);
                $cat_image = wp_parse_args(
                    $cat_image, array(
                        'image' => [
                            'url' => '',
                        ],
                    )
                );

                genesis_markup([
                    'open' => sprintf("<div %s><a href=\"%s\">", genesis_attr('hot-people-tile'), "/questions/categories/" . $sub_cat->slug),
                    'echo' => true,
                ]);

                genesis_markup([
                    'open' => sprintf('<img src="%s" alt="%s">', $cat_image['image']['url'], $sub_cat->name),
                    'close' => '</img>',
                    'echo' => true,
                ]);

                genesis_markup([
                    'close' => '</a></div>',
                    'echo' => true,
                ]);
                //}

                //echo '<img src="' . $post_thumbnail_img[0] . '" alt="' . $sub_cat->name . '" />';
                //category_list_item($sub_cat);
            }
        }

        $hot_people_section_close = genesis_markup(
            [
                'close' => '</div>',
                'echo' => true,
            ]
        );
    }
}

add_action('genesis_before_content', 'generate_hot_prediction_section', 6);
function generate_hot_prediction_section()
{
    if (is_front_page()) {
        $hot_prediction_section_open = genesis_markup(
            [
                'open' => sprintf("<div %s>", genesis_attr('hot-prediction-section')),
                'echo' => true,
            ]
        );

        $hot_prediction_section_close = genesis_markup(
            [
                'close' => '</div>',
                'echo' => true,
            ]
        );
    }
}

add_action('init', 'register_shortcodes');
function register_shortcodes()
{
    add_shortcode('top-verification-feed', 'generate_top_verification_feed');
}
function generate_top_verification_feed()
{
    $top_verification_feed_open = genesis_markup(
        [
            'open' => sprintf("<div %s>", genesis_attr('hot-verification-section')),
            'echo' => false,
        ]
    );

    $top_verification_posts = get_posts(
        array(
            'post_type' => 'answer',
            'posts_per_page' => 10,
            'orderby' => 'date',
            'post_status' => 'publish',
        )
    );

    //get_template_part('top_verification_loop');

    $top_verification_feed_content = '';
    // foreach ($top_verification_posts as $post) {
    //     $top_verification_feed_content .= generate_top_verification_feed_item($post);
    // }

    $top_verification_feed_close = genesis_markup(
        [
            'close' => '</div>',
            'echo' => false,
        ]
    );

    return $top_verification_feed_open . $top_verification_feed_content . $top_verification_feed_close;
}
function generate_top_verification_feed_item($verification_post)
{
    $feed_item_open = genesis_markup(
        [
            'open' => sprintf("<div %s>", genesis_attr('hot-verification-item')),
            'echo' => false,
        ]
    );

    $prediction = get_post(wp_get_post_parent_id($verification_post));
    $cats = wp_get_post_terms($prediction->ID, 'question_category');
    $people = array_filter($cats, function ($v, $k) {
        return $v->category_parent == 0;
    }, ARRAY_FILTER_USE_BOTH);
    // if (count($people) != 1) {
    //     return null;
    // }
    $people = $people[0];
    $prediction_title = $prediction->post_title;
    $prediction_content = $prediction->post_content;

    //$verification_trueorfalse = get_post_meta($verification_post->ID, 'trueorfalse');
    // if (count($verification_trueorfalse) != 1) {
    //     return null;
    // }
    //$verification_trueorfalse = $verification_trueorfalse[0];

    $verification_author = $verification_post->post_author;
    $verification_content = $verification_post->post_content;

    $feed_item_close = genesis_markup(
        [
            'close' => '</div>',
            'echo' => false,
        ]
    );

    return $feed_item_open . $people->name . ' prediction: ' . $prediction_title . ' author: ' . $verification_author . ' veri_content: ' . $verification_content . $feed_item_close;
}

//Infinite Scroll
function wp_infinitepaginate()
{
    $loopFile = $_POST['loop_file'];
    $paged = $_POST['page_no'];
    // $action = $_POST['what'];
    // $value = $_POST['value'];

    // if ($action == 'author_name') {
    //     $arg = array('author_name' => $value, 'paged' => $paged, 'post_status' => 'publish');
    // } elseif ($action == 'category_name') {
    //     $arg = array('category_name' => $value, 'paged' => $paged, 'post_status' => 'publish');
    // } elseif ($action == 'search') {
    //     $arg = array('s' => $value, 'paged' => $paged, 'post_status' => 'publish');
    // } else {
    $arg = array(
        'post_type' => 'answer',
        'posts_per_page' => 10,
        'orderby' => 'date',
        'paged' => $paged,
        'post_status' => 'publish',
    );
    // }
    # Load the posts
    query_posts($arg);
    get_template_part('top_verification_loop');

    exit;
}
add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate'); // for logged in user
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate'); // if user not logged in

function wp_load_infinitescroll_js()
{
    ?>
    <script type="text/javascript">
 jQuery(document).ready(function($) {
   var count = 1;
   var total = 100;
   $(window).scroll(function(){
     if ($(window).scrollTop() == $(document).height() - $(window).height()){
      if (count > total){
        return false;
      }else{
        loadArticle(count);
      }
      count++;
     }
   });

   function loadArticle(pageNumber){
     $('a#inifiniteLoader').show('fast');
     $.ajax({
       url: "<?php echo admin_url(); ?>admin-ajax.php",
       type:'POST',
       data: "action=infinite_scroll&page_no="+ pageNumber + '&loop_file=top_verification_loop',
       success: function (html) {
        $('#infinite-scroll-loading').remove();
        $('li#inifiniteLoader').hide('1000');
        $("div.hot-verification-section").append(html);
       }
     });
     return false;
   }
 });
</script>
<?php
}
add_action('wp_footer', 'wp_load_infinitescroll_js');

function get_people_from_verification($verification_post)
{
    $prediction = get_post(wp_get_post_parent_id($verification_post));
    $cats = wp_get_post_terms($prediction->ID, 'question_category');
    $taxos = array_filter($cats, function ($v, $k) {
        return $v->category_parent == 0;
    }, ARRAY_FILTER_USE_BOTH);
    $people = $taxos[0];
    genesis_markup([
        'open' => sprintf("<div %s><a href=\"%s\">%s", genesis_attr('people-name'), "/questions/categories/" . $people->slug, $people->name),
        'close' => '</a></div>',
        'echo' => true,
    ]);
    //return $people->name;
}

function get_prediction_title_from_verification($verification_post)
{
    $prediction = get_post(wp_get_post_parent_id($verification_post));
    return $prediction->post_title;
}

function get_prediction_content_from_verification($verification_post)
{
    $prediction = get_post(wp_get_post_parent_id($verification_post));
    genesis_markup([
        'open' => sprintf("<div %s><a href=\"%s\">%s", genesis_attr('prediction-content'), "/questions/prediction/" . $prediction->post_name, $prediction->post_content),
        'close' => '</a></div>',
        'echo' => true,
    ]);
    //return $prediction->post_content;
}

function get_people_image_from_verification($verification_post)
{
    $prediction = get_post(wp_get_post_parent_id($verification_post));
    $cats = wp_get_post_terms($prediction->ID, 'question_category');
    $taxos = array_filter($cats, function ($v, $k) {
        return $v->category_parent == 0;
    }, ARRAY_FILTER_USE_BOTH);
    $people = $taxos[0];
    $cat_image = get_term_meta($people->term_id, 'ap_category', true);
    $cat_image = wp_parse_args(
        $cat_image, array(
            'image' => [
                'url' => '',
            ],
        )
    );
    genesis_markup([
        'open' => sprintf("<div %s><a href=\"%s\">", genesis_attr('people-pic'), "/questions/categories/" . $people->slug),
        'echo' => true,
    ]);

    genesis_markup([
        'open' => sprintf('<img src="%s" alt="%s">', $cat_image['image']['url'], $people->name),
        'close' => '</img>',
        'echo' => true,
    ]);

    genesis_markup([
        'close' => '</a></div>',
        'echo' => true,
    ]);
}

function get_verification_trueorfalse_from_verification($verification_post)
{
    $verification_trueorfalse = get_post_meta($verification_post->ID, 'trueorfalse');
    if (count($verification_trueorfalse) != 1) {
        return "Amber";
    }
    $verification_trueorfalse = $verification_trueorfalse[0];
    return ucwords($verification_trueorfalse);
}

add_action('wp_footer', 'genesis_bottom_menu', 13);
function genesis_bottom_menu()
{
    $header_open = genesis_markup(
        [
            'open' => sprintf("<div %s>", genesis_attr('bottom-menu')),
            'context' => 'bottom-menu',
            'echo' => true,
        ]
    );

    $header_close = genesis_markup(
        [
            'close' => '</div>',
            'context' => 'bottom-menu',
            'echo' => true,
        ]
    );

    //return $header_open . $categorie_headers . $header_close;
}