<?php
if ( !defined( 'ABSPATH' ) ) exit;

function add_vibe_metaboxes(){
	$prefix = 'vibe_';
	$sidebars=$GLOBALS['wp_registered_sidebars'];
	$sidebararray=array();
	foreach($sidebars as $sidebar){
	    $sidebararray[]= array('label'=>$sidebar['name'],'value'=>$sidebar['id']);
	}

	$post_metabox = array(
		 
		
		 array( // Single checkbox
			'label'	=> __('Post Sub-Title','vibe'), // <label>
			'desc'	=> __('Post Sub- Title.','vibe'), // description
			'id'	=> $prefix.'subtitle', // field id and name
			'type'	=> 'textarea', // type of field
	        'std'   => ''
	                ), 

	     array( // Single checkbox
			'label'	=> __('Post Template','vibe'), // <label>
			'desc'	=> __('Select a post template for showing content.','vibe'), // description
			'id'	=> $prefix.'template', // field id and name
			'type'	=> 'select', // type of field
	        'options' => array(
	                    1=>array('label'=>'Default','value'=>''),
	                    2=>array('label'=>'Content on Right','value'=>'right'),
	                    3=>array('label'=>'Content on Left','value'=>'left'),
	        ),
	        'std'   => ''
		),
	     array( // Single checkbox
			'label'	=> __('Sidebar','vibe'), // <label>
			'desc'	=> __('Select a Sidebar | Default : mainsidebar','vibe'), // description
			'id'	=> $prefix.'sidebar', // field id and name
			'type'	=> 'select',
	                'options' => $sidebararray
	                ),
	    array( // Single checkbox
			'label'	=> __('Show Page Title','vibe'), // <label>
			'desc'	=> __('Show Page/Post Title.','vibe'), // description
			'id'	=> $prefix.'title', // field id and name
			'type'	=> 'showhide', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	                'std'   => 'S'
	                ),
	    array( // Single checkbox
			'label'	=> __('Show Author Information','vibe'), // <label>
			'desc'	=> __('Author information below post content.','vibe'), // description
			'id'	=> $prefix.'author', // field id and name
			'type'	=> 'showhide', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	                'std'   => 'H'
		),    
	     
	    array( // Single checkbox
			'label'	=> __('Show Breadcrumbs','vibe'), // <label>
			'desc'	=> __('Show breadcrumbs.','vibe'), // description
			'id'	=> $prefix.'breadcrumbs', // field id and name
			'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	                'std'   => 'S'
	            ),
	    array( // Single checkbox
			'label'	=> __('Show Prev/Next Arrows','vibe'), // <label>
			'desc'	=> __('Show previous/next links on top below the Subheader.','vibe'), // description
			'id'	=> $prefix.'prev_next', // field id and name
			'type'	=> 'showhide', // type of field
	         'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	                'std'   => 'H'
		),
	);

	$page_metabox = array(
			

	        0 => array( // Single checkbox
			'label'	=> __('Show Page Title','vibe'), // <label>
			'desc'	=> __('Show Page/Post Title.','vibe'), // description
			'id'	=> $prefix.'title', // field id and name
			'type'	=> 'showhide', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	                'std'   => 'S'
	                ),


	        1 => array( // Single checkbox
			'label'	=> __('Page Sub-Title','vibe'), // <label>
			'desc'	=> __('Page Sub- Title.','vibe'), // description
			'id'	=> $prefix.'subtitle', // field id and name
			'type'	=> 'textarea', // type of field
	        'std'   => ''
	                ),

	        2 => array( // Single checkbox
			'label'	=> __('Show Breadcrumbs','vibe'), // <label>
			'desc'	=> __('Show breadcrumbs.','vibe'), // description
			'id'	=> $prefix.'breadcrumbs', // field id and name
			'type'	=> 'showhide', // type of field
	         'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	                'std'   => 'S'
	            ),
	    3 => array( // Single checkbox
			'label'	=> __('Sidebar','vibe'), // <label>
			'desc'	=> __('Select Sidebar | Sidebar : mainsidebar','vibe'), // description
			'id'	=> $prefix.'sidebar', // field id and name
			'type'	=> 'select',
	                'options' => $sidebararray
	                ),
	    );



	$featured_metabox = array(
	     array( // Select box
			'label'	=> __('Media','vibe'), // <label>
			'id'	=> $prefix.'select_featured', // field id and name
			'type'	=> 'select', // type of field
			'options' => array ( // array of options
	                        'zero' => array ( // array key needs to be the same as the option value
					'label' => __('Disable','vibe'), // text displayed as the option
					'value'	=> 'disable' // value stored for the option
				),
				'one' => array ( // array key needs to be the same as the option value
					'label' => __('Gallery','vibe'), // text displayed as the option
					'value'	=> 'gallery' // value stored for the option
				),
				'two' => array (
					'label' => __('Self Hosted Video','vibe'),
					'value'	=> 'video'
				),
	                        'three' => array (
					'label' => __('IFrame Video','vibe'),
					'value'	=> 'iframevideo'
				),
				'four' => array (
					'label' => __('Self Hosted Audio','vibe'),
					'value'	=> 'audio'
				),
	                        'five' => array (
					'label' => __('Other','vibe'),
					'value'	=> 'other'
				)
			)
		),
	    
	        
	        array( // Repeatable & Sortable Text inputs
			'label'	=> __('Gallery','vibe'), // <label>
			'desc'	=> __('Create a Gallery in post.','vibe'), // description
			'id'	=> $prefix.'slider', // field id and name
			'type'	=> 'gallery' // type of field
		),
	        
		array( // Textarea
			'label'	=> __('Self Hosted Video','vibe'), // <label>
			'desc'	=> __('Select video files (of same Video): xxxx.mp4,xxxx.ogv,xxxx.ogg for max. browser compatibility','vibe'), // description
			'id'	=> $prefix.'featuredvideo', // field id and name
			'type'	=> 'video' // type of field
		),
	        array( // Textarea
			'label'	=> __('IFRAME Video','vibe'), // <label>
			'desc'	=> __('Insert Iframe (Youtube,Vimeo..) embed code of video ','vibe'), // description
			'id'	=> $prefix.'featurediframevideo', // field id and name
			'type'	=> 'textarea' // type of field
		),
	        array( // Text Input
			'label'	=> __('Audio','vibe'), // <label>
			'desc'	=> __('Select audio files (of same Audio): xxxx.mp3,xxxx.wav,xxxx.ogg for max. browser compatibility','vibe'), // description
			'id'	=> $prefix.'featured_audio', // field id and name
			'type'	=> 'audio' // type of field
		),
	        array( // Textarea
			'label'	=> __('Other','vibe'), // <label>
			'desc'	=> __('Insert Shortcode or relevant content.','vibe'), // description
			'id'	=> $prefix.'featuredother', // field id and name
			'type'	=> 'textarea' // type of field
		)
		
	    );




	$course_metabox = array(  
		array( // Single checkbox
			'label'	=> __('Sidebar','vibe'), // <label>
			'desc'	=> __('Select a Sidebar | Default : mainsidebar','vibe'), // description
			'id'	=> $prefix.'sidebar', // field id and name
			'type'	=> 'select',
	        'options' => $sidebararray,
	        'std'=>'coursesidebar'
	        ),
		array( // Text Input
			'label'	=> __('Total Duration of Course','vibe'), // <label>
			'desc'	=> __('Duration of Course (in days).','vibe'), // description
			'id'	=> $prefix.'duration', // field id and name
			'type'	=> 'number', // type of field
			'std'	=> 0,
		),

		array( // Text Input
			'label'	=> __('Total number of Students in Course','vibe'), // <label>
			'desc'	=> __('Total number of Students who have taken this Course.','vibe'), // description
			'id'	=> $prefix.'students', // field id and name
			'type'	=> 'number', // type of field
			'std'	=> 0,
		),
		array( // Text Input
			'label'	=> __('Auto Evaluation','vibe'), // <label>
			'desc'	=> __('Evalute Courses based on Quizes scores available in Course (* Requires atleast 1 Quiz in course)','vibe'), // description
			'id'	=> $prefix.'course_auto_eval', // field id and name
			'type'	=> 'yesno', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),
		array( // Text Input
			'label'	=> __('Excellence Badge','vibe'), // <label>
			'desc'	=> __('Upload badge image which Students recieve upon course completion','vibe'), // description
			'id'	=> $prefix.'course_badge', // field id and name
			'type'	=> 'image' // type of field
		),

		array( // Text Input
			'label'	=> __('Badge Percentage','vibe'), // <label>
			'desc'	=> __('Badge is given to people passing above percentage (out of 100)','vibe'), // description
			'id'	=> $prefix.'course_badge_percentage', // field id and name
			'type'	=> 'number' // type of field
		),

		array( // Text Input
			'label'	=> __('Badge Title','vibe'), // <label>
			'desc'	=> __('Title is shown on hovering the badge.','vibe'), // description
			'id'	=> $prefix.'course_badge_title', // field id and name
			'type'	=> 'text' // type of field
		),

		array( // Text Input
			'label'	=> __('Completion Certificate','vibe'), // <label>
			'desc'	=> __('Enable Certificate image which Students recieve upon course completion (out of 100)','vibe'), // description
			'id'	=> $prefix.'course_certificate', // field id and name
			'type'	=> 'showhide', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),

		array( // Text Input
			'label'	=> __('Certificate Template','vibe'), // <label>
			'desc'	=> __('Select a Certificate Template','vibe'), // description
			'id'	=> $prefix.'certificate_template', // field id and name
			'type'	=> 'selectcpt', // type of field
	        'post_type' => 'certificate'
		),

		array( // Text Input
			'label'	=> __('Passing Percentage','vibe'), // <label>
			'desc'	=> __('Course passing percentage, for completion certificate','vibe'), // description
			'id'	=> $prefix.'course_passing_percentage', // field id and name
			'type'	=> 'number' // type of field
		),
		array( // Text Input
			'label'	=> __('Drip Feed','vibe'), // <label>
			'desc'	=> __('Enable Drip Feed course','vibe'), // description
			'id'	=> $prefix.'course_drip', // field id and name
			'type'	=> 'yesno', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),
		array( // Text Input
			'label'	=> __('Drip Feed Duration','vibe'), // <label>
			'desc'	=> __('Duration between consecutive Drip feed units (in Days)','vibe'), // description
			'id'	=> $prefix.'course_drip_duration', // field id and name
			'type'	=> 'number', // type of field
		),

		

		array( // Text Input
			'label'	=> __('Course Curriculum','vibe'), // <label>
			'desc'	=> __('Set Course Curriculum, prepare units and quizes before setting up curriculum','vibe'), // description
			'id'	=> $prefix.'course_curriculum', // field id and name
			'post_type1' => 'unit',
			'post_type2' => 'quiz',
			'type'	=> 'curriculum' // type of field
		),
		 
		array( // Text Input
			'label'	=> __('Pre-Required Course','vibe'), // <label>
			'desc'	=> __('Pre Required course for this course','vibe'), // description
			'id'	=> $prefix.'pre_course', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type' => 'course'
		), 
		array( // Text Input
			'label'	=> __('Course Forum','vibe'), // <label>
			'desc'	=> __('Connect Forum with Course.','vibe'), // description
			'id'	=> $prefix.'forum', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type' => 'forum'
		),
		array( // Text Input
			'label'	=> __('Course Group','vibe'), // <label>
			'desc'	=> __('Connect a Group with Course.','vibe'), // description
			'id'	=> $prefix.'group', // field id and name
			'type'	=> 'groups', // type of field
		),
		array( // Text Input
			'label'	=> __('Course Completion Message','vibe'), // <label>
			'desc'	=> __('This message is shown to users when they Finish submit the course','vibe'), // description
			'id'	=> $prefix.'course_message', // field id and name
			'type'	=> 'editor', // type of field
			'std'	=> 'Thank you for Finish the Course.'
		),
	);

	$course_product_metabox = array(
		array( // Text Input
			'label'	=> __('Free Course','vibe'), // <label>
			'desc'	=> __('Course is Free for all Members','vibe'), // description
			'id'	=> $prefix.'course_free', // field id and name
			'type'	=> 'yesno', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		)
	);
if ( in_array( 'paid-memberships-pro/paid-memberships-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && function_exists('pmpro_getAllLevels')) {	
	$levels=pmpro_getAllLevels();
	foreach($levels as $level){
		$level_array[]= array('value' =>$level->id,'label'=>$level->name);
	}
	$course_product_metabox[] =array(
			'label'	=> __('PMPro Membership','vibe'), // <label>
			'desc'	=> __('Required Membership levle for this course','vibe'), // description
			'id'	=> $prefix.'pmpro_membership', // field id and name
			'type'	=> 'multiselect', // type of field
			'options' => $level_array,
		);
}
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || (function_exists('is_plugin_active_for_network') && is_plugin_active_for_network( 'woocommerce/woocommerce.php'))) {
	
	$course_product_metabox[] =array(
			'label'	=> __('Associated Product','vibe'), // <label>
			'desc'	=> __('Associated Product with the Course.','vibe'), // description
			'id'	=> $prefix.'product', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type'=> 'product',
	        'std'   => ''
		);
}

$unit_types = apply_filters('wplms_unit_types',array(
                      array( 'label' =>__('Video','vibe'),'value'=>'play'),
                      array( 'label' =>__('Audio','vibe'),'value'=>'music-file-1'),
                      array( 'label' =>__('Podcast','vibe'),'value'=>'podcast'),
                      array( 'label' =>__('General','vibe'),'value'=>'text-document'),
                    ));

	$unit_metabox = array(  
		array( // Single checkbox
			'label'	=> __('Unit Description','vibe'), // <label>
			'desc'	=> __('Small Description.','vibe'), // description
			'id'	=> $prefix.'subtitle', // field id and name
			'type'	=> 'textarea', // type of field
	        'std'   => ''
	        ),
		array( // Text Input
			'label'	=> __('Unit Type','vibe'), // <label>
			'desc'	=> __('Select Unit type from Video , Audio , Podcast, General , ','vibe'), // description
			'id'	=> $prefix.'type', // field id and name
			'type'	=> 'select', // type of field
			'options' => $unit_types,
	        'std'   => 'text-document'
		),
		array( // Text Input
			'label'	=> __('Free Unit','vibe'), // <label>
			'desc'	=> __('Set Free unit, viewable to all','vibe'), // description
			'id'	=> $prefix.'free', // field id and name
			'type'	=> 'showhide', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),
		array( // Text Input
			'label'	=> __('Unit Duration','vibe'), // <label>
			'desc'	=> __('Duration in Minutes','vibe'), // description
			'id'	=> $prefix.'duration', // field id and name
			'type'	=> 'number' // type of field
		),
		array( // Text Input
			'label'	=> __('Connect an Assignment','vibe'), // <label>
			'desc'	=> __('Select an Assignment which you can connect with this Unit','vibe'), // description
			'id'	=> $prefix.'assignment', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type' => 'wplms-assignment'
		),
		array( // Text Input
			'label'	=> __('Unit Forum','vibe'), // <label>
			'desc'	=> __('Connect Forum with Unit.','vibe'), // description
			'id'	=> $prefix.'forum', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type' => 'forum'
		),
	);


	$question_metabox = array(  
		array( // Text Input
			'label'	=> __('Question Type','vibe'), // <label>
			'desc'	=> __('Select Question type, ','vibe'), // description
			'id'	=> $prefix.'question_type', // field id and name
			'type'	=> 'select', // type of field
			'options' => array(
	          array( 'label' =>'Single Choice','value'=>'single'),
	          array( 'label' =>'Multiple Choice','value'=>'multiple'),
	          array( 'label' =>'Sort Answers','value'=>'sort'),
	          array( 'label' =>'Small Text','value'=>'smalltext'),
	          array( 'label' =>'Large Text','value'=>'largetext'),
	        ),
	        'std'   => 'single'
		),
		array( // Text Input
			'label'	=> __('Question Options (For Single/Multiple/Sort/Match Question types)','vibe'), // <label>
			'desc'	=> __('Single/Mutiple Choice question options','vibe'), // description
			'id'	=> $prefix.'question_options', // field id and name
			'type'	=> 'repeatable_count' // type of field
		),
	    array( // Text Input
			'label'	=> __('Correct Answer','vibe'), // <label>
			'desc'	=> __('Enter Choice Number (1,2..) or comma saperated Choice numbers (1,2..) or Correct Answer for small text (All possible answers comma saperated) | 0 for No Answer or Manual Check','vibe'), // description
			'id'	=> $prefix.'question_answer', // field id and name
			'type'	=> 'text', // type of field
			'std'	=> 0
		),
	);

	$quiz_metabox = array(  
		array( // Text Input
			'label'	=> __('Quiz Subtitle','vibe'), // <label>
			'desc'	=> __('Quiz Subtitle.','vibe'), // description
			'id'	=> $prefix.'subtitle', // field id and name
			'type'	=> 'text', // type of field
			'std'	=> ''
		),
        array( // Text Input
			'label'	=> __('Connected Course','vibe'), // <label>
			'desc'	=> __('Adds a Back to Course button, on quiz submission.','vibe'), // description
			'id'	=> $prefix.'quiz_course', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type' => 'course'
		),
		array( // Text Input
			'label'	=> __('Quiz Duration','vibe'), // <label>
			'desc'	=> __('Quiz duration in minutes. Enables Timer & auto submits on expire. 0 to disable.','vibe'), // description
			'id'	=> $prefix.'duration', // field id and name
			'type'	=> 'number', // type of field
			'std'	=> 0
		),
		
		array( // Text Input
			'label'	=> __('Auto Evatuate Results','vibe'), // <label>
			'desc'	=> __('Evaluate results as soon as quiz is complete. (* No Large text questions ), Diable for manual evaluate','vibe'), // description
			'id'	=> $prefix.'quiz_auto_evaluate', // field id and name
			'type'	=> 'yesno', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		), 
		
		array( // Text Input
			'label'	=> __('Number of Extra Quiz Retakes','vibe'), // <label>
			'desc'	=> __('Student can reset and start the quiz all over again. Number of Extra retakes a student can take.','vibe'), // description
			'id'	=> $prefix.'quiz_retakes', // field id and name
			'type'	=> 'number', // type of field
	        'std'   => 0
		), 
		array( // Text Input
			'label'	=> __('Send Notification upon evaluation','vibe'), // <label>
			'desc'	=> __('Student recieve notification when quiz is evaluated.','vibe'), // description
			'id'	=> $prefix.'quiz_notification', // field id and name
			'type'	=> 'showhide', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),
		array( // Text Input
			'label'	=> __('Post Quiz Message','vibe'), // <label>
			'desc'	=> __('This message is shown to users when they submit the quiz','vibe'), // description
			'id'	=> $prefix.'quiz_message', // field id and name
			'type'	=> 'editor', // type of field
			'std'	=> 'Thank you for Submitting the Quiz. Check Results in your Profile.'
		),
		
	    array( // Text Input
			'label'	=> __('Quiz Questions','vibe'), // <label>
			'desc'	=> __('Quiz questions','vibe'), // description
			'id'	=> $prefix.'quiz_questions', // field id and name
			'type'	=> 'repeatable_selectcpt', // type of field
			'post_type' => 'question',
			'std'	=> 0
		),
	    
		
	);

	$testimonial_metabox = array(  
		array( // Text Input
			'label'	=> __('Author Name','vibe'), // <label>
			'desc'	=> __('Enter the name of the testimonial author.','vibe'), // description
			'id'	=> $prefix.'testimonial_author_name', // field id and name
			'type'	=> 'text' // type of field
		),
	        array( // Text Input
			'label'	=> __('Designation','vibe'), // <label>
			'desc'	=> __('Enter the testimonial author\'s designation.','vibe'), // description
			'id'	=> $prefix.'testimonial_author_designation', // field id and name
			'type'	=> 'text' // type of field
		),
	);




	$product_metabox = array(  
		array( // Text Input
			'label'	=> __('Associated Courses','vibe'), // <label>
			'desc'	=> __('Associated Courses with this product. Enables access to the course.','vibe'), // description
			'id'	=> $prefix.'courses', // field id and name
			'type'	=> 'selectmulticpt', // type of field
			'post_type'=>'course'
		),
	    array( // Text Input
			'label'	=> __('Subscription ','vibe'), // <label>
			'desc'	=> __('Enable if Product is Subscription Type (Price per month)','vibe'), // description
			'id'	=> $prefix.'subscription', // field id and name
			'type'	=> 'showhide', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	                'std'   => 'H'
		),
	    array( // Text Input
			'label'	=> __('Subscription Duration','vibe'), // <label>
			'desc'	=> __('Duration for Subscription Products (in days)','vibe'), // description
			'id'	=> $prefix.'duration', // field id and name
			'type'	=> 'number' // type of field
		),
	);


$wplms_events_metabox = array(  
		array( // Single checkbox
			'label'	=> __('Event Sub-Title','vibe'), // <label>
			'desc'	=> __('Event Sub-Title.','vibe'), // description
			'id'	=> $prefix.'subtitle', // field id and name
			'type'	=> 'textarea', // type of field
	        'std'   => ''
	                ), 
		array( // Text Input
			'label'	=> __('Course','vibe'), // <label>
			'desc'	=> __('Select Course for which the event is valid','vibe'), // description
			'id'	=> $prefix.'event_course', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type' => 'course'
		),
		array( // Text Input
			'label'	=> __('Connect an Assignment','vibe'), // <label>
			'desc'	=> __('Select an Assignment which you can connect with this Event','vibe'), // description
			'id'	=> $prefix.'assignment', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type' => 'wplms-assignment'
		),
		array( // Text Input
			'label'	=> __('Event Icon','vibe'), // <label>
			'desc'	=> __('Click on icon to  select an icon for the event','vibe'), // description
			'id'	=> $prefix.'icon', // field id and name
			'type'	=> 'icon', // type of field
		),
		array( // Text Input
			'label'	=> __('Event Color','vibe'), // <label>
			'desc'	=> __('Select color for Event','vibe'), // description
			'id'	=> $prefix.'color', // field id and name
			'type'	=> 'color', // type of field
		),
		array( // Text Input
			'label'	=> __('Start Date','vibe'), // <label>
			'desc'	=> __('Date from which Event Begins','vibe'), // description
			'id'	=> $prefix.'start_date', // field id and name
			'type'	=> 'date', // type of field
		),
		array( // Text Input
			'label'	=> __('End Date','vibe'), // <label>
			'desc'	=> __('Date on which Event ends.','vibe'), // description
			'id'	=> $prefix.'end_date', // field id and name
			'type'	=> 'date', // type of field
		),
		array( // Text Input
			'label'	=> __('Start Time','vibe'), // <label>
			'desc'	=> __('Date from which Event Begins','vibe'), // description
			'id'	=> $prefix.'start_time', // field id and name
			'type'	=> 'time', // type of field
		),
		array( // Text Input
			'label'	=> __('End Time','vibe'), // <label>
			'desc'	=> __('Date on which Event ends.','vibe'), // description
			'id'	=> $prefix.'end_time', // field id and name
			'type'	=> 'time', // type of field
		),
		array( // Text Input
			'label'	=> __('Show Location','vibe'), // <label>
			'desc'	=> __('Show Location and Google map with the event','vibe'), // description
			'id'	=> $prefix.'show_location', // field id and name
			'type'	=> 'yesno', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),
	    array( // Text Input
			'label'	=> __('Location','vibe'), // <label>
			'desc'	=> __('Location of event','vibe'), // description
			'id'	=> $prefix.'location', // field id and name
			'type'	=> 'gmap' // type of field
		),
		array( // Text Input
			'label'	=> __('Additional Information','vibe'), // <label>
			'desc'	=> __('Point wise Additional Information regarding the event','vibe'), // description
			'id'	=> $prefix.'additional_info', // field id and name
			'type'	=> 'repeatable' // type of field
		),
		array( // Text Input
			'label'	=> __('More Information','vibe'), // <label>
			'desc'	=> __('Supports HTML and shortcodes','vibe'), // description
			'id'	=> $prefix.'more_info', // field id and name
			'type'	=> 'editor' // type of field
		),
		array( // Text Input
			'label'	=> __('Private Event','vibe'), // <label>
			'desc'	=> __('Only Invited participants can see the Event','vibe'), // description
			'id'	=> $prefix.'private_event', // field id and name
			'type'	=> 'yesno', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),
	);

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || (function_exists('is_plugin_active_for_network') && is_plugin_active_for_network( 'woocommerce/woocommerce.php'))) {
	
	$wplms_events_metabox[] =array(
			'label'	=> __('Associated Product for Event Access','vibe'), // <label>
			'desc'	=> __('Purchase of this product grants Event access to the member.','vibe'), // description
			'id'	=> $prefix.'product', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type'=> 'product',
	        'std'   => ''
		);
}

