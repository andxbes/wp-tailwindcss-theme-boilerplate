<?php
$hooks = new \WpTailwindCssThemeBoilerplate\Hooks();

function wptheme_get_template_part($slug, $name = null, $args = array())
{
    ob_start();
    get_template_part($slug, $name, $args);
    return ob_get_clean();
}