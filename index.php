<?php
/*
 * Plugin Name: EasyPages Jobs
 * Plugin URI:
 * Description: This plugin will allow you to add a career's page to any existing Wordpress website. You have the ability to quickly add and edit jobs, along with a single job information page and the ability to apply via your website.
 * Version: 1.0.0
 * Author: Allan McKernan
 * Author URI: https://twitter.com/WebOcelot
 * License: GPL2
 */


 ##########################################################
 ##### Add our Styles and Our Javascript to Wordpress #####
 ##########################################################
 function easyPagesJobsStyles() {
   //Insert our stylesheet
   //echo "<link rel='stylesheet'  href='/wp-content/plugins/easyfaq/assets/main.css' type='text/css' media='all'>";
   wp_register_style( 'easyPagesJobsStyles', plugins_url( '/assets/main.css', __FILE__ ), array(), '20120208', 'all' );
   wp_enqueue_style('easyPagesJobsStyles');
 }
add_action( 'wp_enqueue_scripts', 'easyPagesJobsStyles' );

//Hook in the Meta for the image upload
function easyJobs_JS($post) {
    global $post;
    if ($post->post_type == "easypages_jobs"){
        wp_enqueue_media();
        wp_register_script( 'job_application_script' , plugin_dir_url( __FILE__ ) . '/assets/job_application.js', array( 'jquery' ), NULL, false );
        wp_enqueue_script( 'job_application_script'  );
    }
}
add_action( 'the_post',  'easyJobs_JS'  );
 
############################################################
#
#
#
#
#
#
#
#
#
#
#
###############################################
##### Create Custom Post Type for our Job Listings #####
###############################################
function easyPagesJobsPostType() {
	$labels = array(
		'name'               => _x( 'Jobs', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Job', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Jobs', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Jobs', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New Position', 'Job', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Position', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Job', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Job', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Job', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Jobs', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Jobs', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Jobs found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Jobs found in trash. (sweet!)', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
    'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'jobs' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
    'menu_icon'          => 'dashicons-businessman',
		'supports'           => array( 'title', 'editor', 'author', 'custom-fields' , 'excerpt', 'thumbnail')
	);
	register_post_type( 'easyPages_jobs', $args );
}
add_action( 'init', 'easyPagesJobsPostType' );
########################################################
#
#
#
#
#
#
#
#
#
#
#######################################################
##### Make the custom "Careers" page and template ####
#######################################################
add_filter( 'page_template', 'easyPagesJobsTemplate' );
function easyPagesJobsTemplate( $page_template )
{
    if ( is_page( 'jobs' ) || is_page( 'careers' ) ) {
        $page_template = dirname( __FILE__ ) . '/assets/page-template-careers.php';
    }
    return $page_template;
}
#
########################################################
##### Create the single post type page for the jobs
########################################################
function easyPagesCustomSingle($single) {
    global $wp_query, $post;
    /* Checks for single template by post type */
    if ($post->post_type == "easypages_jobs"){
      return plugin_dir_path( __FILE__ ) . '/assets/single-job.php';
    }else{
      echo $post->post_type;
    }
    return $single;
}
add_filter('single_template', 'easyPagesCustomSingle');
#########################################################
#
#
#
#
#
#
#
#######################################################################
###### Register any Meta inputs on the page templates #################
#######################################################################
function easyPages_jobs_meta_box_markup($post){
  wp_nonce_field( basename( __FILE__ ), 'easyPages_jobs_nonce' );
  //Get any existing metadata attached to this post and store it
  $easyPages_meta = get_post_meta( $post->ID );

  var_dump($easyPages_meta);?>
  <div class="custom-banner-upload">
    <input type="text" name="banner-image" id="banner-image" value="<?php if ( isset ( $easyPages_meta['banner-image'] ) ) echo $easyPages_meta['banner-image'][0]; ?>" />
  </div>


  <?php
  #Job Description
  if ( isset ( $easyPages_meta['easyPagesJobsLookingFor'])){
    //If it has content, pop it in
    $content1 = $easyPages_meta['easyPagesJobsLookingFor'][0];
  }else{
    //Else, we will give the user a hint
    $content1 = "Provide an indepth description of what your ideal employee will be like, what skills will they have?";
  }
  wp_editor( $content1, 'easyPagesJobsLookingFor' );


  #What we offer
  if ( isset ( $easyPages_meta['easyPagesWhatWeOffer'])){
    //If it has content, pop it in
    $content2 = $easyPages_meta['easyPagesWhatWeOffer'][0];
  }else{
    //Else, we will give the user a hint
    $content2 = "Provide an indepth description of what you can offer - why should they work here?";
  }
  wp_editor( $content2, 'easyPagesWhatWeOffer' );

}

function add_custom_meta_box()
{
    add_meta_box("primary-meta-container", "Job Writeup", "easyPages_jobs_meta_box_markup", "easyPages_jobs", "normal", "high", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");





function save_custom_meta($post_id)
{
    if (!isset($_POST["easyPages_jobs_nonce"]) || !wp_verify_nonce($_POST["easyPages_jobs_nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE){
        return $post_id;
    }


    if(isset( $_POST['banner-image'])){
      update_post_meta( $post_id, 'banner-image', $_POST[ 'banner-image' ] );
    }
    if(isset( $_POST['easyPagesJobsLookingFor'])){
      update_post_meta( $post_id, 'easyPagesJobsLookingFor', $_POST[ 'easyPagesJobsLookingFor' ] );
    }
    if(isset( $_POST['easyPagesWhatWeOffer'])){
      update_post_meta( $post_id, 'easyPagesWhatWeOffer', $_POST[ 'easyPagesWhatWeOffer' ] );
    }




}


add_action("save_post", "save_custom_meta", 10 , 10);
