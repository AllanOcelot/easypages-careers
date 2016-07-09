<?php
/*
 Template Name: Custom Page Example
 */
 ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
 <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<div class="easyPagesCareer-page-banner">
    <h1><?php echo the_title(); ?></h1>
</div>
<div class="easyPagesCareer-introduction">
  <div class="easyPagesCareer-wrapper">
    <?php echo the_content(); ?>
  </div>
</div>

<!-- Company photos , if full screen do not display the wrapper -->
<div class="easyPagesCareer-companyPhotos">
  <img src="http://i.imgur.com/2yu7seo.png" alt="Example" draggable="false" />
  <img src="http://i.imgur.com/2yu7seo.png" alt="Example" draggable="false"/>
  <img src="http://i.imgur.com/2yu7seo.png" alt="Example" draggable="false"/>
</div>


<!-- Current position container -->
<div class="easyPagesCareer-currentPositions">
    <div class="easyPagesCareer-wrapper">
        <h3>Current Positions:</h3>
        <?php
          $args = array(
          	'post_type' => 'easyPages_jobs',
            'posts_per_page' => '-1'
          );

          $the_query = new WP_Query( $args );

          // Loop Over Results
          if ( $the_query->have_posts() ) {
            echo '<ul class="current-positions">';
            while ( $the_query->have_posts() ) {
          		$the_query->the_post();
              echo "<li>";
              echo "<a href='". get_the_permalink()  ."' class='role-title'>". get_the_title() ."</a>";
              echo the_excerpt();
              echo "<a href='". get_the_permalink() ."' class='read-more-button'>Read More</a>";
              echo "</li>";
               }
            echo "</ul>";
          } else {
            echo "<h4>We have no current vacancies.</h4>";
           }
          /* Restore original Post Data */
          wp_reset_postdata();
        ?>
    </div>
</div>

<?php endwhile; ?>

<?php else : ?>

<?php endif; ?>

<?php get_footer(); ?>
