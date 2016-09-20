<?php
require_once( get_component_directory() . '/AbstractComponent.php' );

class Page extends AbstractComponent {
	function __construct() {
		// set the default props
		$this->set_default_props( array(
			title => 'Page Title',
			content => function() {}
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
				<?php call_user_func( $props[ 'content' ] ); ?>
				<?php wp_footer(); ?>
			</body>
		</html>
	<?php }
}
?>