$payments_metabox = array(  
		array( // Text Input
			'label'	=> __('From','vibe'), // <label>
			'desc'	=> __('Date on which Payment was done.','vibe'), // description
			'id'	=> $prefix.'date_from', // field id and name
			'type'	=> 'text', // type of field
		),
		array( // Text Input
			'label'	=> __('To','vibe'), // <label>
			'desc'	=> __('Date on which Payment was done.','vibe'), // description
			'id'	=> $prefix.'date_to', // field id and name
			'type'	=> 'text', // type of field
		),
	    array( // Text Input
			'label'	=> __('Instructor and Commissions','vibe'), // <label>
			'desc'	=> __('Instructor commissions','vibe'), // description
			'id'	=> $prefix.'instructor_commissions', // field id and name
			'type'	=> 'payments' // type of field
		),
	);

$certificate_metabox = array(  
		array( // Text Input
			'label'	=> __('Background Image/Pattern','vibe'), // <label>
			'desc'	=> __('Add background image','vibe'), // description
			'id'	=> $prefix.'background_image', // field id and name
			'type'	=> 'image', // type of field
		),
		array( // Text Input
			'label'	=> __('Enable Print','vibe'), // <label>
			'desc'	=> __('Displays a Print Button on top right corner of certificate','vibe'), // description
			'id'	=> $prefix.'print', // field id and name
			'type'	=> 'yesno', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),
		array( // Text Input
			'label'	=> __('Custom Class','vibe'), // <label>
			'desc'	=> __('Add Custom Class over Certificate container.','vibe'), // description
			'id'	=> $prefix.'custom_class', // field id and name
			'type'	=> 'text', // type of field
		),
		array( // Text Input
			'label'	=> __('Custom CSS','vibe'), // <label>
			'desc'	=> __('Add Custom CSS for Certificate.','vibe'), // description
			'id'	=> $prefix.'custom_css', // field id and name
			'type'	=> 'textarea', // type of field
		),
		array( // Text Input
			'label'	=> __('NOTE:','vibe'), // <label>
			'desc'	=> __(' USE FOLLOWING SHORTCODES TO DISPLAY RELEVANT DATA : <br />1. <strong>[certificate_student_name]</strong> : Displays Students Name<br />2. <strong>[certificate_course]</strong> : Displays Course Name<br />3. <strong>[certificate_student_marks]</strong> : Displays Students Marks in Course<br />4. <strong>[certificate_student_date]</strong>: Displays date on which Certificate was awarded to the Student<br />5. <strong>[certificate_student_email]</strong>: Displays registered email of the Student<br />6. <strong>[certificate_code]</strong>: Generates unique code for Student which can be validated from Certificate page.','vibe'), // description
			'id'	=> $prefix.'note', // field id and name
			'type'	=> 'note', // type of field
		),
	);	


