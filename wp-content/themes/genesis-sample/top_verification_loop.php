<?php if (have_posts()): while (have_posts()): the_post();?>
			<div class="hot-verification-item">
				<div class="hot-verification-people-image">
						<?php echo get_people_image_from_predic_verific(get_post()); ?>
				</div>
				<div class="hot-verification-content">
					<?php echo get_people_from_predic_verific(get_post()); ?>
					<?php echo get_newsfeed_label_predic_verific(get_post()); ?>
					<?php echo get_prediction_title_from_verification(get_post()); ?>
					<div class="prediction-content">
						<?php echo get_prediction_content_from_verification(get_post()); ?>
					</div>
					<?php echo get_verificaiton_section_for_newsfeed(get_post()) ?>
				</div>
			</div>
		<?php endwhile;?>
	<div id="infinite-scroll-loading">Loading...</div>
	<?php endif;?>