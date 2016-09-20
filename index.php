<?php
import( 'Page' );
import( 'Section' );
import( 'Deferred' );

$pages = get_posts( array(
	post_type => 'page',
	orderby => 'menu_order',
	order => 'ASC'
));

$route = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$matched_route_index = 0;
$index_route = true;

foreach ( $pages as $index => $page ) {
	$page->permalink = get_permalink( $page->ID );
	if ( $page->permalink == $route ) {
		$index_route = false;
		$matched_route_index = $index;
		break;
	}
}

$matched_route = $pages[ $matched_route_index ];
unset( $pages[ $matched_route_index ] );

render( 'Page', array(
	content => function() use ( $matched_route, $matched_route_index, $pages, $index_route ) {
		render( 'Section', array(
			post => $matched_route,
			index => $matched_route_index,
			route => basename( $matched_route->permalink )
		));
		if ( $index_route ) {
			foreach ( $pages as $index => $page ) {
				render( 'Section', array(
					post => $page,
					index => $index,
					route => basename( $page->permalink )
				));
			}
		} else {
			render( 'Deferred', array(
				items => array_map( function( $page, $index ) {
					return function() use ( $page, $index ) {
						render( 'Section', array(
							post => $page,
							index => $index,
							route => basename( $page->permalink )
						));
					};
				}, $pages, array_keys( $pages ) )
			));
		}
	}
));
?>