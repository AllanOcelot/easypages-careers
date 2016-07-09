<?php get_header(); ?>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="easyPagesCareer-page-banner">
    <h1><?php echo the_title(); ?></h1>
</div>

<div class="easyPagesCareer-job-information">
  <div class="easyPagesCareer-wrapper">
    <div class="easyPages-job-content">
      <?php echo the_content(); ?>
    </div>
    <div class="easyPages-job-sidebar">
      <ul class="info">
        <li><span class="title">Job Title: </span><?php echo the_title(); ?></li>
        <li><span class="title">Wage offered: </span> £25,000</li>
        <li><span class="title">Start Date: </span> ASAP</li>
      </ul>
    </div>
  </div>
</div>

<?php endwhile; ?>

<?php else : ?>

<?php endif; ?>

<?php get_footer(); ?>
