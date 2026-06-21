<?php
/**
 * OCA Nav Walker — adds sub-menu support and ARIA attributes.
 */
class OCA_Nav_Walker extends Walker_Nav_Menu {

  public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
    $item   = $data_object;
    $indent = str_repeat( "\t", $depth );

    $classes   = empty( $item->classes ) ? [] : (array) $item->classes;
    $classes[] = 'menu-item-' . $item->ID;
    $class_str = implode( ' ', array_filter( $classes ) );

    $atts = [];
    $atts['href']  = ! empty( $item->url ) ? $item->url : '#';
    $atts['title'] = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target']= ! empty( $item->target ) ? $item->target : '';

    if ( in_array( 'menu-item-has-children', $classes ) ) {
      $atts['aria-haspopup'] = 'true';
      $atts['aria-expanded'] = 'false';
    }

    $attr_str = '';
    foreach ( $atts as $attr => $val ) {
      if ( ! empty( $val ) ) {
        $attr_str .= ' ' . $attr . '="' . esc_attr( $val ) . '"';
      }
    }

    $title = apply_filters( 'the_title', $item->title, $item->ID );

    $output .= $indent . '<li class="' . esc_attr( $class_str ) . '">';
    $output .= '<a' . $attr_str . '>' . esc_html( $title ) . '</a>';
  }
}
