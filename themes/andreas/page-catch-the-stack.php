<?php
/* Template Name: Catch the Stack */
get_header();

$sound_on_icon  = get_field('sound_on_icon');
$sound_off_icon = get_field('sound_off_icon');
$audio_file     = get_field('audio_file'); // ACF File field (expects array)

do_action('render_catch_the_stack_game', $sound_on_icon, $sound_off_icon, $audio_file);

get_footer();
