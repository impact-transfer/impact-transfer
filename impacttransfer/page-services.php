<?php
/**
 * Template Name: Services
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

	

	<section class="method">

		<div class="method-inner wrapper">
			
			<h2><?php the_field('steps_headline'); ?></h2>

			<?php $counter = 0; while(the_repeater_field('steps')): ?>
		   	
		       <div class="method-step <? $counter++; if ($counter % 2 == 0) { ?>even<? } ?>" data-step="<?php echo $counter . '.' ?>">

		       		<p class="method-step-number"><?php echo $counter . '.' ?></p>

		       		<img src="<?php the_sub_field('section_illu'); ?>" class="method-step-image">

		       		<div class="method-step-text">

		       			<h3><?php the_sub_field('section_headline'); ?></h3>

		       			<?php the_sub_field('section_text'); ?>
		       			
		       		</div>
		          
		       </div>
		       
		    <?php endwhile; $counter = 0; ?>

		</div>

	</section>

<!-- 	<section class="home-cta">

		<div class="home-cta-inner wrapper">

			<?php while(the_repeater_field('call_to_actions')): ?>
		   	
		       <a href="<?php the_sub_field('link'); ?>" class="home-cta-item">

		       		<img src="<?php the_sub_field('icon'); ?>">

		       		<h3><?php the_sub_field('headline'); ?></h3>

		       		<p><?php the_sub_field('text'); ?></p>
		          
		       </a>
		       
		    <?php endwhile; ?>

		</div>

	</section> -->

	

	<section class="service-modules">

		<div class="service-modules-inner wrapper">
				
			<?php while(the_repeater_field('service_modules')): ?>

	       		<h3><?php the_sub_field('service_title'); ?></h3>

	       		<p><?php the_sub_field('service_text'); ?></p>
		       
		    <?php endwhile; ?>

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
