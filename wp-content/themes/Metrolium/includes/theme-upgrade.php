<?php
$theme_version = get_theme_mod('theme_version', '1.0');

// Upgrade v1.0 to 1.1
if ($theme_version < '1.1')
{
	// Post meta checkboxes' checked value for has changed from 'true' to 'on'
	$wpdb->query(
		$wpdb->prepare(
			"
			UPDATE $wpdb->postmeta
			SET meta_value = %s
			WHERE (meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s)
			AND meta_value = %s
			",
			'on',
			'portfolio_options_show_other_projects',
			'testimonial_show_testimonial',
			'page_options_show_breadcrumbs',
			'page_options_show_subtitle',
			'page_options_show_titlebar_cta',
			'true'
		)
	);

	// Post meta radio field values are now stored as serialized data, not strings
	$radios = $wpdb->get_results(
		$wpdb->prepare(
			"
			SELECT meta_id, meta_value FROM $wpdb->postmeta
			WHERE meta_key = %s OR meta_key = %s
			",
			'page_options_breadcrumbs_position',
			'page_options_titlebar_textalign'
		)
	);

	foreach ($radios as $radio)
	{
		if (!@unserialize($radio->meta_value)) {
			$wpdb->query(
				$wpdb->prepare(
					"
					UPDATE $wpdb->postmeta
					SET meta_value = %s
					WHERE meta_id = %d
					",
					serialize(array($radio->meta_value)),
					$radio->meta_id
				)
			);
		}
	}

	// Force Custom CSS Rewrite
	$now = new DateTime();
	set_theme_mod('wp_customizer_last_saved', $now->format('U'));

	// Set new theme version to prevent upgrade running more than once
	set_theme_mod('theme_version', '1.1');
}

// Upgrade v1.1 to 1.1.1
if ($theme_version < '1.1.1')
{
	// Change of plan, changing radios to selects, converting serialized data to strings
	$radios = $wpdb->get_results(
		$wpdb->prepare(
			"
			SELECT meta_id, meta_value FROM $wpdb->postmeta
			WHERE meta_key = %s OR meta_key = %s
			",
			'page_options_breadcrumbs_position',
			'page_options_titlebar_textalign'
		)
	);

	foreach ($radios as $radio)
	{
		if (is_serialized($radio->meta_value)) {
			$new_value = unserialize($radio->meta_value);
			$radio->meta_value = $new_value[0];
		}

		$wpdb->query(
			$wpdb->prepare(
				"
				UPDATE $wpdb->postmeta
				SET meta_value = %s
				WHERE meta_id = %d
				",
				$radio->meta_value,
				$radio->meta_id
			)
		);
	}

	// Force Custom CSS Rewrite
	$now = new DateTime();
	set_theme_mod('wp_customizer_last_saved', $now->format('U'));

	// Set new theme version to prevent upgrade running more than once
	set_theme_mod('theme_version', '1.1.1');
}