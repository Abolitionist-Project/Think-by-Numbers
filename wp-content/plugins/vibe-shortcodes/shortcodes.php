<?php

/*-----------------------------------------------------------------------------------*/
/*	Drop Caps
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_dropcaps')) {
	function vibe_dropcaps( $atts, $content = null ) {
            
        $return ='<span class="dropcap">'.$content.'</span>';
        return $return;
	}
	add_shortcode('d', 'vibe_dropcaps');
}
/*-----------------------------------------------------------------------------------*/
/*	Pull Quote
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_pullquote')) {
	function vibe_pullquote( $atts, $content = null ) {
            extract(shortcode_atts(array(
		'style'   => 'left'
                ), $atts));
        $return ='<div class="pullquote '.$style.'">'.do_shortcode($content).'</div>';
        return $return;
	}
	add_shortcode('pullquote', 'vibe_pullquote');
}

/*-----------------------------------------------------------------------------------*/
/*	Instructor
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_instructor')) {
	function vibe_instructor( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'id'   => '1'
                ), $atts));
        $instructor = $id;
        $return.='<div class="course_instructor_widget">';
	    $return.= bp_course_get_instructor_avatar('item_id='.$instructor);
	    $return.= bp_course_get_instructor('instructor_id='.$instructor);
	    $return.= '<div class="description">'.bp_course_get_instructor_description('instructor_id='.$instructor).'</div>';
	    $return.= '<a href="'.get_author_posts_url($instructor).'" class="tip" title="'.__('Check all Courses created by ','vibe').bp_core_get_user_displayname($instructor).'"><i class="icon-plus-1"></i></a>';
	    $return.= '<h5>'.__('More Courses by ','vibe').bp_core_get_user_displayname($instructor).'</h5>';
	    $return.= '<ul class="widget_course_list">';
	    $query = new WP_Query( 'post_type=course&author='.$instructor.'&posts_per_page='.$max_items );
	    while($query->have_posts()):$query->the_post();
	    global $post;
	    $return.= '<li><a href="'.get_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID,'thumbnail').'<h6>'.get_the_title($post->ID).'<span>by '.bp_core_get_user_displayname($post->post_author).'</span></h6></a>';
	    endwhile;
	    wp_reset_postdata();
	    $return.= '</ul>';
	    $return.= '</div>'; 
        return $return;
	}
	add_shortcode('instructor', 'vibe_instructor');
}


/*-----------------------------------------------------------------------------------*/
/*	Divider
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_divider')) {
	function vibe_divider( $atts, $content = null ) {
            extract(shortcode_atts(array(
				'style'   => ''
                ), $atts));
        $return ='<hr class="divider '.$style.'" />';
        return $return;
	}
	add_shortcode('divider', 'vibe_divider');
}

/*-----------------------------------------------------------------------------------*/
/*	COURSE
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_course')) {
	function vibe_course( $atts, $content = null ) {
            extract(shortcode_atts(array(
					'id'   => ''
                ), $atts));
            $course_query = new WP_Query("post_type=course&p=$id");
            
            if($course_query->have_posts()){
            	while($course_query->have_posts()){
            		$course_query->the_post();
            					
            		if(function_exists('thumbnail_generator'))
        				$return = thumbnail_generator($post,'course','medium',1,1,1);

            	}
            }

            wp_reset_postdata();
        return $return;
	}
	add_shortcode('course', 'vibe_course');
}
/*-----------------------------------------------------------------------------------*/
/*	Icon
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_icon')) {
	function vibe_icon( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'icon'   => 'icon-facebook',
                'size' => '',
                'bg' =>'',
                'hoverbg'=>'',
                'padding' =>'',
                'radius' =>'',
                'color' => '',
                'hovercolor' => ''
	), $atts));
        $rand = 'icon'.rand(1,9999);
        $return ='<style> #'.$rand.'{'.(isset($size)?'font-size:'.$size.';':'').''.((isset($bg))?'background:'.$bg.';':';').''.(isset($padding)?'padding:'.$padding.';':'').''.(isset($radius)?'border-radius:'.$radius.';':'').''.((isset($color))?'color:'.$color.';':'').'}
            #'.$rand.':hover{'.((isset($hovercolor))?'color:'.$hovercolor.';':'').''.((isset($hoverbg))?'background:'.$hoverbg.';':'').'}</style><i class="'.$icon.'" id="'.$rand.'"></i>';
	   return $return;
	}
	add_shortcode('icon', 'vibe_icon');
}

/*-----------------------------------------------------------------------------------*/
/*	Icon
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_iframevideo')) {
	function vibe_iframevideo( $atts, $content = null ) {
	$return = '<div class="fitvids">'.html_entity_decode($content).'</div>';		
       return $return;
	}
	add_shortcode('iframevideo', 'vibe_iframevideo');
}

/*-----------------------------------------------------------------------------------*/
/*	Round Progress
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_roundprogress')) {
	function vibe_roundprogress( $atts, $content = null ) {
	extract(shortcode_atts(array(
                'style' => '',
		'percentage'   => '60',
                'radius' => '',
                'thickness' =>'',
                'color' =>'#333',
                'bg_color' =>'#65ABA6',
	), $atts));
        $rand = 'icon'.rand(1,9999);
        
        $return ='<figure class="knob animate zoom" style="width:'.($radius+10).'px;min-height:'.($radius+10).'px;">
                    <input class="dial" data-skin="'.$style.'" data-value="'.$percentage.'" data-fgColor="'.$color.'" data-bgColor="'.$bg_color.'" data-height="'.$radius.'" data-inputColor="'.$color.'" data-width="'.$radius.'" data-thickness="'.($thickness/100).'" value="'.$percentage.'" data-readOnly=true />
                        <div class="knob_content"><h3 style="color:'.$color.';">'.do_shortcode($content).'</h3></div>
                  </figure>';
        return $return;
	}
	add_shortcode('roundprogress', 'vibe_roundprogress');
}



/*-----------------------------------------------------------------------------------*/
/*	WPML Language Selector shortcode
/*-----------------------------------------------------------------------------------*/

