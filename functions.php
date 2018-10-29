<?php 
if ( ! defined( 'WP_DEBUG' ) ) {
	die( 'Direct access forbidden.' );
}

include_once get_template_directory() . '/theme-includes/init.php';

add_theme_support( 'post-thumbnails' );

include_once "wxBizDataCrypt.php";


/** added by alex **/

//change namespace for mini rest api
function mini_rest_prefix( $slug )
{ 
  return "mini";
}

add_filter( 'rest_url_prefix', 'mini_rest_prefix');

// register routes
function register_projects_rest_routes() {

//list page
  register_rest_route( 'api/v1', '/projects', array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => 'projects_list',
      'args'     => array(
          'query_args' => array(
              'default' => array(),
           ),
        ),
    ) );

//list page
  register_rest_route( 'api/v1', '/get-collection', array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => 'get_collection',
      'args'     => array(
          'query_args' => array(
              'default' => array(),
           ),
        ),
    ) );

//comments page
  register_rest_route( 'api/v1', '/comments', array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => 'wechat_get_comments',
      'args'     => array(
          'query_args' => array(
              'default' => array(),
           ),
        ),
    ) );


//project detail page

register_rest_route( 'api/v1', '/projects/(?P<id>\d+)', array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'projects_detail',
		'args'     => array(
			'id' => array(
				'validate_callback' => function ( $param, $request, $key ) {

					if( ! is_numeric( $param ) ){
						return new WP_Error( 'project_bad_post_id', __('Invalid post ID format. Please pass an integer.'), array( 'status' => 400 ) );
					}

					$post_id = (int) $param;

					if ( false === get_post_status( $post_id ) || 'project' !== get_post_type( $post_id ) ) {
						return new WP_Error( 'project_bad_post_id', __( 'Invalid project post ID.' ), array( 'status' => 400 ) );
					}

					return true;
				}
			),
		),
	) );


// project like total 

register_rest_route( 'api/v1', '/like/projects/(?P<id>\d+)', array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'projects_like',
		'args'     => array(
			'id' => array(
				'validate_callback' => function ( $param, $request, $key ) {

					if( ! is_numeric( $param ) ){
						return new WP_Error( 'project_bad_post_id', __('Invalid post ID format. Please pass an integer.'), array( 'status' => 400 ) );
					}

					$post_id = (int) $param;

					if ( false === get_post_status( $post_id ) || 'project' !== get_post_type( $post_id ) ) {
						return new WP_Error( 'project_bad_post_id', __( 'Invalid project post ID.' ), array( 'status' => 400 ) );
					}

					return true;
				}
			),
		),
	) );

// project collerct total

// project like total 

register_rest_route( 'api/v1', '/collection/projects/(?P<id>\d+)', array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'projects_collection',
		'args'     => array(
			'id' => array(
				'validate_callback' => function ( $param, $request, $key ) {

					if( ! is_numeric( $param ) ){
						return new WP_Error( 'project_bad_post_id', __('Invalid post ID format. Please pass an integer.'), array( 'status' => 400 ) );
					}

					$post_id = (int) $param;

					if ( false === get_post_status( $post_id ) || 'project' !== get_post_type( $post_id ) ) {
						return new WP_Error( 'project_bad_post_id', __( 'Invalid project post ID.' ), array( 'status' => 400 ) );
					}

					return true;
				}
			),
		),
	) );





//project taxonomy list page url
  register_rest_route( 'api/v1', '/project-tax', array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => 'project_tax_list',
      'args'     => array(
          'query_args' => array(
              'default' => array(),
           ),
        ),
    ) );

//project taxonomy detail page url
register_rest_route( 'api/v1', '/project-tax/(?P<id>\d+)', array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'project_tax_detail',
		'args'     => array(
			'id' => array(
				'validate_callback' => function ( $param, $request, $key ) {

					if( ! is_numeric( $param ) ){
						return new WP_Error( 'project_bad_taxonomy', __('Invalid term id format. Please pass an integer.'), array( 'status' => 400 ) );
					}

					$term_id = (int) $param;

					if ( !term_exists($term_id, 'project_tax') ) {
						return new WP_Error( 'project_bad_taxonomy', __( 'Invalid project taxonomy ID.' ), array( 'status' => 400 ) );
					}

					return true;
				}
			),
		),
	) );

//weixin user functionaliy url
  register_rest_route( 'api/v1', '/wechat/user', array(

      'methods'  => WP_REST_Server::EDITABLE,
      'callback' => 'wechat_user_get',
      'args'     => array(
          'query_args' => array(
          'default' => array(),
           ),
        ),
    ) );

