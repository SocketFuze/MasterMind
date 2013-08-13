<?php global $q_config, $wpdb; ?>
<?php get_header(); ?>

<div id="content">
    <div class="content-grid">
        <div id="main-content" class="primary-content">


            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>


                    <?php mastermind_section_heading(); ?>

                    <div class="event main">
                        <div class="event-info">
                            <div class="share event-share">
                                <?php mastermind_share_links_block(); ?>
                            </div>

                            <h1> <a href="#"> <?php the_title() ?> </a> </h1>
                        <span class="tags">
                            <?php echo $post->mm_post_meta['breadcrumb'] ?>
                        </span>

                            <?php mastermind_featured_image($post, array( 'width'=>139, 'height'=>'', 'class'=>'align-left' ) ); ?>
                            <?php the_content() ?>

                            <?php
                            if(isset($post->mm_post_meta['media']['pdf_'.$mm_config['language']]) && intval($post->mm_post_meta['media']['pdf_'.$mm_config['language']]) > 0) {
                                $pdf = get_post($post->mm_post_meta['media']['pdf_'.$mm_config['language']]);
                                echo '<a style="float: right; clear: both;" class="pdf read-more" href="'.$pdf->guid.'" title="">'.__( 'Download brochure', 'mastermind' ).'</a>';
                            }

                            ?>

                        </div><!-- /.event-info -->


                        <?php if( 1==8 && $post->mm_post_meta['event'] != null ) :  ?>
                            <div class="event-banner">
                                <div class="event-details">
                                    <?php $e = $post->mm_post_meta['event']; ?>
                                    <div class="date"><?php echo ($e->titles['title_'.$mm_config['languages']] ? $e->titles['title_'.$mm_config['languages']] : $e->date_title)?></div>
                                    <div class="location"><?php echo $e->venue ?>, <?php echo $e->city ?>, <?php echo $e->country ?>
                                    </div>
                                    <div class="price"><?php echo $e->price ?></div>
                                </div>
                            </div><!-- /.event-banner -->
                        <?php endif; ?>

                    </div><!-- /.event main -->

                    <div class="tab-block detail">
                        <ul class="tabs">
                            <li><a href="#tab-overview"><?php _e( 'Overview', 'mastermind' ) ?></a></li>
                            <li><a href="#tab-approach"><?php _e( 'Approach', 'mastermind' ) ?></a></li>
                            <li><a href="#tab-program"><?php _e( 'Program', 'mastermind' ) ?></a></li>
                            <li id="li-tab-dates"><a href="#tab-dates"><?php _e( 'Dates &amp; venues', 'mastermind' ) ?></a></li>
                            <li><a href="#tab-trainers"><?php _e( 'Trainers &amp; speakers', 'mastermind' ) ?></a></li>
                            <li><a href="#tab-questions"><?php _e( 'Questions', 'mastermind' ) ?></a></li>
                        </ul>

                        <?php /*
                    <div class="share event-share">
                        <?php mastermind_share_links_block(); ?>
                    </div>
                    */ ?>

                        <div id="tab-overview" class="tab-content">
                            <?php echo $post->mm_post_meta['meta']['overview_'.$q_config['language']]; ?>
                        </div><!-- /.tab-content -->

                        <div id="tab-approach" class="tab-content">
                            <?php echo $post->mm_post_meta['meta']['approach_'.$q_config['language']]; ?>
                        </div><!-- /.tab-content -->

                        <div id="tab-program" class="tab-content">
                            <?php echo $post->mm_post_meta['meta']['program_'.$q_config['language']]; ?>
                        </div><!-- /.tab-content -->

                        <div id="tab-dates" class="tab-content">
                            <?php echo $post->mm_post_meta['meta']['dates_'.$q_config['language']]; ?>

                            <?php if($post->mm_post_meta['events']) : ?>
                                <table class="events" width="100%">
                                    <thead>
                                    <tr>
                                        <th><?php _e( 'Date', 'mastermind' ) ?></th>
                                        <!--<th><?php _e( 'Date till', 'mastermind' ) ?></th>-->
                                        <th><?php _e( 'Location', 'mastermind' ) ?></th>
                                        <th><?php _e( 'Price', 'mastermind' ) ?></th>
                                        <th><?php _e( 'Spaces', 'mastermind' ) ?></th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($post->mm_post_meta['events'] as $id => $event) : ?>
                                        <tr>
                                            <td><?php echo $event->date_from ?> </td>
                                            <!--<td><?php echo $event->date_till ?> </td>-->
                                            <td>
                                                <b><?php _e( 'Venue', 'mastermind' ) ?>:</b> <?php echo $event->venue ?><br />
                                                <b><?php _e( 'City', 'mastermind' ) ?>:</b> <?php echo $event->city ?><br />
                                                <b><?php _e( 'Country', 'mastermind' ) ?>:</b> <?php echo $event->country ?>
                                            </td>
                                            <td><?php echo $event->price ?> </td>
                                            <td><?php echo $event->spaces ?> </td>
                                            <td>
                                                <a href="<?php echo mastermind_get_permalink( $post->ID ) . $event->date_from ?>/"><?php _e( 'More info', 'mastermind' ) ?></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                        </div><!-- /.tab-content -->

                        <div id="tab-trainers" class="tab-content">
                            <?php echo $post->mm_post_meta['meta']['trainers_and_speakers_'.$q_config['language']]; ?>
                        </div><!-- /.tab-content -->

                        <div id="tab-questions" class="tab-content">
                            <?php echo $post->mm_post_meta['meta']['questions_'.$q_config['language']]; ?>
                        </div><!-- /.tab-content -->

                    </div><!-- /.tab-block -->

                <?php endwhile; ?>
            <?php endif; ?>


        </div><!-- /.primary-content -->


        <?php
        if( $post->mm_post_meta['event'] != null )
        {
            get_sidebar('program');
        }
        else
        {
            get_sidebar('event');
        }
        ?>

        <?php get_header('navigation'); ?>

    </div><!-- /.content-grid -->

</div><!-- /#content -->


<?php if( $post->mm_post_meta['event'] != null ) :?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#li-tab-dates').click();
        });
    </script>
<?php endif;?>

<?php get_footer(); ?>