//[wpml_lang_selector]
function wpml_shortcode_func(){
do_action('icl_language_selector');
}
add_shortcode( 'wpml_lang_selector', 'wpml_shortcode_func' );


/*-----------------------------------------------------------------------------------*/
/*	Note
/*-----------------------------------------------------------------------------------*/


if (!function_exists('note')) {
	function note( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style'   => '',
                'bg' =>'',
                'border' =>'',
                'bordercolor' =>'',
                'color' => ''
	), $atts));
	   return '<div class="notification '.$style.'" style="background-color:'.$bg.';border-color:'.$border.';">
			<div class="notepad" style="color:'.$color.';border-color:'.$bordercolor.';">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('note', 'note');
}

/*-----------------------------------------------------------------------------------*/
/*	Column Shortcode
/*-----------------------------------------------------------------------------------*/

if (!function_exists('one_half')) {
	function one_half( $atts, $content = null ) {
	    $clear='';
	    if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	      $clear='clearfix';
	      
            return '<div class="one_half '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('one_half', 'one_half');
}


if (!function_exists('one_third')) {
	function one_third( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
	  
	   return '<div class="one_third '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('one_third', 'one_third');
}


if (!function_exists('one_fourth')) {
	function one_fourth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
             return '<div class="one_fourth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';	}
	add_shortcode('one_fourth', 'one_fourth');
}


if (!function_exists('three_fourth')) {
	function three_fourth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
             return '<div class="three_fourth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('three_fourth', 'three_fourth');
}


if (!function_exists('two_third')) {
	function two_third( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
            return '<div class="two_third"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('two_third', 'two_third');
}

if (!function_exists('one_fifth')) {
	function one_fifth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
            return '<div class="one_fifth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('one_fifth', 'one_fifth');
}
if (!function_exists('two_fifth')) {
	function two_fifth( $atts, $content = null ) {
            return '<div class="two_fifth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('two_fifth', 'two_fifth');
}
if (!function_exists('three_fifth')) {
	function three_fifth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
            return '<div class="three_fifth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('three_fifth', 'three_fifth');
}
if (!function_exists('four_fifth')) {
	function four_fifth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
            return '<div class="four_fifth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('four_fifth', 'four_fifth');
}
/*-----------------------------------------------------------------------------------*/
/*	Team
/*-----------------------------------------------------------------------------------*/


if (!function_exists('team_member')) {
	function team_member( $atts, $content = null ) {
            extract(shortcode_atts(array(
                        'style' => '',
                        'pic' => '',
			'name'   => '',
                        'designation' => ''
	    ), $atts));
	    
	    $output  = '<div class="team_member '.$style.'">';
            
            if(isset($pic) && $pic !=''){
                if(preg_match('!(?<=src\=\").+(?=\"(\s|\/\>))!',$pic, $matches )){
                    $output .= '<img src="'.$matches[0].'" class="animate zoom" alt="'.$name.'" />';
                }else{
                    $output .= '<img src="'.$pic.'" class="animate zoom" alt="'.$name.'" />';
                }
            }
            $output .= '<div class="member_info">';
            (isset($name) && $name !='')?$output .= '<h3>'.html_entity_decode($name).''.((isset($designation) && $designation !='')?' <small>[ '.$designation.' ]</small>':'').'</h3>':'';
            
            $output .= '<span class="clear"></span>';
            $output .= '<ul class="team_socialicons">';
            $output .=do_shortcode($content);
            $output .= '</ul></div>
                </div>';
            return $output;
	}
	add_shortcode('team_member', 'team_member');
}

if (!function_exists('team_social')) {
	function team_social( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'icon' => 'icon-facebook',
            'url' => ''
	    ), $atts));
           $class=str_replace('icon-','',$icon);
	   return '<li><a href="'.$url.'" title="'.apply_filters('vibe_shortcodes_team_social',$class).'" class="'.$class.'"><i class="'.$icon.'"></i></a></li>';;
	}
	add_shortcode('team_social', 'team_social');
}

