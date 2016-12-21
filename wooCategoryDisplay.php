<?php
/**
 * Plugin Name: Woo Category Display
 * Plugin URI: http://captaincybertech.com
 * Description: This plugin adds shortcode for category display
 * Version: 1.0.0
 * Author: Captain Cyber
 * Author URI: http://captaincybertech.com
 * License: MIT
 */

wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.1.1.min.js');
wp_enqueue_script('wooCategoryDisplay', plugins_url() . '/wooCategoryDisplay/wooCategoryDisplay.js', array('jquery'));

function displayProductCategories() {
	$categories = get_terms('product_cat');

	// echo "<pre>";
	// var_dump($categories);
	// echo "</pre>";

	echo '<div class="categoryDisplay" style="padding-top: 40px;">';
	foreach ($categories as $category) {
			echo '<div style="display:inline-block;padding-right:10px; width:250px;vertical-align:top;" class="categoryDisplayItem ' . ($category->parent != 0 ? 'child ' . $category->parent : '') . '"><center><img style="display:block;width:250px;height:250px!important;object-fit:cover;" src="' . (getCategoryThumbnail($category->term_taxonomy_id) ? getCategoryThumbnail($category->term_taxonomy_id) : plugins_url() . '/wooCategoryDisplay/noImageAvailable.png') . '"/></center>';
			echo '<span class="info" style="display:none;">' . isParent($categories, $category->term_taxonomy_id) . ', ' . $category->term_taxonomy_id . '</span>';
			echo '<center><span style="display:none;" class="idOfCategory">' . $category->term_taxonomy_id . '</span><a href="/index.php/product-category/' . $category->slug . '"><h3>' . $category->name . '</h3></a></center></div>';
	}
	echo '</div>';
}

function isParent($categories, $id) {
	foreach ($categories as $category) {
		if ($category->parent == $id) {
			return true;
			break;
		}
	}
	return false;
}

function getCategoryThumbnail($categoryId) {
	$thumbnail_id = get_woocommerce_term_meta( $categoryId, 'thumbnail_id', true );
	return wp_get_attachment_url($thumbnail_id);
}

add_shortcode('displayProductCategories', 'displayProductCategories');
