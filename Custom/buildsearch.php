<?php

//	Keyword search
if (isset($_POST['keywordsearch'])) {
    $text_search = $_POST['keywordsearch'];
    $text = $text_search;
}

//	If there is no keyword entered
else {
    $text = '';
}

//	If there's a category search
if (isset($_POST["cat"])) {
    $cat = $_POST["cat"];
}

// If there's a tag search
if (isset($_POST["tag"])){
    $tags_array = array();
    $tags_array = $_POST["tag"];

    foreach ($tags_array as $key => $value)
    {
        if ($_POST["and-or"] == "OR") {
            //	tag1 OR tag2 is chosen, add a comma after the tags
            $string .= $value.',';
        }
        elseif ($_POST["and-or"] == "AND") {
            //	tag1 AND tag2 is chosen, add a plus after the tags.
            $string .= $value.'+';
        }
    }

    // Remove the last symbol in the string, in this case the comma or plus that is added after each tag. We don't want it to look like "tag1+tag2+".
    $tags_string = substr($string, 0, -1);

    $tag = $tags_string;
}

//	If there's no search for tags, set it to 0
else {
    $tag = 0;
}

// build the url with the variables
$url = header("Location:/fv/?s=$text&cat=$cat&tag=$tag");
?>