/*-----------------------------------------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------------------------------------*/

if (!function_exists('button')) {
	function button( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'url' => '#',
			'target' => '_self',
                        'class' => 'base',
			'bg' => '',
			'hover_bg' => '',
			'color' => '',
                        'size' => 0,
                        'width' => 0,
                        'height' => 0,
                        'radius' => 0,
	    ), $atts));
		
             $rand = 'button'.rand(1,9999);
           $return ='<style> #'.$rand.'{'.(($bg)?'background-color:'.$bg.' !important;':'').''.(($color)?'color:'.$color.' !important;':'').''.(($size!= '0px')?'font-size:'.$size.' !important;':'').''.(($width!= '0px')?'width:'.$width.';':'').''.(($height!= '0px')?'padding-top:'.$height.';padding-bottom:'.$height.';':'').''.(($radius!= '0px')?'border-radius:'.$radius.';':'').'} #'.$rand.':hover{'.(($hover_bg)?'background-color:'.$hover_bg.' !important;':'').'}</style><a target="'.$target.'" id="'.$rand.'" class="button '.$class.'" href="'.$url.'">'.do_shortcode($content) . '</a>';
                
                 return $return;
	}
	add_shortcode('button', 'button');
}


/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/

if (!function_exists('alert')) {
	function alert( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'   => 'block',
                        'bg' => '',
                        'border' =>'',
                        'color' => '',
	    ), $atts));
		
           return '<div class="alert alert-'.$style.'" style="'.(($color)?'color:'.$color.';':'').''.(($bg)?'background-color:'.$bg.';':'').''.(($border)?'border-color:'.$border.';':'').'">'
                     . do_shortcode($content) . '</div>';
	}
	add_shortcode('alert', 'alert');
}

/*-----------------------------------------------------------------------------------*/
/*	Accordion Shortcodes
/*-----------------------------------------------------------------------------------*/


if (!function_exists('agroup')) {
	function agroup( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style'   => '',
                'id'=>''
	), $atts));
        global $rand;
	   return '<div class="accordion '.$style.'" id="accordion'.$id.'">' . 
                   do_shortcode($content) . '</div>';
	}
	add_shortcode('agroup', 'agroup');
}



if (!function_exists('accordion')) {
	function accordion( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'title' => 'Title goes here',
                        'id' => ''
	    ), $atts));
            
            $rid=rand(1,999);
	   return '<div class="accordion-group">
                     <div class="accordion-heading">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion'.$id.'"  href="#collapse'.$rid.'">
                            <i></i> '. $title .'</a>
                    </div>
                    <div id="collapse'.$rid.'" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <p>'. do_shortcode($content) .'</p>
                        </div>
                   </div>
                   </div>';
	}
	add_shortcode('accordion', 'accordion');
}




