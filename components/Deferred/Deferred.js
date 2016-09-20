(function() {
	var sections = document.getElementById( 'deferred-sections' );
	if ( !sections ) return;
	var route = location.pathname;
	console.log( route );
	if ( route.charAt( route.length - 1 ) == '/' )
		route = route.substring( 0, route.length - 1 );
	route = route.split(/[\\/]/).pop();
	var matched_route = document.getElementById( route );	
	sections = sections.content.querySelectorAll( '.deferred-item' );
	sections = Array.prototype.slice.call( sections );
	var fragment = document.createDocumentFragment();
	sections.push( matched_route.cloneNode( true ) );
	sections.sort( function( a, b ) {
		return a.dataset.index - b.dataset.index;
	}).forEach( function( section, index ) {
		fragment.appendChild( section );
	});
	matched_route.parentNode.replaceChild( fragment, matched_route );
	window.location.hash = route;
}());