<form action="<?php bloginfo('template_url') ?>/build_search.php" method="post" accept-charset="utf-8">
    <div>Search</div>
    <input type="text" name="keywordsearch" value="" id="title">

    <div>Category</div>
    <?php wp_dropdown_categories( 'show_option_all=All Categories' ); ?>

    <div>Tags</div>
    <select name="and-or" id="select-and-or">
        <option value="OR">Match ANY of the checkboxes (default)</option>
        <option value="AND">Match ALL of the checkboxes</option>
    </select>
    <div>
        <?php
        // The following will list all tags with a checkbox next to them.
        $tags = get_terms( 'post_tag' );
        $checkboxes = '';
        foreach($tags as $tag) :
            $checkboxes .='<input type="checkbox" name="tag[]" value="'.$tag -> slug.'" id="tag-'.$tag->term_id.'" /><label for="tag-'.$tag->term_id.'">'.$tag->name.'</label>';
        endforeach;
        print $checkboxes;
        ?>
    </div>
    <p><input type="submit" value="Search"></p>
</form>