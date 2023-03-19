<?php

use WpTailwindCssThemeBoilerplate\AssetResolver;

add_action('wp_enqueue_scripts', function () {

	// registers scripts and stylesheets
	wp_register_style('app', AssetResolver::resolve('css/app.css'), [], false);
	wp_register_script('app', AssetResolver::resolve('js/app.js'), [], false, true);

	// enqueue global assets
	wp_enqueue_script('jquery');
	wp_enqueue_style('app');
	wp_enqueue_script('app');

});


function theme_enqueue_style(string $name)
{
	if (!empty($name)) {
		$name = trim($name, '/');
		$handle = preg_replace("%[\s\W]%", '-', $name);

		//        if(is_admin()){
		//            add_editor_style('/build/css/components/' . $name . '.css');
		//        }else{
		wp_enqueue_style('theme_' . $handle, AssetResolver::resolve('css/components/' . $name . '.css'));
		//        }
	}
}