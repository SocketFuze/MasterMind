// ajaxLoop.js
jQuery(function($){
    var page = 1;
    var loading = true;
    var $window = $(window);
    var $content = $("body.tax-events .rt-grid-8");
    var load_posts = function(){
            $.ajax({
                type       : "GET",
                data       : {numPosts : 1, pageNumber: page},
                dataType   : "html",
                url        : "http://dev.struto.co.uk/ws-ximenia/wp-content/themes/rt_ximenia_wp/loopHandler.php",
                beforeSend : function(){
                    if(page != 1){
                        $content.append('<div id="temp_load" style="text-align:center">\
                            <img src="../images/ajax-loader.gif" />\
                            </div>');
                    }
                },
                success    : function(data){
                    $data = $(data);
                    if($data.length){
                        $data.hide();
                        $content.append($data);
                        $data.fadeIn(500, function(){
                            $("#temp_load").remove();
                            loading = false;
                        });
                    } else {
                        $("#temp_load").remove();
                    }
                },
                error     : function(jqXHR, textStatus, errorThrown) {
                    $("#temp_load").remove();
                    alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                }
        });
    }
    $window.scroll(function() {
        var content_offset = $content.offset();
        console.log(content_offset.top);
        if(!loading && ($window.scrollTop() +
            $window.height()) > ($content.scrollTop() + $content.height() + content_offset.top)) {
                loading = true;
                page++;
                load_posts();
        }
    });
    load_posts();
});

/*
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
            lang: 'en',
            queryString: $('#programs_and_events_filter').serialize()
        };

        if(ajax_call) {
            ajax_call.abort();
        }

        ajax_call = $.get(ajax_url, data, function(response) {
            if(response == '-1')
            {
                $('#programs_and_events_list').text('Error retrieving training &amp; events.').addClass('error');
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
*/