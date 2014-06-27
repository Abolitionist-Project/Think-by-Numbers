<?php

/**
 * Check to see if a high five is being given, and if so, save it.
 *
 * Hooked to bp_actions, this function will fire before the screen function. We use our function
 * bp_is_course_component(), along with the bp_is_current_action() and bp_is_action_variable()
 * functions, to detect (based on the requested URL) whether the user has clicked on "send high
 * five". If so, we do a bit of simple logic to see what should happen next.
 *
 * @package BuddyPress_Course_Component
 * @since 1.6
 */


add_action('bp_activity_register_activity_actions','bp_course_register_actions');
function bp_course_register_actions(){
	global $bp;
	$bp_course_action_desc=array(
		'remove_from_course' => __( 'Removed a student from Course', 'vibe' ),
		'submit_course' => __( 'Student submitted a Course', 'vibe' ),
		'start_course' => __( 'Student started a Course', 'vibe' ),
		'submit_quiz' => __( 'Student submitted a Quiz', 'vibe' ),
		'start_quiz' => __( 'Student started a Course', 'vibe' ),
		'unit_complete' => __( 'Student submitted a Course', 'vibe' ),
		'reset_course' => __( 'Course reset for Student', 'vibe' ),
		'bulk_action' => __( 'Bulk action by instructor', 'vibe' ),
		'course_evaluated' => __( 'Course Evaluated for student', 'vibe' ),
		'student_badge'=> __( 'Student got a Badge', 'vibe' ),
		'student_certificate' => __( 'Student got a certificate', 'vibe' ),
		'quiz_evaluated' => __( 'Quiz Evaluated for student', 'vibe' ),
		'subscribe_course' => __( 'Student subscribed for course', 'vibe' ),
		);
	foreach($bp_course_action_desc as $key => $value){
		bp_activity_set_action($bp->activity->id,$key,$value);	
	}
}

add_filter( 'woocommerce_get_price_html', 'course_subscription_filter',100,2 );
function course_subscription_filter($price,$product){

	$subscription=get_post_meta($product->id,'vibe_subscription',true);

		if(vibe_validate($subscription)){
			$x=get_post_meta($product->id,'vibe_duration',true);

			$t=$x*86400;

			if($x == 1){
				$price = $price .'<span class="subs"> '.__('per','vibe').' '.tofriendlytime($t).'</span>';
			}else{
				$price = $price .'<span class="subs"> '.__('per','vibe').' '.tofriendlytime($t).'</span>';
			}
		}
		return apply_filters( 'woocommerce_get_price', $price );
}




add_action('woocommerce_after_add_to_cart_button','bp_course_subscription_product');
function bp_course_subscription_product(){
	global $product;
	$check_susbscription=get_post_meta($product->id,'vibe_subscription',true);
	if(vibe_validate($check_susbscription)){
		$duration=get_post_meta($product->id,'vibe_duration',true);	
		$t=tofriendlytime($duration*86400);
		echo '<div id="duration"><strong>'.__('SUBSCRIPTION FOR','vibe').' '.$t.'</strong></div>';
	}
}
//woocommerce_order_status_completed
add_action('woocommerce_order_status_completed','bp_course_enable_access');

function bp_course_enable_access($order_id){
	$order = new WC_Order( $order_id );

	$items = $order->get_items();
	$user_id=$order->user_id;
	foreach($items as $item){
		$product_id = $item['product_id'];

		$subscribed=get_post_meta($product_id,'vibe_subscription',true);

		$courses=vibe_sanitize(get_post_meta($product_id,'vibe_courses',false));


		if(vibe_validate($subscribed) ){

			$duration=get_post_meta($product_id,'vibe_duration',true);
			$t=time()+$duration*86400;

			foreach($courses as $course){
				update_post_meta($course,$user_id,0);
				update_user_meta($user_id,$course,$t);
				$group_id=get_post_meta($course,'vibe_group',true);
				if(isset($group_id) && $group_id !='')
				groups_join_group($group_id, $user_id );  

				bp_course_record_activity(array(
				      'action' => __('Student subscribed for course ','vibe').get_the_title($course),
				      'content' => __('Student ','vibe').bp_core_get_userlink( $user_id ).__(' subscribed for course ','vibe').get_the_title($course).__(' for ','vibe').$duration.__(' days','vibe'),
				      'type' => 'subscribe_course',
				      'item_id' => $course,
				      'primary_link'=>get_permalink($course),
				      'secondary_item_id'=>$user_id
		        ));      
			}
			//wp_update_user(array('ID'=>$user_id,'role'=>'student') );
		}else{	
			if(isset($courses) && is_array($courses)){
			foreach($courses as $course){
				$duration=get_post_meta($course,'vibe_duration',true);
				$t=time()+$duration*86400;
				update_post_meta($course,$user_id,0);
				update_user_meta($user_id,$course,$t);
				$group_id=get_post_meta($course,'vibe_group',true);
				if(isset($group_id) && $group_id !='')
				groups_join_group($group_id, $user_id );

				bp_course_record_activity(array(
				      'action' => __('Student subscribed for course ','vibe').get_the_title($course),
				      'content' => __('Student ','vibe').bp_core_get_userlink( $user_id ).__(' subscribed for course ','vibe').get_the_title($course).__(' for ','vibe').$duration.__(' days','vibe'),
				      'type' => 'subscribe_course',
				      'item_id' => $course,
				      'primary_link'=>get_permalink($course),
				      'secondary_item_id'=>$user_id
		        )); 
				}
				//wp_update_user(array('ID'=>$user_id,'role'=>'student') );
			}
		}
		
	}
	 
}


add_action('pre_get_posts', 'hdb_add_custom_type_to_query');

function hdb_add_custom_type_to_query( $notused ){ //Authors Page
     if (! is_admin() ){
        global $wp_query;
        if ( is_author()){
            $wp_query->set( 'post_type',  array( BP_COURSE_SLUG ) );
        }
     }
}

add_action('bp_members_directory_member_types','bp_course_instructor_member_types');

function bp_course_instructor_member_types(){
	?>
		<li id="members-instructors"><a href="#"><?php printf( __( 'All Instructors <span>%s</span>', 'vibe' ), bp_get_total_instructor_count() ); ?></a></li>
	<?php
}
?>