//weixin comments functionaliy url
  register_rest_route( 'api/v1', '/comments/add', array(

      'methods'  => WP_REST_Server::EDITABLE,
      'callback' => 'comments_add',
      'args'     => array(
          'query_args' => array(
          'default' => array(),
           ),
        ),
    ) );




//weixin user functionaliy url
  register_rest_route( 'api/v1', '/wechat/checksession', array(

      'methods'  => WP_REST_Server::EDITABLE,
      'callback' => 'wechat_user_check_session',
      'args'     => array(
          'query_args' => array(
          'default' => array(),
           ),
        ),
    ) );


//weixin user functionaliy url
  register_rest_route( 'api/v1', '/wechat/new-user', array(

      'methods'  => WP_REST_Server::EDITABLE,
      'callback' => 'wechat_new_user',
      'args'     => array(
          'query_args' => array(
          'default' => array(),
           ),
        ),
    ) );


}

add_action( 'rest_api_init', 'register_projects_rest_routes' );




//projects callback function
//return rest_ensure_response( 'Hello World, this is the WordPress REST API' );
function projects_list( $request ) {


  $args = $request->get_query_params();

$project_args = array(
    'post_type'           => 'project',
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
           $project_args[ $standard_param ] = $args[ $standard_param ];
            }
      }

    
  $the_query = new WP_Query( $project_args );


  $return = array(
      'total'          => (int) $the_query->found_posts,
      'count'          => (int) $the_query->post_count,
      'pages'          => (int) $the_query->max_num_pages,
      'posts_per_page' => (int) $project_args['posts_per_page'],
      'query_args'     => $project_args,
      'featured'      => empty($args) ? get_slider_projects() : '',
      'project'       => array(),
      );


  if ( $the_query->have_posts() ):

        $i = 0;

        while ( $the_query->have_posts() ):
                $the_query->the_post();

                $title = get_the_title();
                $body  = get_the_content();
                 
                 $size = !empty($project_args['s']) ? 'medium' : 'thumbnail';
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

                $fields = get_fields(get_the_ID());
                $comments_query = new WP_Comment_Query;

                 foreach( $fields as $k => $v){
            
                  $comments = $comments_query->query(['post_id' => get_the_ID(), 'status' => 'approve', 'post_type' => 'project']);
                  
                     $return['project'][$i]['id'] = get_the_ID(); 
                     $return['project'][$i]['comments'] = count($comments); 
                     $return['project'][$i]['title'] = $title; 
                     $return['project'][$i]['body'] = $body; 
                     $return['project'][$i]['created'] = $date; 
                     $return['project'][$i]['thumbnail'] = $thumbnail; 

                     $return['project'][$i][$k] = get_field($k, get_the_ID());

                  }

       $i ++;
 
      endwhile;
   
   wp_reset_postdata();
  
  endif;

$response = new WP_REST_Response( $return );
$response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
$response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
return $response;

}


//get slider project for homepage

function get_slider_projects(){

  $sliders = array();

 $slider_args= array (
     'post_type' => 'project',
     'post_status'    => 'publish',
     'posts_per_page' => 5,
     'meta_query' => array(
       array(
         'key'     => 'slider_bool',
         'compare'   => '=',
         'value'   => TRUE
       ),
     )
   );
  

  $the_query = new WP_Query( $slider_args );

  if ( $the_query->have_posts() ):

        $i = 0;

        while ( $the_query->have_posts() ):
                $the_query->the_post();

                $title = get_the_title();
                $body  = get_the_content();
                $date = get_the_date();
                $fields = get_fields(get_the_ID());

                 foreach( $fields as $k => $v){

                     $sliders[$i]['id'] = get_the_ID(); 
                     $sliders[$i]['title'] = $title; 
                     $sliders[$i]['body'] = $body; 
                     $sliders[$i]['created'] = $date; 

                     $sliders[$i][$k] = get_field($k, get_the_ID());
                }

       $i ++;
 
      endwhile;
   
   wp_reset_postdata();
  
  endif;

 return $sliders;
}





// get term name 
function mini_get_term_name_by_pid( $pid ){
 
 $terms = get_the_terms( $pid,  'project_tax' );

if ( $terms && ! is_wp_error( $terms ) ){ 
   
       $p_terms = array();
        
        foreach ( $terms as $term ) {
              $p_terms[] = $term->name;
         }
     $p_term = join( ", ", $p_terms );
 
  return $p_term;
 } else {
 return '';
 //return $p_terms;
  }
}


