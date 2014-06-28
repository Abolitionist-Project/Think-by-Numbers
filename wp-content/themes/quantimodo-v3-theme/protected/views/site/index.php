<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php 
	if (Yii::app()->user->isGuest) print "Please login, so we can make statistical analisys based on your data!<br><br>";
	else print "We are glad to have you back ".Yii::app()->user->name.", how are you?<br><br>";
?>
<p>Here you can submit your data files for analisys.</p>
<!-- <p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php //echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php //echo $this->getLayoutFile('main'); ?></code></li>
</ul>
-->
<br>
<p>For more details on how to further develop this application, please read
the <a href="#doc_link">documentation</a>.
Feel free to ask in the <a href="#forum_link">forum</a>,
should you have any questions.</p>
