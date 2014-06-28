<?php
/**
**   Template Name: analyze Template 
 * Description: The template for displaying analyze page after login for quantimodo.
 
 */

?>
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php //echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<!-- Styles -->
    <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:700' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/qtip/jquery.qtip.min.css" />
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/welcome.css">
    <!-- Scripts -->
   <script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.6.2.min.js"></script>
   <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery-ui.css" />
  <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.9.1.js"></script>
  <script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.js"></script>
  
  <script>
  $(document).ready(function() {
$('a.login-window').click(function() {
    
            //Getting the variable's value from a link 
    var loginBox = $(this).attr('href');

    //Fade in the Popup
    $(loginBox).fadeIn(300);
    
    //Set the center alignment padding + border see css style
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });
    
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(300);
    
    return false;
});

// When clicking on the button close or the mask layer the popup closed
$('a.close, #mask').live('click', function() { 
  $('#mask , .login-popup').fadeOut(300 , function() {
    $('#mask').remove();  
}); 
return false;
});
});
</script>
   <!-- fav icons -->
   <link rel="shortcut icon" href="/favicon.ico">
  
  </script>

</head>
<?php if(!is_user_logged_in())
{
	header('Location: https://quantimodo.com/');
}
	?>
<body class="analysis" onLoad="adjustPointer()">

<!-- data for all popup box attached with this page menu .-->
<!-- this is first one , that is for upload data button . start here!!-->
<div id="upload_data" class="login-popup">
  <form method="post" class="signin" action="#">
  
        <fieldset class="textbox">
        <div class="modal-header">
			<a href="#" class="close"><img src="<?php echo get_template_directory_uri(); ?>/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			<h3>Upload exported data files</h3>
		</div>
		<div class="modal-body">
			<h4>Please choose exported data files to upload:</h4>
			<input id="files" class="fileInput" name="files[]" multiple="multiple" type="file">
		</div>
		<div class="modal-footer" style="padding-top:10px;">
			<button class="bttn btn-primary" id="upload-send" type="submit">Upload files</button>
			
		</div>
              
        </fieldset>
  </form>
</div>
<!-- first menu item , upload data end here -->
<!-- this is second one , that is for manage data button . start here!!-->
<div id="manage_data" class="login-popup">

        <div class="modal-header">
            <h3>Manage Connectors<a href="#" class="close"><img src="<?php echo get_template_directory_uri(); ?>/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a></h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div>
                    
                            <div style="padding-left:20px; float:left;">Sync status</div>
                            <div style="padding-left:20px; float:left;">Connector</div>
                            <div style="padding-left:20px; float:left;">Last Sync.</div>
                            <div style="padding-left:20px; float:left;">Settings</div>
                            <div style="padding-left:20px; float:left;">Remove</div>
                       
                </div>
            </div>
        </div>
        <div class="modal-footer">
                <div class="synchAll">
                   <a id="sync-all" href="#" class="bttn btn-info">sync all your devices now </a>
                </div>
        </div>
    
</div>
<!-- second menu item , manage data end here -->
<!-- this is third one , that is for link accounts button . start here!!-->
<div id="link_accounts" class="login-popup">
<a href="#" class="close"><img src="<?php echo get_template_directory_uri(); ?>/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
  <form method="post" class="signin" action="#">
        <fieldset class="textbox">
        <label class="username">
        <span>Username or email</span>
        <input id="username" name="username" value="" type="text" autocomplete="on" placeholder="Username">
        </label>
        <label class="password">
        <span>Password</span>
        <input id="password" name="password" value="" type="password" placeholder="Password">
        </label>
        <button class="submit button" type="button">Sign in</button>
        <p>
        <a class="forgot" href="#">Forgot your password?</a>
        </p>        
        </fieldset>
  </form>
</div>
<!-- third menu item , link accounts end here -->

