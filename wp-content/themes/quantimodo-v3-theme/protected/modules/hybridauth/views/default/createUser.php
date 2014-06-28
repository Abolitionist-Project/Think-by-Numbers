<div class="form">
	<h2>Simply confirm your username and an email</h2>

	<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'create-user-form',
			'enableAjaxValidation'=>false,
		)); 
	?>

	<p><?php 
		print "<img style='float:left;' src='".Yii::app()->getModule('hybridauth')->getAssetsUrl()."/images/".strtolower($provider).".png'/>
			Your authentication provider is: <strong>".$provider." </strong>";
		echo $form->errorSummary($user); 
	?></p><br style='clear:both;'>

	<div  class="row">
		<?php echo $form->labelEx($user,'username'); ?>
		<?php echo $form->textField($user,'username'); ?>
		<?php echo $form->error($user,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($user,'email'); ?>
		<?php echo $form->textField($user,'email'); ?>
		<?php echo $form->error($user,'email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($user->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	
	<br><p class="note">Fields with <span class="required">*</span> are required.</p>
	
<?php $this->endWidget(); ?>

</div><!-- form -->