//get term ids of a post by post id

function mini_get_term_id_by_pid( $pid ){
 
 $terms = get_the_terms( $pid,  'project_tax' );

if ( $terms && ! is_wp_error( $terms ) ){ 
   
       $p_terms = array();
        
        foreach ( $terms as $term ) {
              $p_terms[] = $term->term_id;
         }
 
  return $p_terms;
 } else {
 return [];
 //return $p_terms;
  }
}

//function: get related post by pid based on same taxonomy

function get_related_projects( $pid ){
 
    $related = array();

    $args = array(
      'post_type' => 'project',
      'post_status' => 'publish',
      'posts_per_page'  => 4,
      'post__not_in' => array($pid),
      'tax_query' => array(
          array(
          'taxonomy' => 'project_tax',
          'field'    => 'term_id',
          'terms'    => mini_get_term_id_by_pid($pid)
          ),
        ),
      );

      $query = new WP_Query( $args );

      if( $query->have_posts() ){

          while( $query->have_posts()){

            $query->the_post();
   
         $thumbnail = get_post_thumbnail_id(); 
        if ( empty( $thumbnail ) ) {
                  $thumbnail = false;
            } else {
                  $thumbnail = wp_get_attachment_image_src( $thumbnail, 'medium' );
                  if ( is_array( $thumbnail ) ) {
                          $thumbnail = array(
                              'src'    => $thumbnail[0],
                              'width'  => $thumbnail[1],
                              'height' => $thumbnail[2],
                        );
                  }
          }
 


            $related[] = array(
              'id' => get_the_ID(),
              'title' => get_the_title(),
              'thumbnail' => $thumbnail
            );

         }
      
        wp_reset_postdata();

     }

return $related;
}


//project detail page
function projects_detail( $request ) {

  $post_id = (int) $request['id'];
	global $post;
	$post = get_post( $post_id );
	setup_postdata( $post );

	if ( null !== $post ) {
    
    $read_data = (int)get_field('read_data');
    update_field('read_data', ++$read_data);

    
    $return = array();

     $title = get_the_title();
     $body  = get_the_content();
     $date = get_the_date();

      $thumbnail = get_post_thumbnail_id(); 
        if ( empty( $thumbnail ) ) {
                  $thumbnail = false;
            } else {
                  $thumbnail = wp_get_attachment_image_src( $thumbnail, 'thumbnail' );
                  if ( is_array( $thumbnail ) ) {
                          $thumbnail = array(
                              'src'    => $thumbnail[0],
                              'width'  => $thumbnail[1],
                              'height' => $thumbnail[2],
                        );
                  }
          }

   $return['project']['id'] = $post_id; 
   $return['project']['title'] = $title; 
   $return['project']['body'] = $body; 
   $return['project']['created'] = $date; 
   $return['project']['thumbnail'] = $thumbnail; 
   $return['project']['taxonomy'] = mini_get_term_name_by_pid( $post_id );

    $fields = get_fields(get_the_ID());

     foreach( $fields as $k => $v){

        $return['project'][$k] = get_field($k, get_the_ID());
        }

		wp_reset_postdata( $post );
   $return['related'] = get_related_projects(get_the_ID());
	}

$response = new WP_REST_Response( $return );
$response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
$response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
return $response;

}


//project taxonomy list page
function project_tax_list( $response){
 
$terms = get_terms([
  'taxonomy' => 'project_tax',
  'hide_empty' => false,
]);

$return = array();
$term = array();

foreach( $terms as $k){

$image = get_field('tax_project_bg', 'term_' . $k->term_id);

  $term = array(
    'id' => $k->term_id,
    'desc' => htmlspecialchars_decode($k->description),
    'name' => esc_html($k->name),
    'link' => get_term_link($k->slug, 'project_tax'),
    'background' => $image['url']
    );

 $return[] = $term; 
 }

$response = new WP_REST_Response( $return );
$response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
$response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
return $response;
 

}


//project taxonomy detail page