<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
<div class="main-container">

    <header>
        <div class="header-inner analysis clearfix" style="width:900px; height:76px;">
		<a id="logo" class="ir" href="/">Quantimodo Home</a>
            <nav id="analysisnav">
                <ul>
                    <li>
                        <a href="#upload_data" class="login-window">Upload Data</a>
                    </li>
                    <li class="nav-divider"></li>
                    <li>
                        <a href="#manage_data" class="login-window">Manage Data</a>
                    </li>
                    <li class="nav-divider"></li>
                    <li>
                        <a href="#link_accounts" class="login-window">Link Accounts</a>
                    </li>
                    <li class="nav-divider"></li>
                    <li>
                        <a href="<?php echo home_url(); ?>/blog/identifying-correlations">Blog</a>
                    </li>
                </ul>
            </nav>
            <?php
			$current_user = wp_get_current_user();
			//echo 'User email: ' . $current_user->user_email . '<br />';
			?>
            <div class="user-info">
                <span class="user-name"><?php echo $current_user->user_email; ?></span>
                <!--<a class="settings-btn" href="#">settings</a>-->
                <a href="<?php echo wp_logout_url( home_url() ); ?>" title="Logout" class="logoff-btn">Logout</a>
            </div>

        </div>
    </header>


    <section class="clearfix" id="experiment">
<script>
  $(function() {
    $("#date_start").datepicker();
  });
  </script>
        <div class="select-date">
            <input type="text" placeholder="Starting Date" name="date-from" class="hasDatepicker" id="date_start">
            <label for="date-to">-</label>
            <input type="text" placeholder="Ending Date" name="date-to" class="date-to hasDatepicker" id="date_end">
        </div>
        <div class="select-duration">
            <input type="hidden" value="daily" id="duration">
            <ul class="clearfix">
                <li><a grouping="0" href="#">Minutely</a></li>
                <li class="nav-divider"></li>
                <li><a grouping="1" href="#">Hourly</a></li>
                <li class="nav-divider"></li>
                <li><a grouping="2" class="active" href="#">Daily</a></li>
                <li class="nav-divider"></li>
                <li><a grouping="3" href="#">Weekly</a></li>
                <li class="nav-divider"></li>
                <li><a grouping="4" href="#">Monthly</a></li>
            </ul>
        </div>
    </section>
    <section id="behaviour" class="clearfix">
        <div class="colm">
            <div class="inner-col">
                <h4><a href="" class="dwnld edit-bvr edit-links">Edit Input Category</a></h4>
                <div class="info-tooltip orange"></div>
                <div class="details-bottom">
                    <div class="info-tooltip black"></div>
                    <div class="custom-select">
                        <div class="dd-arrow"></div>
                        <select>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                        </select>
                    </div> 
                </div>
            </div>
            <div class="filler"></div>
            <div class="inner-col second">
                <h4><a href="" class="edit-var edit-links" style="padding-left:25px;">Edit Variable Options</a></h4>
                <a class="plus-button" href="javascript:App.variables.add($('#input_categories_select'),$('#input_vars_select'),'input')"></a>
                <div class="info-tooltip orange"></div>
                <div class="details-bottom">
                    <div class="info-tooltip black"></div>
                    <div class="custom-select">
                        <div class="dd-arrow"></div>
                        <select>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="colm second">
            <div class="inner-col">
                <h4><a href="" class="upld edit-bvr edit-links">Edit Output Category</a></h4>
                <div class="info-tooltip blue"></div>
                <div class="details-bottom">
                    <div class="info-tooltip black"></div>
                    <div class="custom-select">
                        <div class="dd-arrow"></div>
                        <select>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="filler"></div>
            <div class="inner-col second">
                <h4><a href="" class="edit-var-output edit-links" style="padding-left:25px;">Edit Variable Options</a></h4>
                <a class="plus-button" href=""></a>
                <div class="info-tooltip blue"></div>
                <div class="details-bottom right">
                    <div class="info-tooltip black"></div>
                    <div class="custom-select">
                        <div class="dd-arrow"></div>
                        <select>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                            <option value="">Medhelper app</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="correlations" class="graph-item">
        <div class="bar-outer">
        </div>
        <div class="titleBox">Correlation Scatterplot</div>
        <div class="graph-inner">
            <div class="statistical-relation">
                <h4>Statistical Relationship = Significant</h4>
                <div class="pointer">
                    <canvas id="pointer" width="70" height="70">
                        <p>Your browser doesn't support canvas.</p>
                    </canvas>
                </div>
            </div>
            <div id="scatterplot"></div>
			<a class="feedback-btn" href="#feedback">How can we make Quantimodo better?</a> 
            <div class="main-social-sharing" class="clearfix">
                <div class="social-inner">
			 <a onClick="return !window.open(this.href, 'Facebook', 'width=640,height=300')" target="_parent" class="mss-fbBtn ir" href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=http://quantimodo.com/mockup/analysis.html&p[title]=Help us eradicate mental illness at QuAnTiMoDo.CoM!&p[summary]=Help us eradicate mental illness at QuAnTiMoDo.CoM! Help us eradicate mental illness at QuAnTiMoDo.CoM!&p[images][1]=http://quantimodo.com/blog/wp-content/uploads/2013/01/quantiomodmisc1.png&p[images][0]=http://quantimodo.com/blog/wp-content/uploads/2013/01/quantiomod128x128.png">Facebook</a>
			 <a onClick="return !window.open(this.href, 'Facebook', 'width=640,height=300')" target="_parent" class="mss-gBtn ir" href="https://plus.google.com/share?url=http://quantimodo.com/mockup/analysis.html">Google</a>
			 <a onClick="return !window.open(this.href, 'Facebook', 'width=640,height=260')" target="_parent" class="mss-tBtn ir" href="https://twitter.com/intent/tweet?url=http://quantimodo.com/mockup/analysis.html&amp;text=Help us eradicate mental illness at QuAnTiMoDo.CoM!&amp;via=quantimodo.com">Twitter</a>
