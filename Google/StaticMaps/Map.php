<?php
namespace Google\StaticMaps;

/**
 * Google Static Map.
 *
 * Only the 'free' version is implemented.
 *
 * Parameters:
 * - location
 * - map
 * - feature
 * - reporting
 *
 * @author Ber Clausen <ber.clausen [at] gmail.com>
 * @link https://developers.google.com/maps/documentation/staticmaps/
 * @TODO API key
 * @TODO Static Map Paths.
 * @TODO Viewports.
 * @TODO Implicit Positioning.
 */
class Map {

/**
 * Max URL character length.
 *
 * @see RFC 2616.
 * @link http://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers
 */
	const MAX_URL_LENGTH = 2048;

/**
 * Marker separator.
 */
	const MARKER_SEPARATOR = '&';

/**
 * Parameter separator.
 */
	const PARAMETER_SEPARATOR = '&';

/**
 * Zoom levels.
 *
 * 0: world
 * 21+: individual buildings (roadmap map type)
 *
 * @link https://developers.google.com/maps/documentation/staticmaps/#Zoomlevels
 */
	const ZOOM_LEVEL_0 = 0;
	const ZOOM_LEVEL_1 = 1;
	const ZOOM_LEVEL_2 = 2;
	const ZOOM_LEVEL_3 = 3;
	const ZOOM_LEVEL_4 = 4;
	const ZOOM_LEVEL_5 = 5;
	const ZOOM_LEVEL_6 = 6;
	const ZOOM_LEVEL_7 = 7;
	const ZOOM_LEVEL_8 = 8;
	const ZOOM_LEVEL_9 = 9;
	const ZOOM_LEVEL_10 = 10;
	const ZOOM_LEVEL_11 = 11;
	const ZOOM_LEVEL_12 = 12;
	const ZOOM_LEVEL_13 = 13;
	const ZOOM_LEVEL_14 = 14;
	const ZOOM_LEVEL_15 = 15;
	const ZOOM_LEVEL_16 = 16;
	const ZOOM_LEVEL_17 = 17;
	const ZOOM_LEVEL_18 = 18;
	const ZOOM_LEVEL_19 = 19;
	const ZOOM_LEVEL_20 = 20;
	const ZOOM_LEVEL_21 = 21;

/**
 * Maximum image sizes.
 *
 * @link https://developers.google.com/maps/documentation/staticmaps/#Imagesizes
 */
	const IMAGE_SCALE_1_MAX_SIZE_HORIZONTAL = 640;
	const IMAGE_SCALE_1_MAX_SIZE_VERTICAL = 640;
	const IMAGE_SCALE_2_MAX_SIZE_HORIZONTAL = 640;
	const IMAGE_SCALE_2_MAX_SIZE_VERTICAL = 640;

/**
 * Scale values.
 *
 * 1: standard resolution (desktop)
 * 2: high resolution (mobile)
 *
 * @link https://developers.google.com/maps/documentation/staticmaps/#scale_values
 */
	const SCALE_1 = 1;
	const SCALE_2 = 2;

/**
 * Image formats.
 *
 * @link https://developers.google.com/maps/documentation/staticmaps/#ImageFormats
 */
	const IMAGE_FORMAT_PNG = 'png';
	const IMAGE_FORMAT_PNG8 = 'png8';
	const IMAGE_FORMAT_PNG32 = 'png32';
	const IMAGE_FORMAT_GIF = 'gif';
	const IMAGE_FORMAT_JPG = 'jpg';
	const IMAGE_FORMAT_JPG_BASELINE = 'jpg-baseline';

/**
 * Map types.
 *
 * @link https://developers.google.com/maps/documentation/staticmaps/#MapTypes
 */
	const MAP_TYPE_ROADMAP = 'roadmap';
	const MAP_TYPE_SATELLITE = 'satellite';
	const MAP_TYPE_HYBRID = 'hybrid';
	const MAP_TYPE_TERRAIN = 'terrain';

/**
 * Map style features.
 *
 * @link https://developers.google.com/maps/documentation/staticmaps/#StyledMaps
 * @link https://developers.google.com/maps/documentation/javascript/reference#MapTypeStyleFeatureType
 * @TODO Feature sub categories.
 */
	const MAP_STYLE_FEATURE_ALL = 'all';
	const MAP_STYLE_FEATURE_ROAD = 'road';
	const MAP_STYLE_FEATURE_LANDSCAPE = 'landscape';

/**
 * Map style feature elements.
 *
 * @link https://developers.google.com/maps/documentation/staticmaps/#StyledMaps
 */
	const MAP_STYLE_ELEMENT_ALL = 'all';
	const MAP_STYLE_ELEMENT_GEOMETRY = 'geometry';
	const MAP_STYLE_ELEMENT_LABELS = 'labels';

/**
 * Template Url.
 *
 * Note: it must not contain the query string separator '?'.
 *
 * @var string
 * @link https://developers.google.com/maps/documentation/staticmaps/#URL_Parameters
 */
	protected $_templateUrl = 'http://maps.googleapis.com/maps/api/staticmap?%s';

/**
 * Center.
 *
 * @var Location
 * @link https://developers.google.com/maps/documentation/staticmaps/#Locations
 */
	protected $_center = null;

/**
 * Zoom.
 *
 * @var int
 * @link https://developers.google.com/maps/documentation/staticmaps/#Zoomlevels
 */
	protected $_zoom = null;

/**
 * Size.
 *
 * @var array
 * @link https://developers.google.com/maps/documentation/staticmaps/#Imagesizes
 */
	protected $_size = array(
		self::IMAGE_SCALE_1_MAX_SIZE_HORIZONTAL,
		self::IMAGE_SCALE_1_MAX_SIZE_VERTICAL
	);

/**
 * Visual refresh (latest Google Maps look).
 *
 * It will change the base map tiles, and markers.
 *
 * @var boolean
 * @link https://developers.google.com/maps/documentation/staticmaps/#VisualRefresh
 */
	protected $_visualRefresh = null;

/**
 * Scale.
 *
 * Affects the number of pixels returned.
 *
 * @var int
 * @link https://developers.google.com/maps/documentation/staticmaps/#scale_values
 */
	protected $_scale = null;

/**
 * Image format.
 *
 * The format of the resulting image.
 *
 * @var string
 * @link https://developers.google.com/maps/documentation/staticmaps/#ImageFormats
 */
	protected $_format = null;

/**
 * Map type.
 *
 * Type of map to construct.
 *
 * @var string
 * @link https://developers.google.com/maps/documentation/staticmaps/#MapTypes
 */
	protected $_mapType = null;

/**
 * Language.
 *
 * Used for display of labels on map tiles.
 *
 * @var string
 */
	protected $_language = null;

/**
 * Region.
 *
 * Appropriate borders to display, based on geo-political sensitivities.
 *
 * @var string Two-character ccTLD ('top-level domain') value.
 */
	protected $_region = null;

/**
 * Markers.
 *
 * @var array Array of MarkerSet objects.
 * @link https://developers.google.com/maps/documentation/staticmaps/#Markers
 * @link https://developers.google.com/maps/documentation/staticmaps/#Locations
 */
	protected $_markers = array();

/**
 * Sensor.
 *
 * @var boolean
 * @link https://developers.google.com/maps/documentation/staticmaps/#Sensor
 */
	protected $_sensor = false;

/**
 * Latest built params.
 *
 * Note: used for debugging.
 *
 * @var array
 */
	public static $builtParams = array();

/**
 *
 */
	public function __construct($params = array()) {
		// Location
		if (isset($params['center'])) {
			$this->setCenter($params['center']);
		}
		if (isset($params['zoom'])) {
			$this->setZoom($params['zoom']);
		}

		// Map
		if (isset($params['size'])) {
			$this->setSize($params['size']);
		}
		if (isset($params['visualRefresh'])) {
			$this->setVisualRefresh($params['visualRefresh']);
		}
		if (isset($params['scale'])) {
			$this->setScale($params['scale']);
		}
		if (isset($params['format'])) {
			$this->setFormat($params['format']);
		}
		if (isset($params['mapType'])) {
			$this->setMapType($params['mapType']);
		}
		if (isset($params['language'])) {
			$this->setLanguage($params['language']);
		}
		if (isset($params['region'])) {
			$this->setRegion($params['region']);
		}

		// Feature
		if (isset($params['markers'])) {
			$this->setMarker($params['markers']);
		}
		/*if (isset($params['path'])) {
			$this->setPath($params['path']);
		}
		if (isset($params['visible'])) {
			$this->setVisible($params['visible']);
		}
		if (isset($params['style'])) {
			$this->setStyle($params['style']);
		}*/

		// Reporting
		if (isset($params['sensor'])) {
			$this->setSensor($params['sensor']);
		}
	}

/**
 * Output the map url string.
 *
 * @return string
 */
	public function __toString() {
		return $this->build();
	}

/**
 * Set the map center.
 *
 * @param mixed $location Array or Location object.
 * @return Map
 */
	public function setCenter($location) {
		if (is_array($location)) {
			$location = new Location($location);
		}

		if ($location instanceof Location) {
			$this->_center = $location;
		}

		return $this;
	}

/**
 * Return the map center.
 *
 * @return Location
 */
	public function getCenter() {
		return $this->_center;
	}

/**
 * Set the map zoom level.
 *
 * @param int $zoomLevel
 * @return Map
 */
	public function setZoom($zoomLevel) {
		$validZoomLevels = array(
			self::ZOOM_LEVEL_0,
			self::ZOOM_LEVEL_1,
			self::ZOOM_LEVEL_2,
			self::ZOOM_LEVEL_3,
			self::ZOOM_LEVEL_4,
			self::ZOOM_LEVEL_5,
			self::ZOOM_LEVEL_6,
			self::ZOOM_LEVEL_7,
			self::ZOOM_LEVEL_8,
			self::ZOOM_LEVEL_9,
			self::ZOOM_LEVEL_10,
			self::ZOOM_LEVEL_11,
			self::ZOOM_LEVEL_12,
			self::ZOOM_LEVEL_13,
			self::ZOOM_LEVEL_14,
			self::ZOOM_LEVEL_15,
			self::ZOOM_LEVEL_16,
			self::ZOOM_LEVEL_17,
			self::ZOOM_LEVEL_18,
			self::ZOOM_LEVEL_19,
			self::ZOOM_LEVEL_20,
			self::ZOOM_LEVEL_21,
		);

		if ((in_array($zoomLevel, $validZoomLevels))) {
			$this->_zoom = $zoomLevel;
		}

		return $this;
	}

/**
 * Return the map zoom level.
 *
 * @return int
 */
	public function getZoom() {
		return $this->_zoom;
	}

/**
 * Set the map size.
 *
 * @param array $size
 * @return Map
 * @TODO Validate size (depending on scale value)?
 */
	public function setSize($size) {
		if (is_array($size) && count($size) === 2) {
			$this->_size = array_values($size);
		}

		return $this;
	}

/**
 * Return the map size.
 *
 * @return array
 */
	public function getSize() {
		return $this->_size;
	}

/**
 * Set the map visual refresh.
 *
 * @param boolean $visualRefresh
 * @return Map
 */
	public function setVisualRefresh($visualRefresh) {
		$this->_visualRefresh = (bool)$visualRefresh;

		return $this;
	}

/**
 * Return the map visual refresh.
 *
 * @return boolean
 */
	public function getVisualRefresh() {
		return $this->_visualRefresh;
	}

/**
 * Set the map scale.
 *
 * @param int $scale
 * @return Map
 */
	public function setScale($scale) {
		$validScales = array(
			self::SCALE_1,
			self::SCALE_2
		);

		if ((in_array($scale, $validScales))) {
			$this->_scale = $scale;
		}

		return $this;
	}

/**
 * Return the map scale.
 *
 * @return int
 */
	public function getScale() {
		return $this->_scale;
	}

/**
 * Set the map image format.
 *
 * @param string $format
 * @return Map
 */
	public function setFormat($format) {
		$validFormats = array(
			self::IMAGE_FORMAT_PNG,
			self::IMAGE_FORMAT_PNG8,
			self::IMAGE_FORMAT_PNG32,
			self::IMAGE_FORMAT_GIF,
			self::IMAGE_FORMAT_JPG,
			self::IMAGE_FORMAT_JPG_BASELINE,
		);

		if ((in_array($format, $validFormats))) {
			$this->_format = $format;
		}

		return $this;
	}

/**
 * Return the map image format.
 *
 * @return string
 */
	public function getFormat() {
		return $this->_format;
	}

/**
 * Set the map type.
 *
 * @param string $type
 * @return Map
 */
	public function setMapType($type) {
		$validMapTypes = array(
			self::MAP_TYPE_ROADMAP,
			self::MAP_TYPE_SATELLITE,
			self::MAP_TYPE_HYBRID,
			self::MAP_TYPE_TERRAIN,
		);

		if ((in_array($type, $validMapTypes))) {
			$this->_mapType = $type;
		}

		return $this;
	}

/**
 * Return the map type.
 *
 * @return string
 */
	public function getMapType() {
		return $this->_mapType;
	}

/**
 * Set the map language.
 *
 * @param string $language
 * @return Map
 * @TODO Validate
 */
	public function setLanguage($language) {
		$validLanguages = array(
			'eu', 'bg', 'bn', 'ca', 'cs', 'da', 'de', 'el', 'en', 'en-AU', 'en-GB',
			'es', 'eu', 'fa', 'fi', 'fil', 'fr', 'gl', 'gu', 'hi', 'hr', 'hu', 'id',
			'it', 'iw', 'ja', 'kn', 'ko', 'lt', 'lv', 'ml', 'mr', 'nl', 'nn', 'no',
			'or', 'pl', 'pt', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'sr',
			'sv', 'tl', 'ta', 'te', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-TW'
		);

		if ((in_array($language, $validLanguages))) {
			$this->_language = $language;
		}

		return $this;
	}

/**
 * Return the map language.
 *
 * @return string
 */
	public function getLanguage() {
		return $this->_language;
	}

/**
 * Set the map region.
 *
 * @param string $region
 * @return Map
 * @TODO Validate
 */
	public function setRegion($region) {
		$this->_region = $region;

		return $this;
	}

/**
 * Return the map region.
 *
 * @return string
 */
	public function getRegion() {
		return $this->_region;
	}

/**
 * Set the map marker set.
 *
 * @param mixed $marker MarkerSet or array representing a marker
 * @return Map
 */
	public function setMarker($marker) {
		if (is_array($marker)) {
			$marker = new MarkerSet($marker);
		}

		if ($marker instanceof MarkerSet) {
			$this->_markers[] = $marker;
		}

		return $this;
	}

/**
 * Set the map marker sets.
 *
 * @param array $locations
 * @return Map
 */
	public function setMarkers($markers) {
		if (is_array($markers)) {
			foreach ($markers as $v) {
				$this->setMarker($v);
			}
		}

		return $this;
	}

/**
 * Return the marker sets.
 *
 * @return array Array of MarkerSet objects
 */
	public function getMarkers() {
		return $this->_markers;
	}

/**
 * Set the map sensor value.
 *
 * @param boolean $sensor
 * @return Map
 */
	public function setSensor($sensor) {
		$this->_sensor = (bool)$sensor;

		return $this;
	}

/**
 * Return the map sensor value.
 *
 * @return boolean
 */
	public function getSensor() {
		return $this->_sensor;
	}

/**
 * Build the map center.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildCenter() {
		$Location = $this->getCenter();
		if (empty($Location)) {
			return;
		}

		return 'center=' . urlencode((string)$Location);
	}

/**
 * Build the map zoom level.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildZoom() {
		$zoom = $this->getZoom();
		if ($zoom === null) {
			return;
		}

		return 'zoom=' . (string)$zoom;
	}

/**
 * Build the map size.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildSize() {
		$size = $this->getSize();
		if (empty($size)) {
			return;
		}

		return 'size=' . implode('x', $size);
	}

/**
 * Build the map visual refresh.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildVisualRefresh() {
		$visualRefresh = $this->getVisualRefresh();
		if ($visualRefresh === null) {
			return;
		}

		return 'visual_refresh=' . ($visualRefresh ? 'true' : 'false');
	}

/**
 * Build the map scale.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildScale() {
		$scale = $this->getScale();

		return 'scale=' . (string)$scale;
	}

/**
 * Build the map image format.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildFormat() {
		$format = $this->getFormat();

		return 'format=' . (string)$format;
	}

/**
 * Build the map type.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildMapType() {
		$mapType = $this->getMapType();

		return 'mapType=' . (string)$mapType;
	}

/**
 * Build the map language.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildLanguage() {
		$language = $this->getLanguage();

		return 'language=' . (string)$language;
	}

/**
 * Build the map region.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildRegion() {
		$region = $this->getRegion();

		return 'region=' . (string)$region;
	}

/**
 * Build the map marker sets.
 *
 * Because each MarkerSet needs a 'markers=' prefix when built, conversion must be done here.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildMarkers() {
		$markers = $this->getMarkers();
		if (empty($markers)) {
			return;
		}

		array_walk($markers, function (&$Marker) {
			$Marker = 'markers=' . urlencode((string)$Marker);
		});

		return implode(self::MARKER_SEPARATOR, $markers);
	}

/**
 * Build the map sensor value.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildSensor() {
		$sensor = $this->getSensor();
		if ($sensor === null) {
			return;
		}

		return 'sensor=' . ($sensor ? 'true' : 'false');
	}

/**
 * Return the map url string.
 *
 * @return string
 * @link https://developers.google.com/maps/documentation/staticmaps/#URL_Parameters
 * @TODO http/https
 */
	public function build() {
		$markers = $this->buildMarkers();
		$center = $this->buildCenter();
		$zoom = $this->buildZoom();

		// Center and zoom are required if markers are not present.
		if ($markers === null && ($center === null || $zoom === null)) {
			return '';
		}

		// Size is required
		$size = $this->buildSize();
		if ($size === null) {
			return '';
		}

		// Sensor is required
		$sensor = $this->buildSensor();
		if ($sensor === null) {
			return '';
		}

		$locationParams = array(
			'center' => $center,
			'zoom' => $zoom,
		);

		$mapParams = array(
			'size' => $size,
			'visual_refresh' => $this->buildVisualRefresh(),
			'scale' => $this->buildScale(),
			'format' => $this->buildFormat(),
			'mapType' => $this->buildMapType(),
			'language' => $this->buildLanguage(),
			'region' => $this->buildRegion(),
		);

		$featureParams = array(
			'markers' => $markers,
			//'path',
			//'visible',
			//'style',
		);

		$reportingParams = array(
			'sensor' => $sensor
		);

		$params = array_filter($locationParams + $mapParams + $featureParams + $reportingParams, 'trim');

		self::$builtParams = $params;

		return sprintf($this->_templateUrl, implode(self::PARAMETER_SEPARATOR, $params));
	}
}
