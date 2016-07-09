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
        add_action( 'add_meta_boxes', 'easyPages_custom_meta'  );
    }
    return $page_template;
}
#
#
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
function easyPages_jobs_Banner_Image( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'easyStaff_nonce2' );
  $easyPages_stored_meta_image = get_post_meta( $post->ID );
  ?>
  <p>
    <input type="text" name="meta-banner-image" id="banner-image" value="<?php if ( isset ( $easyPages_stored_meta_image['banner-image-upload'] ) ) echo $easyPages_stored_meta_image['banner-image-upload'][0]; ?>" />
    <input type="button" id="banner-image-upload" class="button" value="<?php _e( 'Choose or Upload an Image', 'easyPages-textdomain' )?>" />
  </p>
  <?php
}


//Add our meta boxes to the actual editor
function easyPages_custom_meta() {
      add_meta_box(
      'easyPages', // $id
       __( 'Banner Image', 'easyPages-job-banner' ), // $title
      'easyPages_jobs_Banner_Image', // $callback
      'page', // $page
      'side', // $context
      'low'
      ); // $priority
}
