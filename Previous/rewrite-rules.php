<?php
/**
 *  Stop Wordpress Auto redirect to Canonical URL
 */
remove_filter( 'template_redirect', 'redirect_canonical' );


/**
 * Add extra query parameters so that Wordpress recognises them and you can work with them
 *
 * @param mixed $qvars
 */
function mastermind_query_vars( $qvars ) {
    $qvars[] = 'event_id';
    $qvars[] = 'event_type';
    $qvars[] = 'event_date';

    $qvars[] = 'topic_id';
    $qvars[] = 'topicname';

    $qvars[] = 'type_id';
    $qvars[] = 'typename';


    $qvars[] = 'user_nicename';

    $qvars[] = 'p1';
    $qvars[] = 'p2';
    $qvars[] = 'p3';
    $qvars[] = 'p4';


    $qvars[] = 'lang';
    $qvars[] = 'post_type';

//    print_debug($qvars); die('1');
    return $qvars;
}
add_filter('query_vars', 'mastermind_query_vars' );


/**
 * add custom rewrite rules
 *
 * @param mixed $wp_rewrite_rules
 */
function mastermind_rewrites ($wp_rewrite_rules) {
    global $mm_config, $wp_rewrite;

    $my_rules = array();

    // mogelijke virtuele uris
    // ------------------------
    // blog/:topicname
    // topics/

    $exception_rules = array();
    $custom_post_types_localized_rules = array();
    $custom_post_types_fallback_rules = array();

    $blog_prefix = "blog\/";
    $blog_prefix = "";

    foreach($mm_config['custom_post_types'] as $key => $post_type) {

        $pattern = "/^".$blog_prefix.$post_type['slugs']['en']."\//";
        foreach($wp_rewrite_rules as $rule=>$query) {
            if( preg_match($pattern, $rule) > 0 ) {
//                echo '<li> $rule: '.$rule;
//                $wp_rewrite_rules_mod[$rule] = $query;
                unset($wp_rewrite_rules[$rule]);

//                $rule = str_replace('blog/', '', $rule);
                $custom_post_types_localized_rules[$rule] = $query;

                foreach($post_type['slugs'] as $lang => $slug) {
                    if($lang != 'en') {
//                        $localized_rule = preg_replace($pattern, $lang."/".$slug.'/', $rule);
                        $localized_rule = preg_replace($pattern, $slug.'/', $rule);
                        $custom_post_types_localized_rules[$localized_rule] = $query;
                    }
                }
            }
        }


        // Custom slugs (NL/EN) voor onze custom post types
        foreach($post_type['slugs'] as $lang => $slug) {
            $custom_post_types_fallback_rules[$slug.'/?$'] = 'index.php?post_type='.$key;
//            mastermind_add_new_rewrite_rules($key, trim($slug), $lang, &$my_rules);
        }
    }

//    $wp_rewrite_rules = $wp_rewrite_rules_mod;



    // blog toevoegen aan de rules
//    [blog/feed/(feed|rdf|rss|rss2|atom)/?$] => index.php?&feed=$matches[1]
//    [blog/(feed|rdf|rss|rss2|atom)/?$] => index.php?&feed=$matches[1]
//    [blog/page/?([0-9]{1,})/?$] => index.php?&paged=$matches[1]
    $exception_rules['blog/(.+?)/page/?([0-9]{1,})/?$'] = 'index.php?pagename=blog&topicname=$matches[1]&paged=$matches[2]';
    $exception_rules['blog/page/?([0-9]{1,})/?$'] = 'index.php?pagename=blog&paged=$matches[1]';
    $exception_rules['blog/(.+?)/?$'] = 'index.php?pagename=blog&topicname=$matches[1]';

    // rules voor trainings_and_events
    $exception_rules['trainings-and-events/([^/]+)/([^/]+)/?$'] = 'index.php?post_type=programs_and_events&event_type=$matches[1]&event_date=$matches[2]';
    $exception_rules['trainingen-en-events/([^/]+)/([^/]+)/?$'] = 'index.php?post_type=programs_and_events&event_type=$matches[1]&event_date=$matches[2]';
//    $exception_rules['nl/trainingen-en-events/([^/]+)/([^/]+)/?$'] = 'index.php?post_type=programs_and_events&event_type=$matches[1]&event_date=$matches[2]';
    $exception_rules['trainings-and-events/([^/]+)/?$'] = 'index.php?post_type=programs_and_events&event_type=$matches[1]';
    $exception_rules['trainingen-en-events/([^/]+)/?$'] = 'index.php?post_type=programs_and_events&event_type=$matches[1]';
//    $exception_rules['nl/trainingen-en-events/([^/]+)/?$'] = 'index.php?post_type=programs_and_events&event_type=$matches[1]';

    // rules voor resources_and_tools
    $exception_rules['resources-and-tools/([^/]+)/?$'] = 'index.php?post_type=resources_and_tools&p1=$matches[1]';
    $exception_rules['kennisbank/([^/]+)/?$'] = 'index.php?post_type=resources_and_tools&p1=$matches[1]';
//    $exception_rules['nl/kennisbank/([^/]+)/?$'] = 'index.php?post_type=resources_and_tools&p1=$matches[1]';


    $pages_with_custom_query_vars = array($mm_config['page_ids']['our_people']);
    foreach($pages_with_custom_query_vars as $page_id) {
        foreach($mm_config['languages'] as $lang) {
            $pagename = mastermind_get_post_uri($page_id, $lang);
            $exception_rules[$pagename.'([^/]+)/?$'] = 'index.php?lang='.$lang.'&page_id='.$page_id.'&user_nicename=$matches[1]';
        }
    }


    $all_rewrite_rules = $exception_rules + $custom_post_types_localized_rules + $custom_post_types_fallback_rules + $wp_rewrite_rules;

    if(11==1 && stristr($_SERVER['REQUEST_URI'], 'options-permalink')) {

        $rrr = $wp_rewrite->generate_rewrite_rules('blog');

//        echo '<pre>'; print_r($exception_rules); echo '</pre>';
//        echo '<pre>'; print_r($custom_post_types_localized_rules); echo '</pre>';
//        echo '<pre>'; print_r($custom_post_types_fallback_rules); echo '</pre>';
//        echo '<pre>'; print_r($wp_rewrite_rules); echo '</pre>';
//    	echo '<pre>'; print_r($rrr); echo '</pre>';
        echo '<pre>'; print_r($all_rewrite_rules); echo '</pre>';
    }

    return $all_rewrite_rules;

}
add_filter( 'rewrite_rules_array', 'mastermind_rewrites' );





