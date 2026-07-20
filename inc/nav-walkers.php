<?php
/**
 * Walkers de menu — reproduisent la structure de la maquette
 * tout en rendant le menu 100 % gérable dans Apparence › Menus.
 *
 * @package KPIBI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Menu de navigation (bureau) : les éléments parents deviennent des menus déroulants.
 */
class KPIBI_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="nav-dropdown-menu" role="menu">';
	}

	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$title        = apply_filters( 'the_title', $item->title, $item->ID );
		$url          = ! empty( $item->url ) ? $item->url : '#';

		if ( 0 === $depth ) {
			if ( $has_children ) {
				$output .= '<li class="nav-dropdown">';
				$output .= '<button class="nav-dropdown-trigger" aria-haspopup="true" aria-expanded="false">' . esc_html( $title );
				$output .= ' <svg class="nav-chevron" viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>';
				$output .= '</button>';
			} else {
				$output .= '<li>';
				$output .= '<a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a>';
			}
		} else {
			$output .= '<li role="none">';
			$output .= '<a href="' . esc_url( $url ) . '" role="menuitem">' . esc_html( $title ) . '</a>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * Menu mobile : parents = libellés de groupe, enfants = liens « sub ».
 */
class KPIBI_Mobile_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$title        = apply_filters( 'the_title', $item->title, $item->ID );
		$url          = ! empty( $item->url ) ? $item->url : '#';

		if ( 0 === $depth ) {
			if ( $has_children ) {
				$output .= '<p class="mobile-menu-group">' . esc_html( $title ) . '</p>';
			} else {
				$output .= '<a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a>';
			}
		} else {
			$output .= '<a href="' . esc_url( $url ) . '" class="sub">' . esc_html( $title ) . '</a>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}
