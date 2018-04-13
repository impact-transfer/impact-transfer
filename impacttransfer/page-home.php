<?php
/**
 * Template Name: Home
 * @package WordPress
 * @subpackage Ashoka
 * @since Ashoka 1.0
 */

get_header(); ?>

<!-- start main loop -->
<?php while (have_posts()) : the_post(); ?>

<div class="hero">
	
	<div class="hero-slider">

		<?php while(the_repeater_field('hero_images')): ?>
	   	
	       <figure class="">

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

	       		<figcaption>
					<a href="<?php the_sub_field('hero_images_link'); ?>">
	       			<?php $lines = explode("<br />",  get_sub_field('hero_images_image_caption') );  
	       		    foreach($lines as $line) {
	       		        $title = "<span class='break-line'><span class='inline'>" . $line . "</span></span>";
	       		        echo $title;
	       		    } ?>
	       		    </a>
	       		</figcaption>
	          
	       </figure>
	       
	    <?php endwhile; ?>

    </div>

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
	
	<section class="home-intro">

		<div class="home-intro-inner wrapper">
				
			<?php while(the_repeater_field('home_intro_modules')): ?>

	       		<div class="home-intro-module">

	       			<h2><?php the_sub_field('title'); ?></h2>

	       			<p><?php the_sub_field('text'); ?></p>

	       			<?php if (get_sub_field('image')) { ?>
	       				<img src="<?php the_sub_field('image'); ?>">
	       			<? } ?>
	       			
	       		</div>
		       
		    <?php endwhile; ?>

		</div>

	</section>

	<section class="home-news">

		<div class="home-news-inner wrapper">

			<h2><?php the_field('startseite_fellows_headline'); ?></h2>

			<?php the_field('startseite_fellows_intro'); ?>

				<div class="home-news-row">

					<?php 
					$posts = get_field('startseite_fellows_selection');

					if( $posts ): ?>

					    <?php foreach( $posts as $post): ?>
					        <?php setup_postdata($post); ?>

					      	<article class="home-news-article">

  								<div class="home-news-article-inner mh" data-mh="home-news">

  									<?php if ( has_post_thumbnail() ) { ?>
  									  	<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
  									  	<img src="<?php echo $image[0]; ?>" class="solution-image">
  									<?php } ?>

  									<h3><a href="<?php the_permalink(); ?>" class="title-link"><?php the_title(); ?></a></h3>

  									<?php the_content(); ?>

  									<a href="<?php the_permalink(); ?>" class="btn"><?php pll_e('Learn more'); ?></a>

  								</div>

  							</article>

					    <?php endforeach; ?>

					<?php wp_reset_postdata(); ?>
					<?php endif; ?>

				</div>

		</div>

	</section>



</main>

<?php endwhile; ?>
<!-- end main loop -->

<? get_footer(); ?>