/**
 * Alternatief voor add_filter( 'rewrite_rules_array' )
 *
 * @param mixed $wp_rewrite
 */
function mastermind_add_rewrite_rules( $wp_rewrite )
{
    //$my_rules = array();
    //$my_rules['blog/(.+?)/?$'] = 'index.php?pagename=blog&topicname=$matches[1]';
    //$wp_rewrite->rules = $my_rules + $wp_rewrite->rules;

    //echo '<pre>'; print_r($wp_rewrite->rules); echo '</pre>';

}
add_action( 'generate_rewrite_rules', 'mastermind_add_rewrite_rules' );




/**
 * Adding custom rewrite rules to Wordpress
 *
 * @param mixed $args
 */
function mastermind_add_new_rewrite_rules($post_type, $slug, $lang, $rules) {
    global $wp_rewrite;

    $rewrite_rules = $wp_rewrite->generate_rewrite_rules($slug);
    $rewrite_rules[$slug.'/?$'] = 'index.php?paged=1';

    foreach($rewrite_rules as $regex => $redirect) {
        if(strpos($redirect, 'attachment=') === false) {
            $redirect .= '&post_type='.$post_type;
        }

        if(0 < preg_match_all('@\$([0-9])@', $redirect, $matches)) {
            for($i = 0; $i < count($matches[0]); $i++) {
                $redirect = str_replace($matches[0][$i], '$matches['.$matches[1][$i].']', $redirect);
            }
        }
        $rules[$regex] = $redirect;
        //$wp_rewrite->add_rule($regex, $redirect, 'top');
    }

    //echo '<hr />'; echo '<pre>'; print_r($wp_rewrite->rules); echo '</pre>';

}
