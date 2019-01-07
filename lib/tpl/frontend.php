<?php
get_header();

$author_ID 		= get_the_author_meta( 'ID' );
?>
<div class="container py-5">
	<div class="<?php echo $this->get_module_name(); ?> row">
		<div class="header col-12 text-center mb-5">
			<h6 class="mb-4">Author</h6>
			<?php echo get_avatar( $author_ID, 100 ); ?>
			<h3 class="author-name mt-4"><?php the_author(); ?></h3>
			<h6 class="author-posts mb-4">
				<?php echo count( get_posts( array( 'author' => $author_ID ) ) ); ?>
				posts
			</h6>
			<div class="author-description">
				<?php echo get_the_author_meta( 'description' ); ?>
			</div>
		</div>
		<div class="body col-12 col-md-8">
			<?php echo do_shortcode( '[sv_posts author="' . $author_ID .  '" image="1" show_category="1" show_excerpt="1" max_length="150"]' ); ?>
		</div>

		<div class="author-sidebar col-12 col-md-4">
			<?php echo do_shortcode( '[sv_sidebar template = "author"]' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
