<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Deferred extends AbstractComponent {
	function __construct() {
		// set the default props
		$this->set_default_props( array(
			content => function() {}
		));
	}
	function add_class( $item_fn ) {
		ob_start();
		call_user_func( $item_fn );
		$item_html = ob_get_contents();
		ob_end_clean();
		$item_html = simplexml_load_string( $item_html );
		$item_html = dom_import_simplexml( $item_html );
		$class = $item_html->getAttribute( 'class' );
		$item_html->setAttribute( 'class', $class . ' deferred-item' );
		echo $item_html->ownerDocument->saveXML( $item_html->ownerDocument->documentElement );
	}
	function render( $props ) { ?>
		<template id="deferred-sections">
			<?php
				foreach( $props[ 'items' ] as $index => $item ) {
					$this->add_class( $item );
				}
			?>
		</template>
	<?php }
}
?>