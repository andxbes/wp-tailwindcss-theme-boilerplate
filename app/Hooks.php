<?php

namespace WpTailwindCssThemeBoilerplate;

class Hooks
{
    public function __construct()
    {
        //Те которые должны отработать до setup_theme
        add_filter('style_loader_src', [$this, 'rem_wp_ver_css_js'], 9999);
        add_filter('script_loader_src', [$this, 'rem_wp_ver_css_js'], 9999);
        add_filter('script_loader_tag', [$this, 'add_script_attributes'], 99, 3);
        add_filter('woocommerce_queued_js', [$this, 'woocommerce_queued_js']);

        // Полностью убираем версию WordPress
        add_filter('the_generator', '__return_empty_string');
        add_filter('emoji_svg_url', '__return_empty_string');
        //Удаляем простановку абзацев из знаков переносов
        remove_filter('the_content', 'wpautop');
        //        remove_filter( 'widget_text_content', 'wpautop' );
//        remove_filter( 'the_excerpt', 'wpautop' );

        //Добавляем и сохраняем дополнительное поле для иконок в меню
        add_action('wp_update_nav_menu_item', [$this, 'save_menu_item_icon'], 10, 3);
        add_action('wp_nav_menu_item_custom_fields', [$this, 'menu_item_icon'], 10, 2);
        add_filter('widget_nav_menu_args', [$this, 'widget_nav_menu_args']);

        add_action('customize_register', [$this, 'customizer_options']);
        add_action('wp_footer', [$this, 'print_metrics']);
        add_action('wp_footer', [$this, 'register_modal']);


        //Никогда не срабатывал , думаю потому что только после этого хука подключаются functions.php
//        add_action('setup_theme', [$this, 'setup_theme']);
        add_action('after_setup_theme', [$this, 'after_setup_theme']);

        //Обработка шорткодов в разделах
        add_filter('term_description', 'shortcode_unautop');
        add_filter('term_description', 'do_shortcode');

        //TODO Пересмотреть позже , какие из ниже хуков можно перенести в setup_theme


        add_action('widgets_init', [$this, 'register_sidebars']);
        add_filter('wpseo_sitemap_entries_per_page', [$this, 'wpseo_sitemap_entries_per_page']);
        add_filter('render_block_core/shortcode', [$this, 'remove_autotop_inchortcodes'], 10, 2);
        add_filter('register_block_type_args', [$this, 'change_settings_for_blocks'], 10, 2);

        add_action('pre_get_posts', [$this, 'pre_get_posts']);
        add_filter('post_class', [$this, 'add_to_post_class_detect_gutenberg'], 10, 3);

        add_filter('wpseo_breadcrumb_output_wrapper', [$this, 'breadcrumb_output_wrapper']);
        add_filter('wpseo_breadcrumb_single_link_wrapper', [$this, 'breadcrumb_single_link_wrapper']);
        add_filter('wpseo_breadcrumb_separator', [$this, 'wpseo_breadcrumb_separator']);


    }



    public function breadcrumb_output_wrapper($wrapper)
    {
        $wrapper = 'ul';
        return $wrapper;
    }

    public function breadcrumb_single_link_wrapper($wrapper)
    {
        $wrapper = 'li';
        return $wrapper;
    }

    public function wpseo_breadcrumb_separator($breadcrumbs_sep)
    {
        return '<span class="ept-page-breadcrumb-divider">-</span>';
    }


    public function after_setup_theme()
    {
        add_filter('embed_oembed_html', [$this, 'embed_wrapper'], 10, 4);

        add_filter('widget_posts_args', [$this, 'change_params_widget_posts_args'], 10, 2);
        /* уборка хедера от мусора */
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        // Disable oEmbed Discovery Links
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        // Disable REST API link in HTTP headers
        remove_action('template_redirect', 'rest_output_link_header', 11, 0);


        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
        remove_action('template_redirect', 'wp_shortlink_header', 11);
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'parent_post_rel_link', 10, 0);
        remove_action('wp_head', 'start_post_rel_link', 10, 0);
        remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        remove_action('wp_head', 'wp_generator'); //убираем версию wp
        remove_action('wp_head', 'rel_canonical');
        // Отключаем вывод ссылок в header
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');

        //
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
        load_theme_textdomain('theme', get_template_directory() . '/languages');

