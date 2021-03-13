<?php

get_header();
?>

<h1>Projekty ze všech ročníků</h1>

<?php
// display published posts
while( have_posts() ) : the_post(); ?>

<div style="margin:2rem 0;">
<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</div>


<?php endwhile;

//if empty
if (!have_posts()): ?>

<p style="margin:8rem auto; width:50%; text-align:center">Litujeme, na této stránce není žádný obsah.</p>

<?php endif;
get_footer();