<!--
                    <a class="mss-fbBtn ir" href="https://www.facebook.com/Quantimodology" target="_blank">Facebook Like</a>
                    <a class="mss-gBtn ir" href="https://plus.google.com/communities/100581500031158281444" target="_blank">Google +1</a>
                    <a class="mss-tBtn ir" href="https://twitter.com/QuantimodoApp" target="_blank">Twitter</a>
-->
                    <a class="mss-eBtn ir" href="email">Email</a>
                    <a class="mss-moreBtn ir" href="twitter">More</a>
                </div>
            </div>
        </div>
         <script type="text/javascript">
function increaseBtnOnclick() {
   var x = document.getElementById("shifter_time_value").value++;
  // alert(x);
  $("#my_div").text(x);
}
function decreasebtnonclick()
{
	 var x = document.getElementById("shifter_time_value").value--;
  // alert(x);
  $("#my_div").text(x);
}
</script>
        <div id="time_shift">
	    	<button id="shift-backward" class="btn" style="display:inline;" onClick="decreasebtnonclick()">←</button>
	    	<label style="display:inline;">Time shifted for </label>
	    	<input type="hidden" id="shifter_time_value" style="display:inline;" value="0"/>
            <label id="my_div" style="display:inline;">0</label>
	    	<button id="shift-forward" class="btn" style="display:inline;" onClick="increaseBtnOnclick()">→</button>
	    </div>
    </section>
    <section id="timeline" class="graph-item">
        <div class="bar-outer">
        </div>
        <div class="graph-inner">
            <div id="timelinechart"></div>
            <a href="" class="beta-btn">Try Our New Experimental Features</a>
            <!-- <img src="images/timeline-placeholder.png" class="placehoder"> -->
            <div class="main-social-sharing" class="clearfix">
                <div class="social-inner">
			 <a onClick="return !window.open(this.href, 'Facebook', 'width=640,height=300')" target="_parent" class="mss-fbBtn ir" href="http://www.facebook.com/sharer/sharer.php?s=100&p[url]=http://quantimodo.com/mockup/analysis.html&p[title]=Help us eradicate mental illness at QuAnTiMoDo.CoM!&p[summary]=Help us eradicate mental illness at QuAnTiMoDo.CoM! Help us eradicate mental illness at QuAnTiMoDo.CoM!&p[images][1]=http://quantimodo.com/blog/wp-content/uploads/2013/01/quantiomodmisc1.png&p[images][0]=http://quantimodo.com/blog/wp-content/uploads/2013/01/quantiomod128x128.png">Facebook</a>
			 <a onClick="return !window.open(this.href, 'Facebook', 'width=640,height=300')" target="_parent" class="mss-gBtn ir" href="https://plus.google.com/share?url=http://quantimodo.com/mockup/analysis.html">Google</a>
			 <a onClick="return !window.open(this.href, 'Facebook', 'width=640,height=260')" target="_parent" class="mss-tBtn ir" href="https://twitter.com/intent/tweet?url=http://quantimodo.com/mockup/analysis.html&amp;text=Help us eradicate mental illness at QuAnTiMoDo.CoM!&amp;via=quantimodo.com">Twitter</a>