        /*
         * Let WordPress manage the document title.
         * This theme does not use a hard-coded <title> tag in the document head,
         * WordPress will provide it for us.
         */
        add_theme_support('title-tag');
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        /**
         * Add post-formats support.
         */
        add_theme_support(
            'post-formats',
            array(
                'link',
                'aside',
                'gallery',
                'image',
                'quote',
                'status',
                'video',
                'audio',
                'chat',
            )
        );
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
                'navigation-widgets',
            )
        );

        register_nav_menus(
            array(
                'header_top' => esc_html__('Header top menu', 'theme'),
                'primary_left' => esc_html__('Primary left menu', 'theme'),
                'primary_right' => esc_html__('Primary right menu', 'theme'),

                'footer_1' => __('Footer menu column 1', 'theme'),
                'footer_2' => __('Footer menu column 2', 'theme'),
                'copyright' => __('Footer copyright', 'theme'),
            )
        );

        add_theme_support('align-wide'); // Add align full or theme.json add layout: contentSize and wideSize
        add_theme_support('editor-styles'); // включает поддержку
        add_theme_support('dark-editor-style');
        add_theme_support('wp-block-styles');

        add_editor_style('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');
        //        error_log(AssetResolver::resolve( 'css/app.css' ));
//        add_editor_style(AssetResolver::resolve( 'css/app.css' ));
//        add_editor_style( 'style-editor.css' );

        add_editor_style('/build/css/admin.css');

        // add_theme_support('woocommerce');
        // add_filter('woocommerce_product_get_dimensions', '__return_false');
        // add_filter('woocommerce_enqueue_styles', '__return_false');



        //YOAST отключаем лишнюю микроразметку
        $schemas = [
            'organization',
            'person',
            //            'website',
            'main_image',
            'webpage',
            //            'breadcrumb',
            'article',
            'author',
            'faq',
            'howto',
        ];
        foreach ($schemas as $schema) {
            add_filter('wpseo_schema_needs_' . $schema, '__return_false', 20);
        }

        add_action('init', [$this, 'init']);
        add_action('init', [$this, 'register_block_styles']);

        add_action('get_header', [$this, 'get_header'], 10, 2);

        add_filter('wpseo_breadcrumb_single_link', [$this, 'wpseo_breadcrumb_single_link'], 10, 2);

        add_action('get_header', [$this, 'canonical_redirect']);

        add_filter('do_shortcode_tag', [$this, 'do_shortcode_tag'], 99, 4);
    }

    public function init()
    {
        /**
         * Отключаем emoji's
         */
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        //        add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');


    }

    //$tag = apply_filters( 'script_loader_tag', $tag, $handle, $src );

    public function add_script_attributes($tag, $handle, $src)
    {
        if (!is_admin()) {
            $type = 'defer';
            //            if(in_array($handle,['stripe'])){
//                $type='async';
//            }

            $tag = str_replace('id=', $type . ' id=', $tag);
        }
        return $tag;
    }

    // Удаление параметра ver из добавляемых скриптов и стилей(прячем версию WP)
    public function rem_wp_ver_css_js($src)
    {
        if (strpos($src, 'ver='))
            $src = remove_query_arg('ver', $src);
        return $src;
    }

    public function woocommerce_queued_js($js)
    {
        //Откладываем Выполнение woo скриптов, требующих jquery, до загрузки контента , как и самого jQuery c defer
        if (str_contains($js, 'jQuery')) {
            $js = preg_replace('%<script[^>]*>(.*)<\/script>%s', '<script>window.addEventListener(\'DOMContentLoaded\', (event) => { $1; });</script>', $js);
        }
        return $js;
    }

    public function customizer_options($customizer)
    {
        $customizer->add_section(
            'section_one',
            array(
                'title' => 'Site preferences',
                'description' => '',
                'priority' => 11,
            )
        );
        $customizer->add_setting('phone', array('default' => '+1 999-999-9999'));
        $customizer->add_control(
            'phone',
            array(
                'label' => 'Phone',
                'section' => 'section_one',
                'type' => 'text',
            )
        );

        $customizer->add_setting('email', array('default' => 'info@example.com'));
        $customizer->add_control(
            'email',
            array(
                'label' => 'Email',
                'section' => 'section_one',
                'type' => 'text',
            )
        );

        $customizer->add_setting('address', array('default' => '13A West End Ave, Brooklyn, NY 11999, US'));
        $customizer->add_control(
            'address',
            array(
                'label' => 'Address',
                'section' => 'section_one',
                'type' => 'textarea',
            )
        );

        $customizer->add_setting('metrics', array('default' => ''));
        $customizer->add_control(
            'metrics',
            array(
                'label' => 'Metrics or analytics scripts',
                'section' => 'section_one',
                'type' => 'textarea',
            )
        );

        $customizer->add_setting('map', array('default' => ''));
        $customizer->add_control(
            'map',
            array(
                'label' => 'Map',
                'section' => 'section_one',
                'type' => 'textarea',
            )
        );

        $customizer->add_setting('copyright_text', array('default' => 'All Rights Reserved © SiteName'));
        $customizer->add_control(
            'copyright_text',
            array(
                'label' => 'Copyright',
                'section' => 'section_one',
                'type' => 'textarea',
            )
        );

        $customizer->add_setting('logo2');
        $customizer->add_control(
            new \WP_Customize_Image_Control(
                $customizer,
                'logo2',
                array(
                    'label' => 'Logo',
                    'section' => 'section_one',
                    'settings' => 'logo2',
                )
            )
        );

    }

    public function print_metrics()
    {
        print get_theme_mod('metrics', '');
    }

    public function save_menu_item_icon($menu_id, $menu_item_db_id, $args)
    {
        if (isset($_POST['menu_item_icon'][$menu_item_db_id])) {
            $data = trim(wp_check_invalid_utf8($_POST['menu_item_icon'][$menu_item_db_id]));
            //        $data = preg_replace('/[\r\n\t ]+/', ' ', $data);
            update_post_meta($menu_item_db_id, '_menu_item_icon', $data);
        } else {
            delete_post_meta($menu_item_db_id, '_menu_item_icon');
        }

    }

    public static function wpseo_sitemap_entries_per_page($entries)
    {
        $entries = 100;
        return $entries;
    }

    public function menu_item_icon($item_id, $item)
    {
        $menu_item_icon = get_post_meta($item_id, '_menu_item_icon', true);
        ?>
        <div style="clear: both;">
            <span class="description">
                <?= __("Item icons <a href='https://heroicons.com/'>see here</a>", 'theme'); ?>
            </span><br />
            <input type="hidden" class="nav-menu-id" value="<?php echo $item_id; ?>" />
            <div class="logged-input-holder">
                <textarea class="widefat " rows="3" cols="20" name="menu_item_icon[<?= $item_id; ?>]"
                    id="menu-item-desc-<?= $item_id; ?>"><?= ($menu_item_icon); ?></textarea>
            </div>
        </div>
        <?php
    }

    public function register_sidebars()
    {
        /* Register the 'primary' sidebar. */

        register_sidebar(
            array(
                'id' => 'sidebar',
                'name' => __('Sidebar', 'theme'),
                'description' => __('Sidebar for posts', 'theme'),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<p class="widget-title">',
                'after_title' => '</p>',
            )
        );

        register_sidebar(
            array(
                'id' => 'products',
                'name' => __('Addition content for Products', 'theme'),
                'description' => __('Additional content on the product page', 'theme'),
                'before_widget' => '<div id="%1$s" class="widget widget--full-w %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<p class="widget-title">',
                'after_title' => '</p>',
            )
        );
    }

    /**
    Меняем волкер для всех меню выводимых через виджет меню
    **/
    public function widget_nav_menu_args($args)
    {
        if (!is_admin()) { //чтобы в админке, в предосмотре виджетов, не ломался вывод.
            $args['items_wrap'] = '<div class="sidebar-menu"><ul x-data="accordions($el)" class="%2$s">%3$s</ul></div>';
            $args['walker'] = new \WpTailwindCssThemeBoilerplate\Walkers\Accordions_Walker();
        }
        return $args;
    }

    /***
    fixed render
    function render_block_core_shortcode( $attributes, $content ) {
    return wpautop( $content );
    }
    ***/
    public function remove_autotop_inchortcodes($parsed_block, $source_block)
    {
        $parsed_block = shortcode_unautop($parsed_block);
        return $parsed_block;
    }


    public function change_settings_for_blocks($settings, $name)
    {
        ////Это топорный вариант добавить опции в блок картинки
//        if (!empty($name) && $name == 'core/image') {
////            error_log(print_r($settings,true));
//            if (!empty($settings['styles']) && is_array($settings['styles'])) {
//                $settings['styles'][] = [
//                    'name' => 'rounded-gray-with-p',
//                    'label' => 'Rounded gray with padding'
//                ];
//            }
//        }
        return $settings;
    }
    //Или

    public function register_block_styles()
    {
        //Это более правильный вариант добавить опции в блок картинки
        register_block_style(
            'core/image',
            [
                'name' => 'rounded-l-blue-with-p',
                'label' => 'Rounded bg. Blue with padding',
                'inline_style' => '',
            ]
        );
    }



    public function pre_get_posts($query)
    {
        if (!is_admin() && $query->is_main_query()) { //чтобы не трогать админку , и генерацию меню .
            if (is_archive()) {
                //$query->set('posts_per_page', 8);
            }
        }
    }

    public function add_to_post_class_detect_gutenberg($classes, $class, $post_id)
    {
        if (!empty($post_id) && has_blocks($post_id)) {
            $editor = 'gutenberg';
        } else {
            $editor = 'classic';
        }
        $classes[] = $editor;
        return $classes;
    }


    //Подстройка выборки для популярных постов
    public function change_params_widget_posts_args($args, $instance)
    {
        if (is_array($args)) {
            //$args['orderby'] = 'rand';
        }
        return $args;
    }


    public function embed_wrapper($html, $url, $attr, $post_ID)
    {
        $add_class = '';
        return sprintf('<div class="iframe-wrapper %1$s">%2$s</div>', $add_class, $html);
    }


    public function woocommerce_product_get_image($image, $product, $size, $attr, $placeholder, $image_def)
    {
        if (str_contains($image, '/wp-content/uploads/woocommerce-placeholder') && $placeholder) {
            //Стандарная обработка получения картинки, с небольшими изменениями
            $image = '';
            if ($product->get_image_id()) {
                $image = wp_get_attachment_image($product->get_image_id(), $size, false, $attr);
            } elseif ($product->get_parent_id()) {
                $parent_product = wc_get_product($product->get_parent_id());
                if ($parent_product) {
                    $product = $parent_product;
                    $image = $product->get_image($size, $attr, $placeholder);
                }
            }
            // -----------------------------------------------------------
            //Берем первую картинку из галереи, если нет основной картинки
            if (!$image) {
                $image_ids = $product->get_gallery_image_ids();
                if (!empty($image_ids)) {
                    $image_id = array_shift($image_ids);
                    $image = wp_get_attachment_image($image_id, $size, false, $attr);
                }
            }

            //стандартный плейсхолдер
            if (!$image && $placeholder) {
                $image = wc_placeholder_img($size, $attr);
            }
        }

        return $image;
    }


    public function register_modal()
    {
        get_template_part('templates/partials/modals');
    }

    //Для пордключения стилей к магазину 
    public function get_header($name, $args)
    {
        global $wp;
        if (isset($wp->query_vars['order-received'])) {
            set_query_var('hide_h_breadcrumb', true);
        }
        if ($name == 'shop') {
            if (is_singular('product')) {

            }
        }
    }

    public function wpseo_breadcrumb_single_link($link, $breadcrumb)
    {
        if (!empty($breadcrumb['text']) && is_string($breadcrumb['text'])) {
            $link = str_replace($breadcrumb['text'], "<span>{$breadcrumb['text']}</span>", $link);
        }
        return $link;
    }

    public function canonical_redirect()
    {
        global $wp;
        //global $wp_the_query;
        $current_url = trailingslashit($wp->request);

        if (
            is_singular('post')
            && has_term(null, 'category', get_the_ID())
        ) {
            //$canonical_url у yoast может быть пустым, если в админке не прописан руками.
//                $canonical_url = get_post_meta($wp_the_query->get_queried_object_id(), 'canonical_url', true);
            $canonical_url = '';
            try {
                $canonical_url = YoastSEO()->meta->for_current_page()->canonical;
            } catch (\Exception $ex) {
            }
            if (!empty($canonical_url) && stripos($canonical_url, $current_url) === false) {

                /**
                 * По факту из задачи сеошников, у нас больше нет страниц принадлежащих и другим разделам, только одна,
                 * остальные с редиректами, пока только для categories
                 * наш каноникал превращается в переадресацию для блога
                 **/
                wp_safe_redirect($canonical_url, 301, 'theme_seo_redirect');
                exit();
            }
        }
    }


    public function do_shortcode_tag($output, $tag, $attr, $m)
    {
        if (
            in_array($tag, [
                'recent_products',
                'products',
                'product',
                'sale_products',
                'best_selling_products',
                'top_rated_products',
                'featured_products',
                'product_categories',
                'product_attribute',
            ])
        ) {
            // В tailwind есть такой же класс columns-3 ... columns-6 как у woo,
            // но делает он немного иначе (masonry).
            // Потому колонки в шаблоне (loop/loop-start.php) указываем только у ul через w-columns,
            // а у родителей просто удаляем, так как нет смысла в дублях,
            // и мы не можем шаблонами подменить у классов \WC_Shortcode_Products и \WC_Shortcodes

            $regex = "%class=[\"']([^'\">]*(?:[^-])(columns-\d)[^'\">]*)[\"']%i";
            $output = preg_replace_callback(
                $regex,
                function ($matches) {
                    return str_replace($matches[2], '', $matches[0]);
                },
                $output
            );
        }
        return $output;
    }

}