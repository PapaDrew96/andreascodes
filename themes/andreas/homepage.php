<?php
/**
 * Template Name: Home
 * Description: Custom home page built with modular template parts and ACF.
 *
 * @package andreas
 */

get_header(); ?>

<?php get_template_part( 'template-parts/frontpage/hero' ); ?>
<?php get_template_part( 'template-parts/frontpage/services' ); ?>
<?php get_template_part( 'template-parts/frontpage/projects' ); ?>
<?php get_template_part( 'template-parts/frontpage/snippets' ); ?>
<?php get_template_part( 'template-parts/frontpage/cta' ); ?>

<?php get_footer(); ?>
