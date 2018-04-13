<?php get_header(); ?>

<!-- start main loop -->
<?php while (have_posts()) : the_post(); ?>

<main>

	<div class="fellow-hero wrapper" id="fellow-hero">

    <?php if ( has_post_thumbnail() ) { ?>
        <div class="fellow-hero-image" data-mh="role-hero">
          <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
          <img src="<?php echo $image[0]; ?>">
        </div>
    <?php } ?>

    <div class="fellow-hero-text" data-mh="role-hero">
			
      <h2>
      <?php $lines = explode(" ",  get_the_title());  
      foreach($lines as $line) {
          $title = "<span class='break-line'><span class='inline'>" . $line . "</span></span>";
          echo $title;
      } ?>
      </h2>

		</div>

  	</div>

  	<section class="fellow-quote wrapper" id="fellow-quote">

  		<?php the_content(); ?>

  	</section>

    <section class="fellow-texts" id="fellow-texts">

  	   <div class="fellow-texts-inner wrapper">
         
         <?php while(the_repeater_field('role_modules')): ?>

              <div class="role-text-module">

                <h2><?php the_sub_field('title'); ?></h2>

                <p><?php the_sub_field('text'); ?></p>
                
              </div>
             
          <?php endwhile; ?>

       </div>

  	</section>

</main>

<?php endwhile; ?>
<!-- end main loop -->

<? get_footer(); ?>