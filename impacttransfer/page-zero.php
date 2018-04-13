<?php
/**
 * Template Name: Zero
 * @package WordPress
 * @subpackage Ashoka
 * @since Ashoka 1.0
 */

get_header(); ?>

<!-- start main loop -->
<?php while (have_posts()) : the_post(); ?>

	<div class="hero">
		
		<?php while(the_repeater_field('hero_images')): ?>
	   	
	       <figure>

	       		<?
	       		$image = get_sub_field('hero_images_image');
	       		$full = wp_get_attachment_image_src( $image, 'hero' );
	       		$mobile = wp_get_attachment_image_src( $image, 'hero-mobile' );
	       		?>

	       		<picture>
	       			<!--[if IE 9]><video style="display: none;"><![endif]-->
	       			<source srcset="<? echo $full[0]; ?>" media="(min-width: 568px)">
	       			<source srcset="<? echo $mobile[0]; ?>">
	       			<!--[if IE 9]></video><![endif]-->
	       			<img srcset="<?php echo $mobile[0]; ?>" alt="">
	       		</picture>

	       		<figcaption><?php $lines = explode("<br />",  get_sub_field('hero_images_image_caption') );  
	                foreach($lines as $line) {
	                    $title = "<span class='break-line'><span class='inline'>" . $line . "</span></span>";
	                    echo $title;
	                } ?>
	            </figcaption>
	          
	       </figure>
	       
	    <?php endwhile; ?>

	    <div class="summary">

	    	<div class="summary-inner wrapper">
	    		
	    		<?php the_content(); ?>

	    	</div>

	    </div>
	</div>

<main>

	

	<section class="solution-overview">

		<div class="solution-overview-inner wrapper">

			<h2><?php the_field('title'); ?></h2>
            <p class="short_descr"><?php the_field('description'); ?></p>

			<ul class="news-filter">

				<li class="filter">
					<button data-filter="*" class="filter-btn selected"><?php pll_e('All'); ?></button>
				</li>

				<? 
				$terms = get_terms(array(
					'taxonomy' => 'topic_zero',
    				'hide_empty' => false
    				)
				); 
				foreach($terms as $term) { ?>

				    <li class="filter">
				    	<button data-filter=".<? echo $term->slug ?>" class="filter-btn"><? echo $term->name ?></button> 
				    </li>

				<? } ?>

			</ul>

				<div class="news-grid" id="news-grid">

					<div class="grid-sizer"></div>

						<?php $posts = get_posts(array(
						    'post_type' => 'zero',
						    //'lang' => '', 
						    'posts_per_page' => -1,
						    'category' => 'featured'
						    //'post__in'  => get_option( 'sticky_posts' )
							));
						
							foreach ( $posts as $post ) : setup_postdata( $post ); ?>
								
								<article class="news-grid-item <?php $terms = get_the_terms($post->ID, 'topic_zero'); $term = array_shift( $terms ); echo $term->slug; ?>">

									<div class="news-grid-item-inner">
										
										<?php if ( has_post_thumbnail() ) { ?>
											<a href="<?php the_permalink(); ?>" class="news-grid-image">
											<?php the_post_thumbnail(); ?>
											</a>
										<? } ?>

										<h3>
											<a href="<?php the_permalink(); ?>" class="title-link"><?php the_title(); ?></a>
										</h3>

										<?php the_excerpt(); ?>

									</div>

								</article>
							
							<?php endforeach; ?>

							<?php wp_reset_postdata(); ?>

				</div>

		</div>

	</section>




	<section class="about-contact" id="about-contact">

		<div class="about-contact-inner wrapper">
			
			<h2><?php the_field('contact_headline'); ?></h2>

			<ul class="about-contact-list">

				<?php while(the_repeater_field('contact_infos')): ?>
						   	
			       <li class="menu-item">

			       		<img src="<?php $image = get_sub_field('contact_image'); $full = wp_get_attachment_image_src( $image, 'thumbnail' ); echo $full[0]; ?>">

			       		<address>

			       			<?php the_sub_field('contact_text'); ?>

			       		</address>
			          
			       </li>
			       
			    <?php endwhile; ?>
			</ul>

		</div>

	</section>

</main>

<?php endwhile; ?>
<!-- end main loop -->

<? get_footer(); ?>
