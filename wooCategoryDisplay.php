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
			echo '<div style="display:inline-block;padding-right:10px;width:225px;vertical-align:top;padding-bottom:20px;" class="categoryDisplayItem ' . ($category->parent != 0 ? 'child ' . $category->parent : '') . '"><center><img style="display:block;width:225px;height:225px!important;object-fit:cover;" src="' . (getCategoryThumbnail($category->term_taxonomy_id) ? getCategoryThumbnail($category->term_taxonomy_id) : plugins_url() . '/wooCategoryDisplay/noImageAvailable.png') . '"/></center>';
			echo '<span class="info" style="display:none;">' . isParent($categories, $category->term_taxonomy_id) . ', ' . $category->term_taxonomy_id . '</span>';
			echo '<center><a href="/index.php/product-category/' . parentSlug($categories, $category->term_taxonomy_id) . '/' . $category->slug . '"><h3>' . $category->name . '</h3></a></center></div>';
      if (isParent($categories, $Category->term_taxonomy_id)) {
        echo '<div style="display:inline-block;padding-right:10px;width:225px;vertical-align:top;padding-bottom:20px;" class="back categoryDisplayItem ' . 'child ' . $category->term_taxonomy_id . '"><center><img style="display:block;width:225px;height:225px!important;object-fit:cover;" src="' . (plugins_url() . '/wooCategoryDisplay/backButton.png') . '"/></center>';
        echo '<center><a href="' . $_SERVER['REQUEST_URI'] . '"><h3>Go Back</h3></a></center></div>';
      }
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

function parentSlug($categories, $id) {
	$parent = 0;
	foreach ($categories as $category) {
		if ($id == $category->term_taxonomy_id && $id != 0) {
			$parent = $category->parent;
			break;
		}
	}
	foreach ($categories as $category) {
		if ($parent == $category->term_taxonomy_id && $parent != 0) {
			return $category->slug;
		}
	}
	return '';
}

function getCategoryThumbnail($categoryId) {
	$thumbnail_id = get_woocommerce_term_meta( $categoryId, 'thumbnail_id', true );
	return wp_get_attachment_url($thumbnail_id);
}

add_shortcode('displayProductCategories', 'displayProductCategories');
