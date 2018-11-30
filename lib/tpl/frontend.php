<?php
	global $wp_query;
	$user				= $wp_query->get_queried_object();
	$dashboard_user		= $this->get_root()->get_instances()['sv_bb_dashboard']->query->trainers->get($user->ID);
	if($dashboard_user && $dashboard_user->get_meta('bb_trainer') == '1'){ // show trainers only
		get_header();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div id="sv_teaser"<?php if ($dashboard_user->get_meta('bb_trainer_featured_image')){ echo ' class="sv_has_thumbnail"'; } ?>>
		<?php 
			echo do_shortcode('[sv_mood class="trainer" title="'.$dashboard_user->get_title().'" subtitle="'.$dashboard_user->get_meta('bb_trainer_featured_image_caption').'" image="'.$dashboard_user->get_meta('bb_trainer_featured_image').'"]');
		?>
	</div>
	<div class="container padding-v-lg">
		<div class="row">
			<div class="col-10 col-sm-3 container mb-4 mb-sm-0">
				<?php echo $dashboard_user->get_image(false, 'large'); ?>
			</div>
			<div class="trainer-details col-9 align-items-center d-flex container">
				<?php echo $dashboard_user->get_meta('bb_trainer_details') ? $dashboard_user->get_meta('bb_trainer_details') : ''; ?>
			</div>
		</div>
		<?php if($dashboard_user->get_meta('bb_trainer_quote')): ?>
		<h2 class="mt-4">&quot;<?php echo $dashboard_user->get_meta('bb_trainer_quote'); ?>&quot;</h2>
		<?php endif; ?>
		<p class="mb-4 mt-5"><strong><?php echo $dashboard_user->get_title(); ?> <?php echo $dashboard_user->get_meta('bb_trainer_title'); ?></strong></p>
		<p><?php echo preg_replace('/\R+/', '<br>', $dashboard_user->get_meta('bb_trainer_description') ); ?></p>
		<p>&nbsp;</p>
		<?php
			global $wpdb;
			$products	= $wpdb->get_col($wpdb->prepare('SELECT post_id FROM '.$wpdb->postmeta.' WHERE meta_key="sv_bb_dashboard_trainerlist" AND meta_value = %s LIMIT %d', $dashboard_user->get_ID(),999));
			
			if($products){
		?>
            <p class="mb-4"><strong>Aktuelle Themen</strong></p>
				<h1>You are cute! ♥</h1>
            <?php
                $shortcode		= '[sv_card_wrap]';
                foreach($products as $product_id){
                    $product		= $this->get_root()->get_instances()['sv_bb_dashboard']->query->products->get($product_id);

                    $shortcode		.= '[sv_card title_1="'.$product->get_title().'"'
                            . ' title_2="'.apply_filters('the_excerpt', get_post_field('post_excerpt', $product_id)).'"'
                            . ' link="'.get_permalink(get_post($product->get_bb_meta('product_public_page'))).'"'
                            . ' link_text="Mehr erfahren"'
                            . ' image="'.get_post_thumbnail_id($product_id).'"'
                            . ' image_size="small"'
                            . ' style="swift"'
                            . '][/sv_card]';
                }
                $shortcode		.= '[/sv_card_wrap]';
                echo do_shortcode($shortcode);
            ?>
            <p>&nbsp;</p>
            <?php
			}
		?>
		<?php if($dashboard_user->get_meta('bb_trainer_industry_focus')){ ?>
		<p  class="mb-4"><strong><?php echo $dashboard_user->get_title(); ?>s Branchenschwerpunkte:</strong></p>
		<div class="container">
			<div class="row text-center">
			<?php
				foreach(explode(',',$dashboard_user->get_meta('bb_trainer_industry_focus')) as $industry_focus){
					echo '<div class="col-3 text-white p-1"><div class="bg-grey p-3 text-uppercase"><strong>'.$industry_focus.'</strong></div></div>';
				}
			?>
			</div>
		</div>
					<span></span>
		<p>&nbsp;</p>
		<?php } ?>
		<?php if($dashboard_user->get_meta('bb_trainer_participant_quotes')){ ?>
			<p class="mb-4"><strong>Zitate von Teilnehmern:</strong></p>
			<?php echo wpautop($dashboard_user->get_meta('bb_trainer_participant_quotes')); ?>
			<p>&nbsp;</p>
		<?php } ?>
		<?php if($dashboard_user->get_meta('bb_trainer_impressions_1')){ ?>
			<p class="mb-4"><strong>Impressionen:</strong></p>
			<div class="row gallery grid-small">
				<?php if($dashboard_user->get_meta('bb_trainer_impressions_1')){ ?>
				<div class="col-sm-6 col-md-4"><a href="<?php echo $dashboard_user->get_meta('bb_trainer_impressions_1'); ?>" data-toggle="lightbox" data-gallery="trainer-gallery"><img src="<?php echo $dashboard_user->get_meta('bb_trainer_impressions_1'); ?>" class="w-100" /></a></div>
				<?php } ?>
				<?php if($dashboard_user->get_meta('bb_trainer_impressions_2')){ ?>
					<div class="col-sm-6 col-md-4"><a href="<?php echo $dashboard_user->get_meta('bb_trainer_impressions_2'); ?>" data-toggle="lightbox" data-gallery="trainer-gallery"><img src="<?php echo $dashboard_user->get_meta('bb_trainer_impressions_2'); ?>" class="w-100" /></a></div>
				<?php } ?>
				<?php if($dashboard_user->get_meta('bb_trainer_impressions_3')){ ?>
					<div class="col-sm-6 col-md-4"><a href="<?php echo $dashboard_user->get_meta('bb_trainer_impressions_3'); ?>" data-toggle="lightbox" data-gallery="trainer-gallery"><img src="<?php echo $dashboard_user->get_meta('bb_trainer_impressions_3'); ?>" class="w-100" /></a></div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</article>
<?php
		get_footer();
	}else{
		header('HTTP/1.0 404 Not Found');
		die();
	}
?>