<?php
class Euged
{
	/**
	 * Return date in human format; X x ago, i.e. 3 days ago, or 22 minutes ago
	 *
	 * @access public
	 * @param string $time
	 * @return string
	 */
	public function human_date($time)
	{
		$diff = time()-$time;
		$tokens = array (
			31536000 => __( 'year', 'euged' ),
			2592000 => __( 'month', 'euged' ),
			604800 => __( 'week', 'euged' ),
			86400 => __( 'day', 'euged' ),
			3600 => __( 'hour', 'euged' ),
			60 => __( 'minute', 'euged' ),
			1 => __( 'second', 'euged' )
		);

		foreach ($tokens as $unit => $text)
		{
			if ($diff < $unit)
			{
				continue;
			}
			$numberOfUnits = floor($diff / $unit);
			return $numberOfUnits . ' ' . $text . ( $numberOfUnits > 1 ? 's' : '' );
		}
	}

	/**
	 * Returns a range array of pixel sizes
	 *
	 * @access public
	 * @param int $min
	 * @param int $max
	 * @param int $increment
	 * @return array
	 */
	public function pixel_size_range ( $min = 11, $max = 20, $increment = 1 )
	{
		$return = array();
		foreach ( range ( $min, $max, $increment ) as $size )
		{
			$return[$size . 'px'] = $size . 'px';
		}
		return $return;
	}

	/**
	 * Parses the json encoded Google Fonts file into an associative array
	 *
	 * @access public
	 * @return array
	 */
	public function parse_google_fonts()
	{
		ob_start();
		include('google-fonts.php');
		$fonts = ob_get_contents();
		ob_end_clean();

		$fonts = json_decode($fonts);

		$return = array();

		foreach($fonts as $font)
		{
			$value = $font->family;
			$label = $font->family;
			$return[$value] = $label;
		}

		return $return;
	}

	/**
	 * Returns URL with correct prefixed protocol (http:// https://) where applicable
	 *
	 * @access public
	 * @param string $url
	 * @return string
	 */
	public function parse_url($url)
	{
		// Check if URL is internal
		if ( substr($url, 0, 1) == '/' || substr($url, 0, 1) == '#' )
		{
			return $url;
		}

		$prefix = !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ? 'https://' : 'http://';
		return $prefix . str_replace(array('http://', 'https://'), '', $url);
	}
}
$Euged = new Euged();