<?php get_header(); ?>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="easyPagesCareer-page-banner">
    <h1><?php echo the_title(); ?></h1>
</div>

<div class="easyPagesCareer-job-information">
  <div class="easyPagesCareer-wrapper">
    <div class="easyPages-job-content">
      <?php $job_description = get_post_meta( $post->ID, 'easyPagesJobsLookingFor', true );
      if ($job_description != null) { ?>
        <h2>What we are looking for:</h2>
        <div class="block">
          <?php echo $job_description; ?>
        </div>
      <?php
      }else{
        echo "<h2>Sadly, we have no information about this job!</h2>";
      } ?>
      <?php $what_we_offer = get_post_meta( $post->ID, 'easyPagesWhatWeOffer', true );
      if ($what_we_offer != null) { ?>
        <h2>What we offer:</h2>
        <div class="block">
          <?php echo $what_we_offer; ?>
        </div>
      <?php
      }else{
      } ?>



      <form class="easyPages-job-application" id="job_application_form" action="<?php echo site_url(); ?>/wp-content/plugins/easypages-careers/assets/jobs_application_mailer.php" method="post">
        <div class="half">
          <label for="full_name">Full Name:</label>
          <div class="input-container name">
            <input type="text" name="full_name" required id="easyPages_fullName" value="">
          </div>
        </div>
        <div class="half">
          <label for="user_email">Email Address:</label>
          <div class="input-container email">
            <input type="text" name="user_email" required id="easyPages_email" value="">
          </div>
        </div>
        <div class="half">
          <div class="upload-button cover-letter" id="cover_upload">
            Upload a cover letter
          </div>
          <input type="file" name="cv_upload" id="cover_upload_input" class="hidden_input" value="">
        </div>
        <div class="half">
          <div class="upload-button CV" id="CV_upload">
            Upload your CV
          </div>
          <input type="file" name="cv_upload" id="CV_upload_input" class="hidden_input" value="">
        </div>
        <div class="full">
          <div class="easyPagesSubmit">
            <button  class="button" name="name" value="Submit your application">Submit Your Application</button>
          </div>
        </div>
      </form>

    </div>

    <div class="easyPages-job-sidebar">
      <ul class="info">
        <li><span class="title">Job Title: </span><?php echo the_title(); ?></li>
        <li><span class="title">Location: </span>Manchester</li>
        <li><span class="title">Wage offered: </span> £25,000</li>
        <li><span class="title">Start Date: </span> ASAP</li>
      </ul>
      <div class="easyPages-job-apply">
        Apply Now
      </div>
    </div>
  </div>


</div>

<?php endwhile; ?>

<?php else : ?>

<?php endif; ?>

<?php get_footer(); ?>
