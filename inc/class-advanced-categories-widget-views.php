<?php

/**
 * Advanced_Categories_Widget_Views Class
 *
 * Handles generation of all front-facing html.
 * All methods are static, this is basically a namespacing class wrapper.
 *
 * @package Advanced_Categories_Widget
 * @subpackage Advanced_Categories_Widget_Views
 *
 * @since 1.0
 */


class Advanced_Categories_Widget_Views
{

	private function __construct(){}


	/**
	 * Opens the post list for the current Categories widget instance.
	 *
	 * Use 'advcatswdgt_post_list_class' filter to filter list classes before output.
	 * Use 'advcatswdgt_start_list' filter to filter $html before output.
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Settings for the current Categories widget instance.
	 * @param object $query    WP_Query object.
	 * @param bool   $echo     Flag to echo or return the method's output.
	 *
	 * @return string $html Opening tag element for the post list.
	 */
	public static function start_list( $instance, $query, $echo = true )
	{
		$tag = 'ul';

		switch ( $instance['list_style'] ) {
			case 'div':
				$tag = 'div';
				break;
			case 'ol':
				$tag = 'ol';
				break;
			case 'ul':
			default:
				$tag = 'ul';
				break;
		}

		$_classes = array();
		$_classes[] = 'acatsw-posts-list';
		$_classes[] = ( 'html5' === $instance['item_format'] ) ? 'html5' : 'xhtml';

		$classes = apply_filters( 'advcatswdgt_post_list_class', $_classes, $instance, $query );
		$classes = ( ! is_array( $classes ) ) ? (array) $classes : $classes ;
		$classes = array_map( 'sanitize_html_class', $classes );

		$class_str = implode( ' ', $classes );

		$_html = sprintf( '<%1$s class="%2$s">',
			$tag,
			$class_str
			);

		$html = apply_filters( 'advcatswdgt_start_list', $_html, $instance, $query );

		if( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}


	/**
	 * Opens the list item for the current Categories widget instance.
	 *
	 * Use 'advcatswdgt_start_list_item' filter to filter $html before output.
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Settings for the current Categories widget instance.
	 * @param object $query    WP_Query object.
	 * @param bool   $echo     Flag to echo or return the method's output.
	 *
	 * @return string $html Opening tag element for the list item.
	 */
	public static function start_list_item( $instance, $query, $echo = true )
	{
		$advcatswdgt_post       = get_post();
		$advcatswdgt_post_id    = Advanced_Categories_Widget_Utils::get_advcatswdgt_post_id( $advcatswdgt_post, $instance );
		$advcatswdgt_post_class = Advanced_Categories_Widget_Utils::get_advcatswdgt_post_class( $advcatswdgt_post, $instance );
		$class = 'acatsw-list-item ' . $advcatswdgt_post_class;

		$tag = ( 'div' === $instance['list_style'] ) ? 'div' : 'li';

		$_html = sprintf( '<%1$s id="%2$s" class="%3$s">',
			$tag,
			$advcatswdgt_post_id,
			$class
			);

		$html = apply_filters( 'advcatswdgt_start_list_item', $_html, $instance, $query );

		if( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}


	/**
	 * Closes the list item for the current Categories widget instance.
	 *
	 * Use 'advcatswdgt_end_list_item' filter to filter $html before output.
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Settings for the current Categories widget instance.
	 * @param object $query    WP_Query object.
	 * @param bool   $echo     Flag to echo or return the method's output.
	 *
	 * @return string $html Closing tag element for the list item.
	 */
	public static function end_list_item( $instance, $query, $echo = true )
	{
		$tag = ( 'div' === $instance['list_style'] ) ? 'div' : 'li';

		$_html = sprintf( '</%1$s>', $tag );

		$html = apply_filters( 'advcatswdgt_end_list_item', $_html, $instance, $query );

		if( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}


	/**
	 * Closes the post list for the current Categories widget instance.
	 *
	 * Use 'advcatswdgt_end_list' filter to filter $html before output.
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Settings for the current Categories widget instance.
	 * @param object $query    WP_Query object.
	 * @param bool   $echo     Flag to echo or return the method's output.
	 *
	 * @return string $html Closing tag element for the post list.
	 */
	public static function end_list( $instance, $query, $echo = true )
	{
		$_html = '';

		switch ( $instance['list_style'] ) {
			case 'div':
				$_html = "</div>\n";
				break;
			case 'ol':
				$_html = "</ol>\n";
				break;
			case 'ul':
			default:
				$_html = "</ul>\n";
				break;
		}

		$html = apply_filters( 'advcatswdgt_end_list', $_html, $instance, $query );

		if( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}


	/**
	 * Outputs plugin attribution
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string Plugin attribution.
	 */
	public static function colophon( $echo = true )
	{
		$attribution = '<!-- Advanced Categories Widget generated by http://darrinb.com/plugins/advanced-posts-widget -->';

		if ( $echo ) {
			echo $attribution;
		} else {
			return $attribution;
		}
	}


	/**
	 * Builds html for thumbnail section of post
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param object $post     Post object.
	 * @param array  $instance Settings for the current Categories widget instance.
	 * @param bool   $echo     Flag to echo or return the method's output.
	 *
	 * @return string $html Post thumbnail section.
	 */
	public static function advcatswdgt_post_thumbnail( $post = 0, $instance = array(), $echo = true )
	{
		$_post = get_post( $post );

		if ( empty( $_post ) ) {
			return '';
		}

		$_html = '';
		$_thumb = Advanced_Categories_Widget_Utils::get_advcatswdgt_post_thumbnail( $_post, $instance );

		$_classes = array();
		$_classes[] = 'acatsw-post-thumbnail';
		
		$classes = apply_filters( 'advcatswdgt_thumbnail_div_class', $_classes, $instance, $_post );
		$classes = ( ! is_array( $classes ) ) ? (array) $classes : $classes ;
		$classes = array_map( 'sanitize_html_class', $classes );

		$class_str = implode( ' ', $classes );

		if( '' !== $_thumb ) {

			$_html .= sprintf('<span class="%1$s">%2$s</span>',
				$class_str,
				sprintf('<a href="%s">%s</a>',
					esc_url( get_permalink( $_post ) ),
					$_thumb
				)
			);

		};

		$html = apply_filters( 'advcatswdgt_post_thumbnail', $_html, $_post, $instance );

		if( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}
	
	
	
	/**
	 * Builds html for post date section
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param object $post     Post object.
	 * @param array  $instance Settings for the current Categories widget instance.
	 * @param bool   $echo     Flag to echo or return the method's output.
	 *
	 * @return string $html Post thumbnail section.
	 */
	public static function advcatswdgt_posted_on( $post = 0, $instance = array(), $echo = true )
	{
		$_post = get_post( $post );

		if ( empty( $_post ) ) {
			return '';
		}

		$_html = '';
		
		$time_string = '<time pubdate class="entry-date acatsw-entry-date published updated" datetime="%1$s">%2$s</time>';
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			Advanced_Categories_Widget_Utils::get_advcatswdgt_post_date( $_post, $instance )
		);

		$_html = sprintf( '<span class="posted-on acatsw-posted-on post-date"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.' ),
			esc_url( get_permalink() ),
			$time_string
		);
		
		$html = apply_filters( 'advcatswdgt_posted_on', $_html, $_post, $instance );
		
		if( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}

}
