<?php
import( 'Page' );
import( 'Section' );

$pages = get_posts( array(
	post_type => 'page',
	orderby => 'menu_order',
	order => 'ASC'
));

$route = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$matched_route_index = 0;

if ( basename( $route ) ) {
	foreach ( $pages as $index => $page ) {
		$page->permalink = get_permalink( $page->ID );
		if ( $page->permalink == $route ) {
			$matched_route_index = $index;
			break;
		}
	}
}

$matched_route = $pages[ $matched_route_index ];
unset( $pages[ $matched_route_index ] );

render( 'Page', array(
	content => function() use ( $matched_route, $matched_route_index ) {
		render( 'Section', array(
			post => $matched_route,
			index => $matched_route_index,
			route => basename( $matched_route->permalink )
		));
	},
	matched_route_index => $matched_route_index,
	deferred => function() use ( $pages ) {
		foreach( $pages as $index => $page ) {
			render( 'Section', array(
				post => $page,
				index => $index,
				route => basename( $page->permalink )
			));
		}
	}
));
?>