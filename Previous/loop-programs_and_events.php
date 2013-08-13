<div id="main-content" class="primary-content">

    <?php
    global $mm_config;

    $subtitle = __( 'programmes', 'mastermind' );
    if( isset($mm_config['q']['event_type']) ) {
        $subtitle = $mm_config['custom_post_types']['programs_and_events']['event_types']['types'][$mm_config['q']['event_type']];
    }
    mastermind_section_heading( __( 'Training &amp; Events', 'mastermind' ), '' );



    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {

            $('.checker').click(function() {
                //$('#programs_and_events_filter').submit();
                //return;
                var cb = $(this).find('input:first');
                if($(cb).val() == 'all') {
                    $(this).parent().find('input').each(function() {
                        if($(this).val() != 'all') {
                            $(this).attr('checked', false);
                            $(this).parent().removeClass('checked');
                        }
                    });
                } else {
                    $(this).parent().find('input').each(function() {
                        if($(this).val() == 'all'){
                            $(this).attr('checked', false);
                            $(this).parent().removeClass('checked');
                        }
                    });
                }
                get_program_and_events();
            });
            var ajax_call = null;
            function get_program_and_events() {
//                alert($('#programs_and_events_filter').serialize());
                var data = {
                    action: 'mastermind_programs_and_events_list',
                    lang: '<?php echo $mm_config['language'] ?>',
                    queryString: $('#programs_and_events_filter').serialize()
                };

                if(ajax_call) {
                    ajax_call.abort();
                }

                ajax_call = $.get(ajax_url, data, function(response) {
                    if(response == '-1')
                    {
                        $('#programs_and_events_list').text('<?php _e( 'Error retrieving training &amp; events.', 'mastermind' ) ?>').addClass('error');
                    }
                    else
                    {
                        //alert('hallo');
                        $('#programs_and_events_list').removeClass('error');
                        $('#programs_and_events_list').html(response);
                        $('.wp-paginate a.page').click(function() {
                            $('#programs_and_events_filter input[name="paged"]').val($(this).text());
                            get_program_and_events();
                            return false;
                        });
                        $('.pagination a.next').click(function() {
                            var p = $('#programs_and_events_filter input[name="paged"]').val();
                            if(p != '') p = p + 1;
                            else  p = 2;
                            $('#programs_and_events_filter input[name="paged"]').val(p);
                            get_program_and_events();
                            return false;
                        });
                        $('.pagination a.prev').click(function() {
                            var p = $('#programs_and_events_filter input[name="paged"]').val();
                            if(p != '') p = p - 1;
                            else  p = 1;
                            $('#programs_and_events_filter input[name="paged"]').val(p);
                            get_program_and_events();
                            return false;
                        });
                    }
                });

                return false;
            }

            get_program_and_events();

        });
    </script>

    <div id="programs_and_events_featured_item">
        <?php mastermind_programs_and_events_featured_item(); ?>
    </div>

    <div id="programs_and_events_list">
        <?php //mastermind_programs_and_events_list(); ?>
    </div>


</div><!-- /.primary-content -->