$wplms_assignments_metabox = array(  
	array( // Single checkbox
			'label'	=> __('Assignment Sub-Title','vibe'), // <label>
			'desc'	=> __('Assignment Sub-Title.','vibe'), // description
			'id'	=> $prefix.'subtitle', // field id and name
			'type'	=> 'textarea', // type of field
	        'std'   => ''
	                ), 
	array( // Single checkbox
			'label'	=> __('Sidebar','vibe'), // <label>
			'desc'	=> __('Select a Sidebar | Default : mainsidebar','vibe'), // description
			'id'	=> $prefix.'sidebar', // field id and name
			'type'	=> 'select',
	                'options' => $sidebararray
	                ),
	array( // Text Input
		'label'	=> __('Assignment Maximum Marks','vibe'), // <label>
		'desc'	=> __('Set Maximum marks for the assignment','vibe'), // description
		'id'	=> $prefix.'assignment_marks', // field id and name
		'type'	=> 'number', // type of field
		'std' => '10'
	),
	array( // Text Input
		'label'	=> __('Assignment Maximum Time limit','vibe'), // <label>
		'desc'	=> __('Set Maximum Time limit for Assignment ( in Days )','vibe'), // description
		'id'	=> $prefix.'assignment_duration', // field id and name
		'type'	=> 'number', // type of field
		'std' => '10'
	),
	array( // Text Input
			'label'	=> __('Include in Course Evaluation','vibe'), // <label>
			'desc'	=> __('Include assignment marks in Course Evaluation','vibe'), // description
			'id'	=> $prefix.'assignment_evaluation', // field id and name
			'type'	=> 'yesno', // type of field
	        'options' => array(
	          array('value' => 'H',
	                'label' =>'Hide'),
	          array('value' => 'S',
	                'label' =>'Show'),
	        ),
	        'std'   => 'H'
		),
	array( // Text Input
			'label'	=> __('Include in Course','vibe'), // <label>
			'desc'	=> __('Assignments marks will be shown/used in course evaluation','vibe'), // description
			'id'	=> $prefix.'assignment_course', // field id and name
			'type'	=> 'selectcpt', // type of field
			'post_type' => 'course'
		),
	array( // Single checkbox
			'label'	=> __('Assignment Submissions','vibe'), // <label>
			'desc'	=> __('Select type of assignment submissions','vibe'), // description
			'id'	=> $prefix.'assignment_submission_type', // field id and name
			'type'	=> 'select', // type of field
	        'options' => array(
	                    1=>array('label'=>'Upload file','value'=>'upload'),
	                    2=>array('label'=>'Text Area','value'=>'textarea'),
	        ),
	        'std'   => ''
		),
	array( // Text Input
			'label'	=> __('Attachment Type','vibe'), // <label>
			'desc'	=> __('Select valid attachment types ','vibe'), // description
			'id'	=> $prefix.'attachment_type', // field id and name
			'type'	=> 'multiselect', // type of field
			'options' => array(
				array('value'=> 'JPG','label' =>'JPG'),
				array('value'=> 'GIF','label' =>'GIF'),
				array('value'=> 'PNG','label' =>'PNG'),
				array('value'=> 'PDF','label' =>'PDF'),
				array('value'=> 'DOC','label' =>'DOC'),
				array('value'=> 'DOCX','label' => 'DOCX'),
				array('value'=> 'PPT','label' =>'PPT'),
				array('value'=> 'PPTX','label' => 'PPTX'),
				array('value'=> 'PPS','label' =>'PPS'),
				array('value'=> 'PPSX','label' => 'PPSX'),
				array('value'=> 'ODT','label' =>'ODT'),
				array('value'=> 'XLS','label' =>'XLS'),
				array('value'=> 'XLSX','label' => 'XLSX'),
				array('value'=> 'MP3','label' =>'MP3'),
				array('value'=> 'M4A','label' =>'M4A'),
				array('value'=> 'OGG','label' =>'OGG'),
				array('value'=> 'WAV','label' =>'WAV'),
				array('value'=> 'WMA','label' =>'WMA'),
				array('value'=> 'MP4','label' =>'MP4'),
				array('value'=> 'M4V','label' =>'M4V'),
				array('value'=> 'MOV','label' =>'MOV'),
				array('value'=> 'WMV','label' =>'WMV'),
				array('value'=> 'AVI','label' =>'AVI'),
				array('value'=> 'MPG','label' =>'MPG'),
				array('value'=> 'OGV','label' =>'OGV'),
				array('value'=> '3GP','label' =>'3GP'),
				array('value'=> '3G2','label' =>'3G2'),
				array('value'=> 'FLV','label' =>'FLV'),
				array('value'=> 'WEBM','label' =>'WEBM'),
				array('value'=> 'APK','label' =>'APK '),
				array('value'=> 'RAR','label' =>'RAR'),
				array('value'=> 'ZIP','label' =>'ZIP'),
	        ),
	        'std'   => 'single'
		),
);

	$post_metabox = new custom_add_meta_box( 'post-settings', __('Post Settings','vibe'), $post_metabox, 'post', true );
	$page_metabox = new custom_add_meta_box( 'page-settings', __('Page Settings','vibe'), $page_metabox, 'page', true );

	$course_box = new custom_add_meta_box( 'page-settings', __('Course Settings','vibe'), $course_metabox, 'course', true );

	$course_product = __('Course Product','vibe');
	if(function_exists('pmpro_getAllLevels')){
		$course_product = __('Course Membership','vibe');
	}
	$course_product_box = new custom_add_meta_box( 'post-settings', $course_product, $course_product_metabox, 'course', true );
	$unit_box = new custom_add_meta_box( 'page-settings', __('Unit Settings','vibe'), $unit_metabox, 'unit', true );

	$question_box = new custom_add_meta_box( 'page-settings', __('Question Settings','vibe'), $question_metabox, 'question', true );
	$quiz_box = new custom_add_meta_box( 'page-settings', __('Question Settings','vibe'), $quiz_metabox, 'quiz', true );

	
	$testimonial_box = new custom_add_meta_box( 'testimonial-info', __('Testimonial Author Information','vibe'), $testimonial_metabox, 'testimonials', true );
	$payments_metabox = new custom_add_meta_box( 'page-settings', __('Payments Settings','vibe'), $payments_metabox, 'payments', true );
	$certificates_metabox = new custom_add_meta_box( 'page-settings', __('Certificate Template Settings','vibe'), $certificate_metabox, 'certificate', true );
	
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || (function_exists('is_plugin_active_for_network') && is_plugin_active_for_network( 'woocommerce/woocommerce.php'))) {
		$product_box = new custom_add_meta_box( 'page-settings', __('Product Course Settings','vibe'), $product_metabox, 'product', true );
	}

	if ( in_array( 'wplms-events/wplms-events.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$events_metabox = new custom_add_meta_box( 'page-settings', __('WPLMS Events Settings','vibe'), $wplms_events_metabox, 'wplms-event', true );
	}

	
	if ( in_array( 'wplms-assignments/wplms-assignments.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$eassignments_metabox = new custom_add_meta_box( 'page-settings', __('WPLMS Assignments Settings','vibe'), $wplms_assignments_metabox, 'wplms-assignment', true );
	}
}
add_action('init','add_vibe_metaboxes');


add_action( 'add_meta_boxes', 'add_vibe_editor' );
if(!function_exists('add_vibe_editor')){
	function add_vibe_editor(){
	    add_meta_box( 'vibe-editor', __( 'Page Builder', 'vibe' ), 'vibe_layout_editor', 'page', 'normal', 'high' );
	}
}

function attachment_getMaximumUploadFileSize(){
    $maxUpload      = (int)(ini_get('upload_max_filesize'));
    $maxPost        = (int)(ini_get('post_max_size'));
    $memoryLimit    = (int)(ini_get('memory_limit'));
    return min($maxUpload, $maxPost, $memoryLimit);
}