<!--
                    <a class="mss-fbBtn ir" href="https://www.facebook.com/Quantimodology" target="_blank">Facebook Like</a>
                    <a class="mss-gBtn ir" href="https://plus.google.com/communities/100581500031158281444" target="_blank">Google +1</a>
                    <a class="mss-tBtn ir" href="https://twitter.com/QuantimodoApp" target="_blank">Twitter</a>
-->
                    <a class="mss-eBtn ir" href="email">Email</a>
                    <a class="mss-moreBtn ir" href="twitter">More</a>
                </div>
            </div>
        </div>
    </section>
    <section id="notes" style="display:none">
        <div class="line-v"></div>
        <div class="line-h"></div>
        <a class="share-btn" href="#">Share this</a>
        <a class="goto-top" href="#">Go to top</a>
        <div class="notes-inner">
        <div class="notes-header clearfix">
            <div class="notes-title">
                <div class="notes-icon"></div>
                Notes
            </div>
            <a class="add-note" href="#">
                Create new annotation
                <div class="icon-add-note"></div>
            </a>
        </div>
        <div class="notes-bottom scroll-pane">
            <div class="notes-data clearfix">
                <div class="date-posted">
                    <h3>27 May 2013</h3>
                </div>
                <div class="post-details">
                    <p>Lorem Ipsum is simply dummy text of the printing</p>
                </div>
                <a class="edit-note" href="#">edit note</a>
            </div>
            <div class="notes-data clearfix">
                <div class="date-posted">
                    <h3>27 May 2013</h3>
                </div>
                <div class="post-details">
                    <p>Lorem Ipsum is simply dummy text of the printing</p>
                </div>
                <a class="edit-note" href="#">edit note</a>
            </div>
            <div class="notes-data clearfix">
                <div class="date-posted">
                    <h3>27 May 2013</h3>
                </div>
                <div class="post-details">
                    <p>Lorem Ipsum is simply dummy text of the printing</p>
                </div>
                <a class="edit-note" href="#">edit note</a>
            </div>
            <div class="notes-data clearfix">
                <div class="date-posted">
                    <h3>27 May 2013</h3>
                </div>
                <div class="post-details">
                    <p>Lorem Ipsum is simply dummy text of the printing</p>
                </div>
                <a class="edit-note" href="#">edit note</a>
            </div>
            <div class="notes-data clearfix">
                <div class="date-posted">
                    <h3>27 May 2013</h3>
                </div>
                <div class="post-details">
                    <p>Lorem Ipsum is simply dummy text of the printing</p>
                </div>
                <a class="edit-note" href="#">edit note</a>
            </div>
            <div class="notes-data clearfix">
                <div class="date-posted">
                    <h3>27 May 2013</h3>
                </div>
                <div class="post-details">
                    <p>Lorem Ipsum is simply dummy text of the printing</p>
                </div>
                <a class="edit-note" href="#">edit note</a>
            </div>
            <div class="notes-data clearfix">
                <div class="date-posted">
                    <h3>27 May 2013</h3>
                </div>
                <div class="post-details">
                    <p>Lorem Ipsum is simply dummy text of the printing</p>
                </div>
                <a class="edit-note" href="#">edit note</a>
            </div>
        </div>
        </div>
    </section>
	<div style="padding-bottom:40px;"></div>
</div>
<?php get_footer(); ?>
