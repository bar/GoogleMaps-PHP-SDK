<?php
namespace GoogleStaticMaps;

/**
 * Google Static Map Marker Set.
 *
 * @author Ber Clausen <ber.clausen [at] gmail.com>
 * @link https://developers.google.com/maps/documentation/staticmaps/#Markers
 */
class MarkerSet {

/**
 * Marker separator.
 */
	const SEPARATOR = '|';

/**
 * Marker custom icon.
 *
 * @var MarkerCustomIcon
 */
	protected $_customIcon = null;

/**
 * Marker Styles.
 *
 * @var MarkerStyles
 */
	protected $_styles = null;


/**
 * Marker Locations.
 *
 * @var array Array of Location objects.
 */
	protected $_locations = array();

/**
 *
 */
	public function __construct($params = array()) {
		if (isset($params['customIcon'])) {
			$this->setCustomIcon($params['customIcon']);
		}

		if (isset($params['styles'])) {
			$this->setStyles($params['styles']);
		}

		if (isset($params['locations'])) {
			$this->setLocations($params['locations']);
		}
	}

/**
 * Output the marker url string.
 *
 * @return string
 */
	public function __toString() {
		return $this->build();
	}

/**
 * Set the marker cuistom icon.
 *
 * @param mixed $customIcon Array or MarkerCustomIcon object.
 * @return MarkerSet
 */
	public function setCustomIcon($customIcon) {
		if (is_array($customIcon)) {
			$customIcon = new MarkerCustomIcon($customIcon);
		}

		if ($customIcon instanceof MarkerCustomIcon) {
			$this->_customIcon = $customIcon;
		}

		return $this;
	}

/**
 * Return the marker custom icon.
 *
 * @return MarkerCustomIcon
 */
	public function getCustomIcon() {
		return $this->_customIcon;
	}

/**
 * Set the marker styles.
 *
 * @param mixed $styles Array or MarkerStyles object.
 * @return MarkerSet
 */
	public function setStyles($styles) {
		if (is_array($styles)) {
			$styles = new MarkerStyles($styles);
		}

		if ($styles instanceof MarkerStyles) {
			$this->_styles = $styles;
		}

		return $this;
	}

/**
 * Return the marker size.
 *
 * @return MarkerStyles
 */
	public function getStyles() {
		return $this->_styles;
	}

/**
 * Set a marker location.
 *
 * @param mixed $location Array or Location object.
 * @return MarkerSet
 */
	public function setLocation($location) {
		if (is_array($location)) {
			$location = new Location($location);
		}

		if ($location instanceof Location) {
			$this->_locations[] = $location;
		}

		return $this;
	}

/**
 * Set the marker locations.
 *
 * @param array $locations
 * @return MarkerSet
 */
	public function setLocations($locations) {
		if (is_array($locations)) {
			foreach ($locations as $v) {
				$this->setLocation($v);
			}
		}

		return $this;
	}

/**
 * Return the marker locations.
 *
 * @return array Array of Location objects.
 */
	public function getLocations() {
		return $this->_locations;
	}

/**
 * Build marker icon.
 *
 * Custom icon is preferred instead of Google marker icons.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildIcon() {
		$customIcon = $this->buildCustomIcon();
		if (!empty($customIcon)) {
			return $customIcon;
		}

		$styles = $this->buildStyles();
		if (!empty($styles)) {
			return $styles;
		}
	}

/**
 * Build marker custom icon.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildCustomIcon() {
		$CustomIcon = $this->getCustomIcon();

		if (empty($CustomIcon)) {
			return;
		}

		return (string)$CustomIcon;
	}

/**
 * Build marker styles.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildStyles() {
		$Styles = $this->getStyles();

		if (empty($Styles)) {
			return;
		}

		return (string)$Styles;
	}

/**
 * Build marker locations.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildLocations() {
		$locations = $this->getLocations();

		if (empty($locations)) {
			return;
		}

		array_walk($locations, function (&$Location) {
			$Location = (string)$Location;
		});

		return implode(self::SEPARATOR, $locations);
	}

/**
 * Return the marker set url string.
 *
 * Note: the string is not url encoded.
 *
 * @return string
 * @link https://developers.google.com/maps/documentation/staticmaps/#Markers
 */
	public function build() {
		$locations = $this->buildLocations();
		if (empty($locations)) {
			return '';
		}

		$icon = $this->buildIcon();

		$markerSet = array_filter(array($icon, $locations), 'trim');
		if (empty($markerSet)) {
			return '';
		}

		return implode(self::SEPARATOR, $markerSet);
	}
}