function project_tax_detail( $request ){

  $term_id = (int)$request['id'];
  $return = array();

  $term = get_term_by('id', $term_id, 'project_tax');

  $return['term'] =  [
      'name' => $term->name,
      'description' => htmlspecialchars_decode($term->description)
    ];

  $args = array(
       'post_type' => 'project',
       'post_status' => 'publish',
       'orderby' => 'menu_order',
       'order'   => 'ASC',
       'tax_query' => array(
         array(
         'taxonomy' => 'project_tax',
         'field'    => 'term_id',
         'terms'    => array($term_id),
         ),
       ),
 
       'posts_per_page'  => -1
   );
 

     $query = new WP_Query( $args );
 
     $return['data'] = array(
            'total'          => (int) $query->found_posts,
            'count'          => (int) $query->post_count,
            'pages'          => (int) $query->max_num_pages,
            'posts_per_page' => (int) $args['posts_per_page'],
            'projects'       => array()
            );


     if( $query->have_posts() ){

           while( $query->have_posts()){
 
            $query->the_post();
          
             $thumbnail = get_post_thumbnail_id( get_the_ID());
            if ( empty( $thumbnail ) ) {
                      $thumbnail = false;
                } else {
                      $thumbnail = wp_get_attachment_image_src( $thumbnail, 'medium' );
                      if ( is_array( $thumbnail ) ) {
                              $thumbnail = array(
                                  'src'    => $thumbnail[0],
                                  'width'  => $thumbnail[1],
                                  'height' => $thumbnail[2],
                            );
                      }
              }


            $return['data']['projects'][] = array(

             'id' => get_the_ID(),
             'title' => get_the_title(),
             'date' => get_the_date(),
             'thumbnail' => $thumbnail
            );
         }
      
      wp_reset_postdata();
 }

 $response = new WP_REST_Response( $return );
$response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
$response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
return $response;
}


// wechat user id
function wechat_user_get( $request ){
  
  $code = $request['code']; 

  if( empty($code) ){
    return new WP_Error('error', __('invalid code'), array('status' => 404));
   }else{

       $appid = 'wxb38c09f64afa683f';
       $appsecret = '58b52a950bc43460c082f11b64b93143';
       $access_url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code";
      
       $access_r = wp_remote_get(esc_url_raw($access_url));

       if( !is_wp_error($access_r))
       {
         $access_arr = json_decode( wp_remote_retrieve_body( $access_r), true ); 

         if(!empty($access_arr)){

         $openid = $access_arr['openid'];
         $sessionKey = $access_arr['session_key'];
         
         $wp_session = json_encode(
                array(
                'expired_time' => strtotime("+20 days"),
                'session_key' => $sessionKey,
                'openid'      => $openid
          )
         );

         $session_3rd= md5($wp_session);

         add_option($session_3rd, $wp_session);
        
          if( !username_exists($openid) ){
           
            $pass = wp_generate_password( $length=12, $include_standard_special_chars=false);
            $user_id = wp_create_user( $openid, $pass);
    
            if( !is_wp_error( $user_id) ){
               wp_update_user(
                      array(
                      'ID'   => $user_id,
                      'nickename' => $openid
                      )
               );
              update_user_meta($user_id, 'session_key', $sessionKey);
              update_user_meta($user_id, 'openid', $openid);
              update_user_meta($user_id, 'login_count', 1);

              }

         } else {
           
           $user = get_user_by('login', $openid);
           $login_count = (int)get_user_meta($user->ID, 'login_count', true);
           update_user_meta($user->ID, 'login_count', ++$login_count);
           
           } 

       $result = ['session_3rd' => $session_3rd, 'openid' => $openid];
        }

       }


    $response = new WP_REST_Response( $result);
    $response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
    $response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
    return $response;
       
   }

 }



// check user session
function wechat_user_check_session( $request ){
  
    $session_3rd = $request['token'];
    $va = get_option($session_3rd);
    $wp_session = json_decode( $va);  

    if(!empty($session_3rd) && !empty( $wp_session) && $wp_session->expired_time > time() )
    {
      $result["code"]="success";
      $result["message"]= "openid , session_key already exit";
      $result["status"]="200";
      $result["expired"] = date('Y-m-d', $wp_session->expired_time); 
      $result["current"] = date('Y-m-d', time());
      
     $response = new WP_REST_Response( $result);
    $response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
    $response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
    return $response;
    }

}





// use wechat avatarurl name as user avatar on backend 
add_filter( 'get_avatar', 'cupp_avatar' , 1 , 5 );
function cupp_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

  $user = false;
  $id = false;

  if ( is_numeric( $id_or_email ) ) {
      $id = (int) $id_or_email;
      $user = get_user_by( 'id' , $id );

     } elseif ( is_object( $id_or_email ) ) {
         if ( ! empty( $id_or_email->user_id ) ) {
               $id = (int) $id_or_email->user_id;
               $user = get_user_by( 'id' , $id );
             }

     } else {
      // $id = (int) $id_or_email;
     $user = get_user_by( 'email', $id_or_email );   
    }


  if ( $user && is_object( $user ) ) {
      $custom_avatar = get_user_meta($id, 'avatar', true); 
       if (isset($custom_avatar) && !empty($custom_avatar)) {
       $avatar = "<img alt='{$alt}' src='{$custom_avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
      }
  }
  return $avatar;
}


