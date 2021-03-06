<?php
add_action( 'wp_enqueue_scripts', 'elyzium_load_bootstrap' );
/**
 * Enqueue Bootstrap.
 */
function elyzium_load_bootstrap() {
    //css
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style( 'bootstrap-css', '//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' );
  
    //js
    wp_enqueue_script( 'slim-js', '//code.jquery.com/jquery-3.3.1.slim.min.js', array( 'jquery' ), 1.0, true );
    wp_enqueue_script( 'popper-js', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ), 1.0, true );
    wp_enqueue_script( 'bootstrap-js', '//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array( 'jquery' ), 1.0, true );
    wp_enqueue_script('holder-js', get_template_directory_uri() . '/assets/js/holder.min.js', '', 1.0, true);
}


function elyzium_remove_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
       return array_diff( wp_dependencies_unique_hosts(), $hints );
    }

      return $hints;
}

add_filter( 'wp_resource_hints', 'elyzium_remove_dns_prefetch', 10, 2 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_theme_support( 'post-thumbnails' );

//remove some unnecessary tags in the header generated by wordpress
remove_action ('wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

function elyzium_new_image_sizes(){
 if ( function_exists( 'add_image_size' ) ) {
      add_image_size( 'item', 348, 225, array( 'center', 'center' ) );
      add_image_size( 'vue-item', 360, 360, array( 'center', 'center' ) );
 }
}
add_action('after_setup_theme', 'elyzium_new_image_sizes');

//change namespace for mini rest api
function mini_rest_prefix( $slug )
{ 
  return "ely";
}

add_filter( 'rest_url_prefix', 'mini_rest_prefix');

// register routes
function register_blog_rest_routes() {

//list page
  register_rest_route( 'api/v1', '/blog', array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => 'blog_list',
      'args'     => array(
          'query_args' => array(
              'default' => array(),
           ),
        ),
    ) );

}
add_action( 'rest_api_init', 'register_blog_rest_routes' );

//blogs callback function
//return rest_ensure_response( 'Hello World, this is the WordPress REST API' );
function blog_list( $request ) {

 $args = $request->get_query_params();

$blog_args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 3 
  );

  $standard_params = array(
      'order',
      'orderby',
      'author',
      'paged',
      'page',
      'nopaging',
      'posts_per_page',
      's',
      );


   foreach ( $standard_params as $standard_param ) {
        if ( isset( $args[ $standard_param ] ) && ! empty( $args[ $standard_param ] ) ) {
           $blog_args[ $standard_param ] = $args[ $standard_param ];
          }
      }

    
  $the_query = new WP_Query( $blog_args );


  $return = array(
      'total'          => (int) $the_query->found_posts,
      'count'          => (int) $the_query->post_count,
      'pages'          => (int) $the_query->max_num_pages,
      'posts_per_page' => (int) $blog_args['posts_per_page'],
      'query_args'     => $blog_args,
      'blog'       => array(),
      );


  if ( $the_query->have_posts() ):

        $i = 0;

        while ( $the_query->have_posts() ):
                $the_query->the_post();

                $title = get_the_title();
                $body  = get_the_content();
                 
                 $size = !empty($blog_args['s']) ? 'thumbnail' : 'vue-item';
                 $thumbnail = get_post_thumbnail_id( get_the_ID());
                if ( empty( $thumbnail ) ) {
                          $thumbnail = false;
                    } else {
                          $thumbnail = wp_get_attachment_image_src( $thumbnail, $size );
                          if ( is_array( $thumbnail ) ) {
                                  $thumbnail = array(
                                      'src'    => $thumbnail[0],
                                      'width'  => $thumbnail[1],
                                      'height' => $thumbnail[2],
                                );
                          }
                  }

                $date = get_the_date();

               $return['blog'][$i]['id'] = get_the_ID(); 
               $return['blog'][$i]['title'] = $title; 
               $return['blog'][$i]['body'] = $body; 
               $return['blog'][$i]['created'] = $date; 
               $return['blog'][$i]['thumbnail'] = $thumbnail; 

       $i ++;
 
      endwhile;
   
   wp_reset_postdata();
  
  endif;

$response = new WP_REST_Response( $return );
$response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
$response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
return $response;

}