/*-----------------------------------------------------------------------------------*/
/*	Testimonial Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('testimonial')) {
	function testimonial( $atts, $content = null ) {
	global $vibe_options;
	    extract(shortcode_atts(array(
			'id'    	 => '',
            'length'    => 100,
	    ), $atts));
    
    $postdata=get_post($id);
    
    if(function_Exists('thumbnail_generator'))
    	$return .=thumbnail_generator($postdata,'testimonial',3,$length,0,0);

   return $return;
	}
	add_shortcode('testimonial', 'testimonial');
}


/*-----------------------------------------------------------------------------------*/
/*	CERTIFICATE SHORTCODES  : Student Name
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_certificate_student_name')) {
	function vibe_certificate_student_name( $atts, $content = null ) {
            $id=$_GET['u'];
            if(isset($id) && $id)
        		return get_the_author_meta('display_name',$id);
        	else
        		return '[certificate_student_name]';
	}
	add_shortcode('certificate_student_name', 'vibe_certificate_student_name');
}

/*-----------------------------------------------------------------------------------*/
/*	CERTIFICATE SHORTCODES  : Student Email
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_certificate_student_email')) {
	function vibe_certificate_student_email( $atts, $content = null ) {
            $id=$_GET['u'];
            if(isset($id) && $id)
        		return get_the_author_meta('user_email',$id);
        	else
        		return '[certificate_student_email]';
	}
	add_shortcode('certificate_student_email', 'vibe_certificate_student_email');
}

/*-----------------------------------------------------------------------------------*/
/*	CERTIFICATE SHORTCODES  : COURSE NAME
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_certificate_course')) {
	function vibe_certificate_course( $atts, $content = null ) {
            $id=$_GET['c'];
            if(isset($id) && $id)
        		return get_the_title($id);
        	else
        		return '[certificate_course]';
	}
	add_shortcode('certificate_course', 'vibe_certificate_course');
}

/*-----------------------------------------------------------------------------------*/
/*	CERTIFICATE SHORTCODES  : COURSE MARKS
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_certificate_student_marks')) {
	function vibe_certificate_student_marks( $atts, $content = null ) {
            $uid=$_GET['u'];
             $cid=$_GET['c'];
            if(isset($uid) && is_numeric($uid) && isset($cid) && is_numeric($cid)  && get_post_type($cid) == 'course')
        		return get_post_meta($cid,$uid,true);
        	else
        		return '[certificate_student_marks]';
	}
	add_shortcode('certificate_student_marks', 'vibe_certificate_student_marks');
}

/*-----------------------------------------------------------------------------------*/
/*	CERTIFICATE SHORTCODES  : CERTIFICATE DATE
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_certificate_student_date')) {
	function vibe_certificate_student_date( $atts, $content = null ) {
            $uid=$_GET['u'];
            $cid=$_GET['c'];
            global $bp,$wpdb;

            if(isset($uid) && is_numeric($uid) && isset($cid) && is_numeric($cid) && get_post_type($cid) == 'course'){
            $course_submission_date = $wpdb->get_results($wpdb->prepare( "
								SELECT activity.date_recorded as date FROM {$bp->activity->table_name} AS activity
								WHERE 	activity.component 	= 'course'
								AND 	activity.type 	= 'student_certificate'
								AND 	user_id = %d
								AND 	item_id = %d
								ORDER BY date_recorded DESC LIMIT 0,1
							" ,$uid,$cid));

           		if(isset($course_submission_date[0]->date))
        			return date('F d, Y', strtotime($course_submission_date[0]->date));
        		else
        			return '[certificate_student_date]';
        	}	
	}
	add_shortcode('certificate_student_date', 'vibe_certificate_student_date');
}

/*-----------------------------------------------------------------------------------*/
/*	CERTIFICATE SHORTCODES  : CERTIFICATE CODE
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_certificate_code')) {
	function vibe_certificate_code( $atts, $content = null ) {
            $uid=$_GET['u'];
            $cid=$_GET['c'];
            if(isset($uid) && is_numeric($uid) && isset($cid) && is_numeric($cid) && get_post_type($cid) == 'course'){
            	$ctemplate=get_post_meta($cid,'vibe_certificate_template',true);
            	if(isset($ctemplate) && $ctemplate){
            		$code = $ctemplate.'-'.$cid.'-'.$uid;
            	}else{
            		$code = get_the_ID().'-'.$cid.'-'.$uid;
            	}
            	return $code;
            }
            else
        		return '[certificate_code]';
	}
	add_shortcode('certificate_code', 'vibe_certificate_code');
}

/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('tabs')) {
	function tabs( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'style'   => '',
                        'theme'   => ''
	    ), $atts));
            
		$defaults=$tab_icons = array();
                extract( shortcode_atts( $defaults, $atts ) );
		
		// Extract the tab titles for use in the tab widget.
		preg_match_all( '/tab title="([^\"]+)" icon="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		
		$tab_titles = array();
                
		if(!count($matches[1])){ 
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		if( isset($matches[1]) ){ $tab_titles = $matches[1];}
		}else{
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; $tab_icons= $matches[2];}
		}
		
		
		$output = '';
                global $vibe_options;
                $vibe_options['rand'] = rand(1,1000);
		if( count($tab_titles) ){
		    $output .= '<div id="vibe-tabs-'. rand(1, 100) .'" class="tabs tabbable '.$style.' '.$theme.'">';
			$output .= '<ul class="nav nav-tabs clearfix">';
			$i=0;
                         foreach( $tab_titles as $tab ){ 
                                $tabstr= str_replace(' ', '-', $tab[0]);
				$output .= '<li><a href="#tab-'. $tabstr .'-'.$vibe_options['rand'].'">'.(isset($tab_icons[$i][0])?'<span><i class="' . $tab_icons[$i][0] . '"></i></span>': '').'' . $tab[0] . '</a></li>';
				$i++;
			}
		    $output .= '</ul><div class="tab-content">';
		    $output .= do_shortcode( $content );
		    $output .= '</div></div>';
		} else {
			$output .= do_shortcode( $content );
		}
		
		return $output;
	}
	add_shortcode( 'tabs', 'tabs' );
}

if (!function_exists('tab')) {
	function tab( $atts, $content = null ) { global $vibe_options;
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		$tabstr= str_replace(' ', '-', $title);
		return '<div id="tab-'. $tabstr .'-'.$vibe_options['rand'].'" class="tab-pane"><p>'. do_shortcode( $content ) .'</p></div>';
	}
	add_shortcode( 'tab', 'tab' );
}


/*-----------------------------------------------------------------------------------*/
/*	Tooltips
/*-----------------------------------------------------------------------------------*/

