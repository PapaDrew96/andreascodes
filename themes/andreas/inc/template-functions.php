<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package andreas
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function andreas_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'andreas_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function andreas_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'andreas_pingback_header' );



function render_catch_the_stack_game_html($sound_on_icon, $sound_off_icon, $audio_file) {
	$audio_url = is_array($audio_file) ? $audio_file['url'] : '';
	?>
	<div class="game-wrapper">
		<div class="game-instructions">
			<h2>🎮 Catch the Stack</h2>
			<p>Use <strong>←</strong> and <strong>→</strong> arrow keys or touch to move your box.</p>
			<p>Catch the falling icons from your tech stack to earn points.</p>
			<button id="start-game-btn">▶ Begin Game</button>
		</div>

		<canvas id="catch-the-stack" width="800" height="600"></canvas>

		<?php if ($audio_url): ?>
			<audio id="game-music" loop preload="auto">
				<source src="<?php echo esc_url($audio_url); ?>" type="audio/mpeg">
			</audio>
		<?php endif; ?>

		<button id="toggle-sound" aria-label="Toggle Sound" class="sound-toggle" type="button">
			<?php if ($sound_on_icon): ?>
				<img id="sound-on" src="<?php echo esc_url($sound_on_icon['url']); ?>" alt="Sound On" width="28" height="28" />
			<?php endif; ?>
			<?php if ($sound_off_icon): ?>
				<img id="sound-off" src="<?php echo esc_url($sound_off_icon['url']); ?>" alt="Sound Off" width="28" height="28" style="display:none;" />
			<?php endif; ?>
		</button>
	</div>
	<?php
}


add_action('render_catch_the_stack_game', 'render_catch_the_stack_game_html', 10, 3);

