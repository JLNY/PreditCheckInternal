<?php if (have_posts()): while (have_posts()): the_post();?>
					<div class="hot-verification-item">
						<div class="hot-verification-people-image">
								<?php echo get_people_image_from_verification(get_post()); ?>
						</div>
						<div class="hot-verification-content">
							<?php echo get_people_from_verification(get_post()); ?>
							<!-- <div class="prediction-title">
								<?php echo get_prediction_title_from_verification(get_post()); ?>
							</div> -->
							<div class="prediction-content">
								<?php echo get_prediction_content_from_verification(get_post()); ?>
							</div>
							<div class = "verification">
							<a href="/">
								<div class="verification-topline">
									<div class="verification-trueorfalse">
										<?php echo get_verification_trueorfalse_from_verification(get_post()) ?>
									</div>
									<span>&nbsp;as verified by&nbsp;</span>
									<div class="verification-author">
										<?php echo the_author(); ?>
									</div>
								</div>
								<div class="verification-content">
									<?php echo the_content(); ?>
								</div>
							</div>
						</div>
					</div>
					<?php endwhile;?>
		<div id="infinite-scroll-loading">Loading</div>
		<?php endif;?>