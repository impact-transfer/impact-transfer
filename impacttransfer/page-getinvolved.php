<?php
/**
 * Template Name: Get Involved
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

	    <div class="cta-header">
	        		
        	<h3><?php the_field('cta_headline'); ?></h3>

        	<p><?php the_field('cta_text'); ?></p>

        	<a href="<?php the_field('button_url'); ?>" class="btn"><?php the_field('button_text'); ?></a>

        </div>

	</div>

<main>

	<section class="roles">

		<div class="roles-inner wrapper">

			<h2><?php pll_e('Roles'); ?></h2>

				<div class="overview-grid" id="">

						<?php $posts = get_posts(array(
						    'post_type' => 'role',
						    //'lang' => '', 
						    //'showposts' => 4,
						    'category' => 'featured'
						    //'post__in'  => get_option( 'sticky_posts' )
							));
						
							foreach ( $posts as $post ) : setup_postdata( $post ); ?>
								
								<a href="<?php the_permalink(); ?>" class="overview-grid-item">

									<div class="overview-grid-item-inner">
										
										<?php if ( has_post_thumbnail() ) { ?>
											
											<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
											 <img src="<?php echo $image[0]; ?>" class="">
											
										<? } ?>

										<h3>
											<?php the_title(); ?>
										</h3>

										<div class="overview-grid-item-text" data-mh="overview-grid-item-text">
											<?php the_content(); ?>
										</div>

										<!-- <a href="<?php the_permalink(); ?>" class="btn"><?php pll_e('Mehr erfahren'); ?></a> -->

									</div>

								</a>
							
							<?php endforeach; ?>

							<?php wp_reset_postdata(); ?>

				</div>

		</div>

	</section>

	<section class="service-modules">

		<div class="service-modules-inner wrapper">
				
			<?php while(the_repeater_field('service_modules')): ?>

	       		<?php if (get_sub_field('service_title')) { ?>
	       		<h2><?php the_sub_field('service_title'); ?></h2>
	       		<? } ?>

				<?php if (get_sub_field('service_image')) { ?>
	       		<img src="<?php the_sub_field('service_image'); ?>">
	       		<? } ?>

	       		<?php the_sub_field('service_text'); ?>
		       
		    <?php endwhile; ?>

		</div>

	</section>



</main>

<?php endwhile; ?>
<!-- end main loop -->

<? get_footer(); ?>