function wechat_new_user( $request ){
 
       $encryptedData = $request['encryptedData'];
       $iv = $request['iv'];
       $appid = 'wxb38c09f64afa683f';

    if( !empty( $request['openid']) ){
      $user = get_user_by('login',  $request['openid']);
      $user_id = $user->ID;
      $sessionKey = get_user_meta($user->ID, 'session_key',  true);

      $pc = new WXBizDataCrypt($appid, $sessionKey);
      $errCode = $pc->decryptData($encryptedData, $iv, $data );

      if( $errCode == 0){
        $user_data = json_decode($data, true); 

          wp_update_user(
              array(
              'ID'    => $user_id,
              'display_name' => $user_data['nickName'],
              'user_nicename' => $user_data['nickName'],
              'first_name' => $user_data['nickName']
              )
          ) ;

          update_user_meta($user_id, 'last_name','~~'); 
          update_user_meta($user_id, 'avatar', $user_data['avatarUrl']);
          update_user_meta($user_id, 'country', $user_data['country']);

          $result["code"]="success";
          $result["message"]= "update user profile successfully";
          $result["status"]="200";
        } else {
          
          $result["code"]="fail";
          $result["message"]= "decrypt error";
          
          }
   
    } else {
      
          $result["code"]="fail";
          $result["message"]= "Didn't update user profile, openid is empty";
          $result["status"]="200";
    }

      $response = new WP_REST_Response( $result);
      $response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
      $response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
      return $response;

 }

// update  like count
 function projects_like( $request ){
    $post_id = (int) $request['id'];
//    $user_str = $request['user_id'];


    if($post_id){
  
      $like_data = get_field('like_data', $post_id);
      update_field('like_data', ++$like_data, $post_id);

  
      $result['like_data'] = $like_data; 
      $result['code'] = 'success';

      $response = new WP_REST_Response( $result);
      $response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
      $response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
      return $response;
  }

 }



// collection of user 
 function projects_collection( $request ){
    $post_id = $request['id'];
    $user_str = $request['user_str'];
    
    $user = get_user_by('login', $user_str);
    $avatar = get_user_meta($user->ID, 'avatar', true);
    $collect_post = get_user_meta($user->ID, 'collect_post', true);

    if($post_id && $user_str){

      //update collection_user on project detail page
      $collection_user = json_decode(get_field('collection_user', $post_id), true);

    if($collection_user){

      if( array_search( $user->ID, array_column($collection_user, 'id')) !== false )
      {
        $result['user'] = 'existed';

      }else{

         //update collection_data on project 
        $collection_data = get_field('collection_data', $post_id);
        update_field( 'collection_data', ++$collection_data, $post_id);

        $collection_user[] = [ 'id' => $user->ID , 'avatar'=> $avatar];
        update_field( 'collection_user', addslashes(json_encode($collection_user)), $post_id );
         $result['user'] = 'appended';

      }
     
     } else {
      //collection_user field null 

      update_field( 'collection_data', 1, $post_id);
      update_field( 'collection_user', addslashes(json_encode(array([ 'id' => $user->ID, 'avatar' => $avatar]))), $post_id );
      $result['user'] = 'created';
       
      }


       if( !$collect_post ){

         $data = array(
              'total' => 1,
              'pid'  => array($post_id)
             );

           update_user_meta($user->ID, 'collect_post', json_encode($data));
         } else {
         
             $curr = json_decode( $collect_post, true);
             
             if( !in_array( $post_id, $curr['pid'])){
               
             $curr['pid'][] = $post_id;
             $data = array(
                'total' => ++$curr['total'],
                'pid'    => $curr['pid']
             );
            update_user_meta($user->ID, 'collect_post', json_encode($data));
          }

       }
        


      

      $result['collection_data'] = get_field('collection_data', $post_id); 
      $result["collection_user"]= json_decode(get_field('collection_user', $post_id), true);

      $response = new WP_REST_Response( $result);
      $response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
      $response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
      return $response;
  }

 }




