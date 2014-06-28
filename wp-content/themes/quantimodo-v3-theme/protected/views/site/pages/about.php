<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>Quantimodo project is initiated by Mike Sinn.
You can check also check <a href="http://thinkbynumbers.org/statistical-cost-benefit-analysis-vs-irrational-emotion/">ByNumbers</a> site in order to get better idea about Mike.</p>
<p><a href="<?php print $this->createUrl('/site/page', array('view'=>'policy')); ?>">User data collection policy</a></p>

<code><?php // echo __FILE__; ?></code>
