<?php

/**
 * Google+ embeds
 */

define( 'JETPACK_GOOGLEPLUS_EMBED_REGEX', '#^https?://plus\.(sandbox\.)?google\.com/([^/]+)/posts/([^/]+)$#' );

// Example URL: https://plus.google.com/114986219448604314131/posts/LgHkesWCmJo 
wp_embed_register_handler( 'googleplus', JETPACK_GOOGLEPLUS_EMBED_REGEX, 'jetpack_googleplus_embed_handler' );

function jetpack_googleplus_embed_handler( $matches, $attr, $url ) {
	static $did_script;

	if ( ! $did_script ) {
		$did_script = true;
		add_action( 'wp_footer', 'jetpack_googleplus_add_script' ); 
	}

	return sprintf( '<div class="g-post" data-href="%s"></div>', esc_url( $url ) );
}

function jetpack_googleplus_add_script() {
	?>
	<script src="https://apis.google.com/js/plusone.js"></script>
	<?php
}

add_shortcode( 'googleplus', 'jetpack_googleplus_shortcode_handler' );

function jetpack_googleplus_shortcode_handler( $atts ) {
	global $wp_embed;

	if ( empty( $atts['url'] ) )
		return;

	if ( ! preg_match( JETPACK_GOOGLEPLUS_EMBED_REGEX, $atts['url'] ) ) 
		return;

	return $wp_embed->shortcode( $atts, $atts['url'] );
}