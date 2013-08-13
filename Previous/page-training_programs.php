<?php
/**
 * Template Name: Listpage - Training Programmes
 */
global $mm_config;
$mm_config['q']['post_type'] = 'programs_and_events';
?>
<?php get_header(); ?>
    <div id="content">
        <div class="content-grid">
            <?php get_template_part( 'loop', 'programs_and_events'); ?>
            <?php get_sidebar('programs_and_events'); ?>
            <?php get_header( 'navigation' ); ?>
        </div><!-- /.content-grid -->
    </div><!-- /#content -->
<?php get_footer(); ?>