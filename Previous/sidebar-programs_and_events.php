<?php global $q_config, $wpdb, $wp, $mm_config; ?>
<?php

$data = array();
$data = $mm_config['data']['programs_and_events'];

$checked_string = ' checked="checked"';

$select_ALL_checkbox['training-programmes'] = false;
$select_ALL_checkbox['marketing_events'] = false;
$select_ALL_checkbox['training_events'] = false;



$r = mastermind_get_query_vars();

$p_filter = isset($r['p_filter']) ? $r['p_filter'] : array();
$te_filter = isset($r['te_filter']) ? $_REQUEST['te_filter'] : array();
$me_filter = isset($r['me_filter']) ? $r['me_filter'] : array();
$type = null;

if( !isset($r['p_filter']) && !isset($r['me_filter']) && !isset($r['te_filter']) ) {

    if(isset($r['type'])) {
        $type = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->terms WHERE slug=%s", $r['type']));
    }

//echo '<!--';
//echo '<li>$type: '; print_debug($type);
//echo '<li>$r: '; print_debug($r);
//echo '<li>$cat_id: '.$cat_id;
//echo '-->';

    if(isset($r['event_type'])) {
        if($type) {
            if(($r['event_type'] == 'marketing-events' || $r['event_type'] == 'marketing_events')&& (!in_array($type->term_id, $me_filter) || !is_array($me_filter)) ) {
                $me_filter[] = $type->term_id;
            }
            else if(($r['event_type'] == 'training-events' || $r['event_type'] == 'training_events') && (!in_array($type->term_id, $te_filter) || !is_array($te_filter)) ) {
                $te_filter[] = $type->term_id;
            }
            else if(($r['event_type'] == 'training-programmes' || $r['event_type'] == 'training_programmes') && (!in_array($type->term_id, $p_filter) || !is_array($p_filter)) ) {
                $p_filter[] = $type->term_id;
            }
            else {
                $select_ALL_checkbox[$r['event_type']] = true;
            }
        }
        else {
            $select_ALL_checkbox[$r['event_type']] = true;
        }

    }
    else {
        if($type) {
            if(!in_array($type->term_id, $p_filter) || !is_array($p_filter) ) {
                $p_filter[] = $type->term_id;
            }
        }
        else {
            $select_ALL_checkbox['training-programmes'] = true;
        }
        //$select_ALL_checkbox['marketing_events'] = true;
        //$select_ALL_checkbox['training_events'] = true;
    }
}


$total_programs = 0;
$total_marketing_events = 0;
$total_training_events = 0;

if(isset($data['program_categories']) && count($data['program_categories']) > 0) {
    foreach($data['program_categories'] as $val) {
        $total_programs = $total_programs + intval($val->num_posts);
    }
}

if(isset($data['marketing_event_categories']) && count($data['marketing_event_categories']) > 0) {
    foreach($data['marketing_event_categories'] as $key=>$val) {
        $total_marketing_events = $total_marketing_events + intval($val->num_posts);
    }
}

