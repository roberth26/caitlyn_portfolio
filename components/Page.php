<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Page extends AbstractComponent {
	function __construct() {
		// set the default props
		$this->set_default_props( array(
			title => 'Page Title',
			content => function() {},
			deferred => ''
		));
	}
	function render( $props ) { ?>
		<!doctype html>
		<html>
			<head>
			    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
			    <title><?php echo $props[ 'title' ]; ?></title>
			    <?php wp_head(); ?>
			</head>
			<body <?php body_class(); ?>>
				<?php render( 'Header', array(
					'menu_items' => $props[ 'menu_items' ],
					'current_page_id' => $props[ 'current_page_id' ]
				)); ?>
				<?php call_user_func( $props[ 'content' ] ); ?>
				<?php render( 'Footer', array(
					'menu_items' => $props[ 'menu_items' ],
					'social_menu_items' => $props[ 'social_menu_items' ],
					'current_page_id' => $props[ 'current_page_id' ]
				)); ?>
				<template id="deferred-sections">
					<?php call_user_func( $props[ 'deferred' ] ); ?>
				</template>
				<script>
					(function() {
						var route = location.pathname;
						if ( route.charAt( route.length - 1 ) == '/' )
							route = route.substring( 0, route.length - 1 );
						route = route.split(/[\\/]/).pop();
						var matched_route = document.getElementById( route );
						var sections = document.getElementById( 'deferred-sections' );
						sections = sections.content.querySelectorAll( 'section' );
						sections = Array.prototype.slice.call( sections );
						var fragment = document.createDocumentFragment();
						sections.push( matched_route.cloneNode( true ) );
						sections.sort( function( a, b ) {
							return a.dataset.index - b.dataset.index;
						}).forEach( function( section, index ) {
							fragment.appendChild( section );
						});
						window.location.hash = route;
						matched_route.parentNode.replaceChild( fragment, matched_route );

					}());
				</script>
				<?php wp_footer(); ?>
				<?php /*
				<script>
					(function( $ ) {						
						var $deferred_sections = $( <?= json_encode( $props[ 'deferred' ] ) ?> );
						var $matched_route = $( '#matched-route' ); // shouldn't be in this component...
						$deferred_sections.add( $matched_route );
						$matched_route.replaceWith(
							$deferred_sections.get().sort( function( a, b ) {
								return $( a ).data( 'index' ) - $( b ).data( 'index' );
							})
						);
					}( jQuery ));
				</script>
				*/ ?>
			</body>
		</html>
	<?php }
}
?>