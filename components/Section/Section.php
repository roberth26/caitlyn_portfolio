<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Section extends AbstractComponent {
	function __construct() {
		// set the default props
		$this->set_default_props( array(
			post => new stdClass(), // empty object
			index => 0,
			route => ''
		));
	}
	function render( $props ) { ?>
		<section
			id="<?= $props[ 'route' ] ?>"
			data-index="<?= $props[ 'index' ] ?>"
			style="height:100vh">
				<h1><?= $props[ 'post' ]->post_title ?></h1>
				<p><?= apply_filters( 'the_content', $props[ 'post' ]->post_content ) ?></p>
		</section>
	<?php }
}
?>