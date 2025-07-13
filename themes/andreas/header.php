<?php
/**
 * The header for our theme
 *
 * @package andreas
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@400;600;700&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">

	

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'andreas' ); ?></a>

	<header id="masthead" class="site-header py-3 border-bottom ">
	<div class="container d-flex justify-content-between align-items-center">
		<div class="site-branding d-flex align-items-center gap-3">
			<?php the_custom_logo(); ?>

			<div>
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title mb-0"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif; ?>

				<?php
				$andreas_description = get_bloginfo( 'description', 'display' );
				if ( $andreas_description || is_customize_preview() ) :
					echo '<p class="site-description mb-0 small text-muted">' . esc_html( $andreas_description ) . '</p>';
				endif;
				?>
			</div>
		</div>
				<!-- Mobile Burger Icon -->
			<button id="burger-toggle" class="btn d-lg-none p-0 ms-auto me-3" aria-label="Toggle Menu">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/burger-menu.svg" alt="Menu" width="28" height="28">
			</button>

		<nav id="site-navigation" class="main-navigation">
	<div class="nav-wrapper d-flex align-items-center gap-4 ms-auto">
		<?php
		wp_nav_menu( [
			'theme_location' => 'menu-1',
			'menu_id'        => 'primary-menu',
			'container'      => false,
			'menu_class'     => 'nav justify-content-end gap-4',
			'link_before'    => '<span class="nav-link">',
			'link_after'     => '</span>',
			'fallback_cb'    => false,
		] );
		?>

		
	</div>
</nav>

	</div>
	
</header>