//get collection of a user

 function get_collection( $request ){
   
    $user_str = $request['user_id'];
    
    if( $user_str && $user = get_user_by('login', $user_str) ) 
    {
       $return = array();  
       $collect_post = get_user_meta($user->ID, 'collect_post', true);
      
        if( $collect_post ){
          
            $tmp = json_decode($collect_post, true);
            
            $return['total'] = $tmp['total'];
            $return['project'] = array_map(
                function($p){ return  array('id' => $p,'title' => get_the_title($p));}, 
                array_unique($tmp['pid'])
             );

          }


      $response = new WP_REST_Response( $return);
      $response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
      $response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
      return $response;
    }else{return ['alex' => 'china'];}

 }

 //comments add function 

 function comments_add( $request ){

   $parent = 0;
   $formId = '';

   $post_id = (int)$request['postId'];
   $comment = $request['comment'];
   

   if( isset($request['userLogin']) ){
   $user_str = $request['userLogin'];
    
   $user = get_user_by('login', $user_str);

   $user_first_name = get_user_meta($user->ID, 'first_name', true); 
   $avatar = get_user_meta($user->ID, 'avatar', true);
   }
  
    if( isset($request['formId']) && !empty($request['formId'])){
    $formId = $request['formId'];
    }


   if(isset($request['parent'])){
   $parent = (int)$request['parent'];
   }
    
    
    $commentdata = array(
      'comment_post_ID' => $post_id,
      'comment_author'  => $user_first_name,
      'comment_author_email' => $user_str . '@gmail.com',
      'comment_author_url'  => $avatar,
      'comment_content' => $comment,
      'comment_type' => '',
      'comment_parent' => $parent,
      'user_id' => $user->ID
    );

   $comment_id = wp_new_comment($commentdata);

  if($comment_id ){

      if($formId){
       add_comment_meta($comment_id, 'formId', $formId, false); 
       }
      $return['status'] = "200";
      $return['code'] = "sucess";
      $return['message'] = "comment was created successfully";
      $return['commentId'] = $comment_id;
  }else{ 
    $return['code'] = 'fail';
  }

$response = new WP_REST_Response( $return);
$response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
$response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
return $response;
}

// comments get

function wechat_get_comments( $request){
    
  $args = $request->get_query_params();
  
  $p_args = array(
      'status' => 'approve',
      'post_type' => 'project'
    );

   $standard = array(
      'post_id',
      'parent',
      'number'
   );


  if( isset($args['user_str']) && !empty($args['user_str']) && username_exists($args['user_str']) ) {
  
    $user = get_user_by('login', $args['user_str']);
    
     $p_args['user_id']  = $user->ID;
  }



 foreach( $standard as $st){
    if( isset( $args[$st]) && !empty( $args[$st])){
      $p_args[$st] = $args[$st];
    }
    
   }

  $result = array();

    //the query
    $comments_query = new WP_Comment_Query;
    $comments = $comments_query->query( $p_args );

    if($comments)
    {
        $result['total'] = count($comments);

          foreach( $comments as $comment){
    
            if($comment->comment_parent != 0)
            {
              $parent_name = get_parent_name($comment->comment_parent);
              }else{
                $parent_name = '';
              }

              $result['comments'][] = [
                 'author_url' => $comment->comment_author_url,
                 'id'         => $comment->comment_ID,
                 'post_id'   => $comment->comment_post_ID,
                 'author_name' => $comment->comment_author,
                 'userid'      => $comment->user_id,
                 'dateStr'    => date('Y-m-d', strtotime($comment->comment_date)),
                 'date'    => date('Y-m-d', strtotime($comment->comment_date)),
                 'summary' => $comment->comment_content,
                 'formId'   => get_comment_meta( $comment->comment_ID, 'formId', true),
                 'parent_name' => $parent_name,
                 'parent'     => $comment->comment_parent

              ]; 
            }

    }

  $response = new WP_REST_Response( $result);
$response->header( 'Access-Control-Allow-Origin', apply_filters( 'access_control_allow_origin', '*' ) );
$response->header( 'Cache-Control', 'max-age=' . apply_filters( 'api_max_age', WEEK_IN_SECONDS ) );
return $response;

  
}

//return parent author name 

function get_parent_name( $parent_id) {
  
  global $wpdb;
  
  $author_name = $wpdb->get_var(
      $wpdb->prepare(
      "SELECT `comment_author` FROM `wp_comments` WHERE `comment_ID` = %d", 
      $parent_id)
  );
  
  return $author_name;
  }
