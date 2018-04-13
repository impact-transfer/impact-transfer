<?php get_header(); ?>

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

          <figcaption><?php $lines = explode("<br />",  get_the_title() );  
                foreach($lines as $line) {
                    $title = "<span class='break-line'><span class='inline'>" . $line . "</span></span>";
                    echo $title;
                } ?>
          </figcaption>
          
       </figure>
       
    <?php endwhile; ?>

</div>

<main>

	<div class="fellow-hero wrapper" id="fellow-hero">

<!--     <?php if ( has_post_thumbnail() ) { ?>
		  	<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
		  	<img src="<?php echo $image[0]; ?>" class="fellow-hero-image">
		<?php } ?>

		<div class="fellow-hero-text">
			
			<h2><span class="inline"><?= the_title(); ?></span></h2>

		</div> -->

    <div class="fellow-hero-field">
      
        <div>
           <img src="<?= get_template_directory_uri() ?>/assets/images/illus/ashoka-impact.svg">
           <div>
             <h4>Country</h4>
             <p><?php the_field('fellow_country'); ?></p>
           </div>
        </div>

        <div>
           <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/illus/impact_transfer_icon_exchange.svg">
           <div>
             <h4>Import/Export</h4>
             <p><?php the_field('solution_import_export'); ?></p>
           </div>
        </div>

        <div>
           <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/illus/impact_transfer_icon_topic.svg">
           <div>
             <h4>Topic</h4>
             <p><?php $term = get_field('solution_topic'); echo $term->name; ?></p>
           </div>
        </div>

        <div>
           <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/illus/impact_transfer_icon_transfer.svg">
           <div>
             <h4>Transfer Model</h4>
             <p><?php the_field('solution_scaling_type'); ?></p>
           </div>
        </div>

        <div>
           <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/illus/impact_transfer_icon_status.svg">
           <div>
             <h4>Status</h4>
             <p><?php the_field('solution_status'); ?></p>
           </div>
        </div>

    </div>

  	</div>

  	<section class="fellow-quote wrapper" id="fellow-quote">

  		<?php the_content(); ?>

  	</section>

  	<section class="fellow-texts" id="fellow-texts">

  		<div class="fellow-texts-inner wrapper">
  		   	  
            <?php if (get_field('solution_text_solution')):  ?>

    		       <div class="fellow-text-item mh" data-mh="fellow-text-item">

    		       		<img src="<?= get_template_directory_uri() ?>/assets/images/illus/ashoka-idea.svg">

    		       		<div class="fellow-text-item-text">

    		       			<h3>Solution</h3>

    		       			<p><?php the_field('solution_text_solution'); ?></p>

    		       		</div>
    		          
    		       </div>

             <?php endif; ?>

             <?php if (get_field('solution_text_impact')):  ?>

  		       <div class="fellow-text-item mh" data-mh="fellow-text-item">

  		       		<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/illus/impact_transfer_icon_impact.svg">

  		       		<div class="fellow-text-item-text">

  		       			<h3>Impact</h3>

  		       			<p><?php the_field('solution_text_impact'); ?></p>

  		       		</div>
  		          
  		       </div>

             <?php endif; ?>

             <?php if (get_field('solution_text_goals')):  ?>

  		       <div class="fellow-text-item mh" data-mh="fellow-text-item">

  		       		<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/illus/impact_transfer_icon_goal.svg">

  		       		<div class="fellow-text-item-text">

  		       			<h3>Goals</h3>

  		       			<p><?php the_field('solution_text_goals'); ?></p>

  		       		</div>
  		          
  		       </div>

             <?php endif; ?>

             <?php if (get_field('solution_text_needs')):  ?>

  		       <div class="fellow-text-item mh" data-mh="fellow-text-item">

  		       		<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/illus/impact_transfer_icon_needs.svg">

  		       		<div class="fellow-text-item-text">

  		       			<h3>Needs</h3>

  		       			<p><?php the_field('solution_text_needs'); ?></p>

  		       		</div>
  		          
  		       </div>

             <?php endif; ?>

             <?php if (get_field('solution_text_model')):  ?>

  		       <div class="fellow-text-item mh" data-mh="fellow-text-item">

  		       		<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/illus/impact_transfer_icon_transfer.svg">

  		       		<div class="fellow-text-item-text">

  		       			<h3>Transfer Model</h3>

  		       			<p><?php the_field('solution_text_model'); ?></p>

  		       		</div>
  		          
  		       </div>

             <?php endif; ?>

             <?php if (get_field('fellow_text_contact')):  ?>

  		       <div class="fellow-text-item mh" data-mh="fellow-text-item">

  		       		<img src="<?= get_template_directory_uri() ?>/assets/images/illus/ashoka-information.svg">

  		       		<div class="fellow-text-item-text">

  		       			<h3>Further Info</h3>

  		       			<p><?php the_field('fellow_text_contact'); ?></p>

  		       		</div>
  		          
  		       </div>

             <?php endif; ?>
  		       
  		</div>

  	</section>

  	<section class="fellow-share wrapper" id="fellow-share">

	  	<div class="fellow-story-share">

		  	<h4>Share</h4>

		  	<ul class="sidebar-share">
		  		<li>
            <a href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="btn-share share-facebook" data-sharelink="<?php the_permalink(); ?>">
              <svg class="icon-share-facebook"><use xlink:href="#icon-share-facebook"></use></svg>
            </a>
          </li>
          <li>
            <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="btn-share share-gplus" data-sharelink="<?php the_permalink(); ?>">
              <svg class="icon-share-googleplus"><use xlink:href="#icon-share-googleplus"></use></svg>
            </a>
          </li>
          <li>
            <a href="https://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" class="btn-share share-twitter" data-sharelink="<?php the_permalink(); ?>">
              <svg class="icon-share-twitter"><use xlink:href="#icon-share-twitter"></use></svg>
            </a>
          </li>
          <li>
            <a href="mailto:?subject=Reading Recommendation&amp;body=Check out this article: Article Title http://mydomain.com/articletitle." class="btn-share" target="blank">
                <svg class="icon-share-email"><use xlink:href="#icon-share-email"></use></svg>
            </a>
          </li>
		  	</ul>

	  	</div>


  	</section>


</main>

<?php endwhile; ?>
<!-- end main loop -->

<? get_footer(); ?>