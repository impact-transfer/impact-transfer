<?php
/**
 * Template Name: About
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

	<section class="team-country" id="team">
	  
	  <h2><?php pll_e('Unser Team'); ?></h2>
	  
	  <div class="people-grid">
	    
	    <?php $my_query = new WP_Query( array( 'posts_per_page' => 40, 'post_type' => 'team' )); 
	        while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
	      
	      <div class="people-grid-item" id="<?php echo $post->post_name;?>">

	        <div class="people-grid-item-inner">

	          <?php if ( has_post_thumbnail() ) { ?>
	            <?php the_post_thumbnail( 'thumbnail' ); ?>
	          <?php } else { ?>
              <img src="<?= get_template_directory_uri() ?>/assets/images/ashoka_placeholder.png">
	          <?php } ?>

	          <div class="people-grid-item-text">

	          	<div class="people-grid-item-text-inner">

		            <h3>
		              <?php the_title(); ?>
		            </h3>

		            <p class="people-grid-item-function"><?php the_field('team_member_function'); ?></p>

	        	</div>
	            
	          </div>

	        </div>

	      </div>
	    
	    <?php endwhile; ?>

	    <?php wp_reset_postdata(); ?>

	  </div>

	</section>

		<?php

		// check if the flexible content field has rows of data
		if( have_rows('ashoka_partner') ):

		     // loop through the rows of data
		    while ( have_rows('ashoka_partner') ) : the_row();

		        if( get_row_layout() == 'headline_logos' ): ?>

		        	<section class="partner">

		        		<div class="partner-inner wrapper">
		        			
		        			<h2><?php the_sub_field('headline'); ?></h2>

		        			<p><?php the_sub_field('intro'); ?></p>

		        			<ul class="partner-logos">
		        				
	        					<?php while(the_repeater_field('partner_logos')): ?>
	        				   	
	        				       <li class="partner-logo">

	        				       		<a href="<?php the_sub_field('url'); ?>" target="_blank">
	        				       			<img src="<?php the_sub_field('logo'); ?>">
	        				       		</a>
	        				          
	        				       </li>
	        				       
	        				    <?php endwhile; ?>

		        			</ul>

		        		</div>

		        	</section>

		        <? elseif( get_row_layout() == 'headline_thumbnails' ): ?>

		        	<section class="partner">

		        		<div class="partner-inner wrapper">
		        			
		        			<h2><?php the_sub_field('headline'); ?></h2>

		        			<p><?php the_sub_field('intro'); ?></p>

	                    </div>

		        			<div class="people-grid">
		        				
	        					<?php 

	        					$posts = get_sub_field('partner_selection');

	        					if( $posts ): ?>
	        					    
	        					    <?php foreach( $posts as $post): ?>
	        					        <?php setup_postdata($post); ?>

	        					        <div class="people-grid-item">

	                                        <div class="people-grid-item-inner">
	        					            	
	                                            <?php if ( has_post_thumbnail() ) { ?>
	                                                <?php the_post_thumbnail( 'thumbnail' ); ?>
	                                            <?php } else { ?>
	                                                
	                                                <img src="<?= get_template_directory_uri() ?>/assets/images/ashoka_placeholder.png">
	                                                
	                                            <?php } ?>
	                                            
	                                            <div class="people-grid-item-text">

	                                                <div class="people-grid-item-text-inner">
	                                                
	                                                    <!-- <div class="people-grid-item-quote">
	                                                        <?php the_content(); ?>
	                                                    </div> -->
	                                                    <h3><?php the_title(); ?></h3>
	                                                    <?php if (get_field('partner_function')): ?>
	                                                        <p class="people-grid-item-function"><?php the_field('partner_function'); ?></p>
	                                                    <?php endif; ?>

	                                                </div>

	                                            </div>
	                                            
	        					            </div>
	        					            
	        					        </div>

	        					    <?php endforeach; ?>
	        					  

	        					    <?php wp_reset_postdata(); ?>
	        					<?php endif; ?>

		        			</div>

		        	</section>

		        <? endif;

		    endwhile;

		endif;

		?>

	<section class="about-contact" id="about-contact">

		<div class="about-contact-inner wrapper">
			
			<h2><?php the_field('contact_headline'); ?></h2>

			<ul class="about-contact-list">

				<?php while(the_repeater_field('contact_infos')): ?>
						   	
			       <li class="menu-item">

			       		<img src="<?php $image = get_sub_field('contact_image'); $full = wp_get_attachment_image_src( $image, 'thumbnail' ); echo $full[0]; ?>">
			       		
			       		<address>

			       			<h4><?php the_sub_field('country_name'); ?></h4>

			       			<?php the_sub_field('contact_text'); ?>

			       		</address>
			          
			       </li>
			       
			    <?php endwhile; ?>
			</ul>

		</div>

	</section>

	<div id="overlay" class="overlay">

		<div class="overlay-inner">
								
			<button type="button" class="overlay-close">
				<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" version="1.1">
				  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				    <g id="Ashoka_Desktop_FellowOverlay" transform="translate(-1065.000000, -386.000000)" stroke-linecap="round" stroke="#FFFFFF" stroke-width="2">
				      <g id="Fellow-Overlay" transform="translate(324.000000, 358.000000)">
				        <g id="close" transform="translate(742.000000, 29.000000)">
				          <path d="M19.5 0.5L0.4 19.6" id="Line"/>
				          <path d="M19.5 0.5L0.4 19.6" id="Line-2" transform="translate(10.000000, 10.000000) scale(-1, 1) translate(-10.000000, -10.000000) "/>
				        </g>
				      </g>
				    </g>
				  </g>
				</svg>
			</button>

			<div id="overlay-content" class="overlay-content">

			</div>

		</div>
								
	</div>

</main>

<?php endwhile; ?>
<!-- end main loop -->

<? get_footer(); ?>