if(isset($data['training_event_categories']) && count($data['training_event_categories']) > 0) {
    foreach($data['training_event_categories'] as $key=>$val) {
        $total_training_events = $total_training_events + intval($val->num_posts);
    }
}
?>
<div class="secondary-content">

    <div id="programs_and_events_filters" class="block filters">

        <form method="post" name="programs_and_events_filter" id="programs_and_events_filter">
            <input type="hidden" name="paged" id="paged" value"<?php echo $r['paged']; ?>" />

            <h2> <?php _e( 'Training programmes', 'mastermind' ) ?> </h2>
            <fieldset>
                <?php $selected = (!$cat_id && $select_ALL_checkbox['training-programmes'] == true) || isset($r['p_filter_all']) ? $checked_string : ''; ?>
                <input type="checkbox" id="p_filter_all" name="p_filter_all" value="all" <?php echo $selected; ?> />
                <label for="p_filter_all" style="font-weight: bold;">
                    <?php _e( 'All Training programmes', 'mastermind' ); ?>
                </label>
                <span class="amount">(<?php echo $total_programs; ?>)</span>
                <br />


                <?php
                if(isset($data['program_categories']) && count($data['program_categories']) > 0) :
                    foreach($data['program_categories'] as $c) :
                        $selected = $cat_id == $c->term_id || (is_array($p_filter) && in_array($c->term_id, $p_filter)) ? ' checked="checked"' : '';
                        ?>
                        <input type="checkbox" id="p_filter_<?php echo $c->term_id ?>" name="p_filter[]" value="<?php echo $c->term_id ?>" <?php echo $selected; ?> />
                        <label for="p_filter_<?php echo $c->term_id ?>">
                            <?php echo $q_config['term_name'][$c->name][$q_config['language']]; ?>
                        </label>
                        <span class="amount">(<?php echo $c->num_posts; ?>)</span>
                        <br />
                    <?php
                    endforeach;
                endif;
                ?>
            </fieldset>



            <hr />

            <h2> <?php _e( 'Training Events', 'mastermind' ) ?> </h2>
            <fieldset>

                <?php $selected = (!$cat_id && $select_ALL_checkbox['training_events'] == true) || isset($r['te_filter_all']) ? $checked_string : ''; ?>
                <input type="checkbox" id="te_filter_all" name="te_filter_all" value="all" <?php echo $selected; ?> />
                <label for="te_filter_all" style="font-weight: bold;">
                    <?php _e( 'All Training Events', 'mastermind' ); ?>
                </label>
                <span class="amount">(<?php echo $total_training_events; ?>)</span>
                <br />


                <?php
                if(isset($data['training_event_categories']) && count($data['training_event_categories']) > 0) :
                    foreach($data['training_event_categories'] as $c) :
                        $selected = $cat_id == $c->term_id || (is_array($te_filter) && in_array($c->term_id, $te_filter)) ? ' checked="checked"' : '';
                        ?>
                        <input type="checkbox" id="te_filter_<?php echo $c->term_id ?>" name="te_filter[]" value="<?php echo $c->term_id ?>" <?php echo $selected; ?> />
                        <label for="te_filter_<?php echo $c->term_id ?>">
                            <?php echo $q_config['term_name'][$c->name][$q_config['language']]; ?>
                        </label>
                        <span class="amount">(<?php echo $c->num_posts; ?>)</span>
                        <br />
                    <?php
                    endforeach;
                endif;
                ?>

            </fieldset>

            <hr />

            <h2> <?php _e( 'Marketing Events', 'mastermind' ) ?> </h2>
            <fieldset>

                <?php $selected = (!$cat_id && $select_ALL_checkbox['marketing_events'] == true) || isset($r['me_filter_all']) ? $checked_string : ''; ?>
                <input type="checkbox" id="me_filter_all" name="me_filter_all" value="all" <?php echo $selected; ?> />
                <label for="me_filter_all" style="font-weight: bold;">
                    <?php _e( 'All Marketing Events', 'mastermind' ); ?>
                </label>
                <span class="amount">(<?php echo $total_marketing_events; ?>)</span>
                <br />


                <?php
                if(isset($data['marketing_event_categories']) && count($data['marketing_event_categories']) > 0) :
                    foreach($data['marketing_event_categories'] as $c) :
                        $selected = $cat_id == $c->term_id || (is_array($me_filter) && in_array($c->term_id, $me_filter)) ? ' checked="checked"' : '';
                        ?>
                        <input type="checkbox" id="me_filter_<?php echo $c->term_id ?>" name="me_filter[]" value="<?php echo $c->term_id ?>" <?php echo $selected; ?> />
                        <label for="me_filter_<?php echo $c->term_id ?>">
                            <?php echo $q_config['term_name'][$c->name][$q_config['language']]; ?>
                        </label>
                        <span class="amount">(<?php echo $c->num_posts; ?>)</span>
                        <br />
                    <?php
                    endforeach;
                endif;
                ?>
            </fieldset>
        </form>


    </div><!-- /.block filters -->

    <?php if(is_active_sidebar('sb_programs_and_events')) : ?>
        <?php dynamic_sidebar('sb_programs_and_events'); ?>
    <?php endif; ?>

</div><!--// #secondary-content-->

