<input type="hidden" id="euged-sidebars" name="euga[sidebars]" value="<?php echo implode(',', array_keys($data['sidebars'])); ?>">
<div class="euged-control euged-control-sidebars">
	<ul id="euged-sidebars-sortable">
		<?php foreach($data['sidebars'] as $id => $name): ?>
			<li id="<?php echo $id; ?>"><i class="icon-reorder"></i><?php echo $name; ?><i class="icon-remove"></i></li>
		<?php endforeach; ?>
	</ul>
</div>
<div class="euged-control euged-control-sidebars-add">
	<label>
		<span class="euged-control-title">Add New Sidebar</span>
		<input type="text" id="euga_sidebar" name="euga_sidebar" value="">
	</label>
	<a href="#" id="euged-sidebars-add" class="btn"><i class="icon-plus"></i> Add Sidebar</a>
</div>