if (!function_exists('tooltip')) {
	function tooltip( $atts, $content = null ) {
		extract(shortcode_atts(array(
	        'direction'   => 'top',
	        'tip' => 'Tooltip',
	    ), $atts));
		$istyle='';

           return '<a data-rel="tooltip" class="tip" data-placement="'.$direction.'" data-original-title="'.$tip.'">'.do_shortcode($content).'</a>';

	}
	add_shortcode('tooltip', 'tooltip');
}


/*-----------------------------------------------------------------------------------*/
/*	Taglines
/*-----------------------------------------------------------------------------------*/

if (!function_exists('tagline')) {
	function tagline( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'style'   => '',
                        'bg'   => '',
                        'border'   => '',
                        'bordercolor'   => '',
                        'color'   => '',
	    ), $atts));
           return '<div class="tagline '.$style.'" style="background:'.$bg.';border-color:'.$border.';border-left-color:'.$bordercolor.';color:'.$color.';" >'.do_shortcode($content).'</div>';
	}
	add_shortcode('tagline', 'tagline');
}




/*-----------------------------------------------------------------------------------*/
/*	POPUP
/*-----------------------------------------------------------------------------------*/

if (!function_exists('popupajax')) {
	function popupajax( $atts, $content = null ) {
            extract(shortcode_atts(array(
            	'id'   => '',
                'auto' => 0,
                'classes' =>''
            ), $atts));


  
   $return='';
    if($auto){
     $return .='<script>jQuery(window).load(function(){ jQuery("#anchor_popup_'.$id.'").trigger("click");});</script>'; 
    }
        
        $return .= '<a class="popup-with-zoom-anim ajax-popup-link '.$classes.'" href="'.admin_url('admin-ajax.php').'?ajax=true&action=vibe_popup&id='.$id.'" id="anchor_popup_'.$id.'">
                   '.do_shortcode($content).'</a>';
        return $return;

	}
	add_shortcode('popup', 'popupajax');
}



/*-----------------------------------------------------------------------------------*/
/*	Google Maps shortcode
/*-----------------------------------------------------------------------------------*/

if (!function_exists('gmaps')) {
	function gmaps( $atts, $content = null ) { 
                        $map ='<div class="gmap">'.$content.'</div>';
                        return $map;
	}
	add_shortcode('map', 'gmaps');
}

