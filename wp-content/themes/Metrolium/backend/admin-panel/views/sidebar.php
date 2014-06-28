<?php
$icons = array(
	'welcome'	=> 'info',
	'global'	=> 'home',
	'sidebars'	=> 'reorder',
	'settings'	=> 'cog',
	'blog'	=> 'font',
	'portfolio'	=> 'tint',
	'help'	=> 'question'
);
?>

<ul id="euged-admin-sidebar">
	<?php
	foreach ($data as $section => $options)
	{
		if ($section == 'welcome')
		{
			global $global_admin_options;
			if (!empty($global_admin_options['welcome_hide'])) {
				continue;
			}
		}

		printf('<li><a href="#%s"><span><i class="icon-%s"></i></span>%s</a></li>',
				$section,
				!empty($icons[$section]) ? $icons[$section] : '',
				ucwords( str_replace( '_', ' ', $section ) )
			);
	}
	?>
</ul>
<div id="euged-admin-content">