<?php
get_header();

echo get_avatar( get_the_author_meta( 'user_email' ), '100' );

echo '<h1>';
the_author();
echo '</h1>';

echo get_the_author_meta( 'description' );

get_footer();