/*-----------------------------------------------------------------------------------*/
/*	Gallery shortcode
/*-----------------------------------------------------------------------------------*/

if (!function_exists('gallery')) {
	function gallery( $atts, $content = null ) { 
           extract(shortcode_atts(array(
                        'size' => 'normal',
                        'ids' => ''
                            ), $atts));
            $gallery='<div class="gallery '.$size.'">';
            
            
                if(isset($ids) && $ids!=''){
                    $rand='gallery'.rand(1,999);
                    $posts=explode(',',$ids);
                    foreach($posts as $post_id){
                         // IF Ids are not Post Ids
                           if ( wp_attachment_is_image( $post_id ) ) {
                               $attachment_info = wp_get_attachment_info($post_id);
                               
                               $full=wp_get_attachment_image_src( $post_id, 'full' );
                               $thumb=wp_get_attachment_image_src( $post_id, $size );
                               
                               if(is_array($thumb))$thumb=$thumb[0];
                                if(is_array($full))$full=$full[0];
                                
                               $gallery.='<a href="'.$full.'" title="'.$attachment_info['title'].'"><img src="'.$thumb.'" alt="'.$attachment_info['title'].'" /></a>';
                            }
                    }
                }
            $gallery.='</div>';
                        return $gallery;
	}
	add_shortcode('gallery', 'gallery');
}


/*-----------------------------------------------------------------------------------*/
/*	HEADING
/*-----------------------------------------------------------------------------------*/

if (!function_exists('heading')) {
	function heading( $atts, $content = null ) { 
             extract(shortcode_atts(array(
                        'style' => '',
                            ), $atts));
                return '<h3 class="heading '.$style.'"><span>'.do_shortcode($content).'</span></h3>';
	}
	add_shortcode('heading', 'heading');
}




/*-----------------------------------------------------------------------------------*/
/*	PROGRESSBARS
/*-----------------------------------------------------------------------------------*/

if (!function_exists('progressbar')) {
	function progressbar( $atts, $content = null ) { 
			extract(shortcode_atts(array(
			             'color' => '',
                                     'bg' => '',
                                     'textcolor' => '',
			             'percentage' => '20'
			                 ), $atts));
				
           return '<div class="progress" '.(($bg)?'style="background-color:'.$bg.';"':'').'>
             <div class="bar animate strech" style="width: '.$percentage.'%;'.(($color)?'background-color:'.$color.';':'').''.((isset($padding) && $padding != '0px' )?'padding:'.$padding.';':'').''.(($textcolor)?'color:'.$textcolor.';':'').'">'.do_shortcode($content).'<span>'.$percentage.'%</span></div>
           </div>';

	}
	add_shortcode('progressbar', 'progressbar');
}


/*-----------------------------------------------------------------------------------*/
/*	FORMS
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibeform')) {
	function vibeform( $atts, $content = null ) { 
            extract(shortcode_atts(array(
			             'to' => '',
                         'subject' => '',
			             ), $atts));
	
            $id=rand(1,999);
           return apply_filters('vibe_shortcode_form','<div class="form">
           	 <form method="post" data-to="'.$to.'" data-subject="'.$subject.'">'.
                    do_shortcode($content)  
           	 .'<div class="response"></div></form>
           	 </div>');

	}
	add_shortcode('form', 'vibeform');
}


if (!function_exists('form_element')) {
	function form_element( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'type' => 'text',
            'validate' => '',
            'options' => '',
            'placeholder' => 'Name'
	    ), $atts));
            $output='';
            switch($type){
                case 'text': $output .= '<input type="text" placeholder="'.$placeholder.'" class="form_field text" data-validate="'.$validate.'" />';
                    break;
                case 'textarea': $output .= '<textarea placeholder="'.$placeholder.'" class="form_field  textarea" data-validate="'.$validate.'"></textarea>';
                    break;
                case 'select': $output .= '<select class="form_field  select" placeholder="'.$placeholder.'">';
                                $output .= '<option value="">'.$placeholder.'</option>';
                                $options  = explode(',',$options);
                                foreach($options as $option){
                                    $output .= '<option value="'.$option.'">'.$option.'</option>';
                                }
                                $output .= '</select>';
                    break;
                case 'submit':
                    $output .= '<input type="submit" class="form_submit button primary" value="'.$placeholder.'" />';
                    break;
            }

	   return $output;
	}
	add_shortcode('form_element', 'form_element');
}




?>