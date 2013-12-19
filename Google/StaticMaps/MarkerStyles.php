<?php
namespace Google\StaticMaps;

/**
 * Google Static Map Marker Styles.
 *
 * @author Ber Clausen <ber.clausen [at] gmail.com>
 * @link https://developers.google.com/maps/documentation/staticmaps/#MarkerStyles
 */
class MarkerStyles {

/**
 * Marker separator.
 */
	const SEPARATOR = '|';

/**
 * Sizes.
 */
	const SIZE_TINY = 'tiny';
	const SIZE_SMALL = 'small';
	const SIZE_MID = 'mid';
	const SIZE_NORMAL = 'normal';

/**
 * Colors.
 */
	const COLOR_BLACK = 'black';
	const COLOR_BROWN = 'brown';
	const COLOR_GREEN = 'green';
	const COLOR_PURPLE = 'purple';
	const COLOR_YELLOW = 'yellow';
	const COLOR_BLUE = 'blue';
	const COLOR_GRAY = 'gray';
	const COLOR_ORANGE = 'orange';
	const COLOR_RED = 'red';
	const COLOR_WHITE = 'white';

/**
 * Default size.
 *
 * @var string
 */
	//protected $_defaultSize = self::SIZE_NORMAL;

/**
 * Default color.
 *
 * @var string
 */
	//protected $_defaultColor = self::COLOR_RED;

/**
 * Size.
 *
 * @var string
 */
	protected $_size = null;

/**
 * Color.
 *
 * @var string
 */
	protected $_color = null;

/**
 * Label.
 *
 * Note: default and mid sized markers are the only markers capable of displaying an alphanumeric-character parameter.
 *
 * @var string
 */
	protected $_label = null;

/**
 *
 */
	public function __construct($params = array()) {
		if (isset($params['size'])) {
			$this->setSize($params['size']);
		}

		if (isset($params['color'])) {
			$this->setColor($params['color']);
		}

		if (isset($params['label'])) {
			$this->setLabel($params['label']);
		}
	}

/**
 * Return the marker styles url string.
 *
 * @return string
 */
	public function __toString() {
		return $this->build();
	}

/**
 * Set the marker size.
 *
 * @param string $size
 * @return MarkerStyles
 */
	public function setSize($size) {
		$validSizes = array(
			self::SIZE_TINY,
			self::SIZE_SMALL,
			self::SIZE_MID,
			self::SIZE_NORMAL
		);

		if ((in_array($size, $validSizes))) {
			$this->_size = $size;
		}

		return $this;
	}

/**
 * Return the marker size.
 *
 * @return string
 */
	public function getSize() {
		return $this->_size;
	}

/**
 * Set the marker color.
 *
 * @param string $color
 * @return MarkerStyles
 * @TODO 0xFFFFCC, etc
 */
	public function setColor($color) {
		$validColors = array(
			self::COLOR_BLACK,
			self::COLOR_BROWN,
			self::COLOR_GREEN,
			self::COLOR_PURPLE,
			self::COLOR_YELLOW,
			self::COLOR_BLUE,
			self::COLOR_GRAY,
			self::COLOR_ORANGE,
			self::COLOR_RED,
			self::COLOR_WHITE
		);

		if ((in_array($color, $validColors))) {
			$this->_color = $color;
		}

		return $this;
	}

/**
 * Return the marker color.
 *
 * @return string
 */
	public function getColor() {
		return $this->_color;
	}

/**
 * Set the marker label.
 *
 * @param string $label
 * @return MarkerStyles
 */
	public function setLabel($label) {
		if (preg_match('/[A-Za-z0-9]/', $label, $match)) {
			$this->_label = mb_strtoupper($label);
		}

		return $this;
	}

/**
 * Return the marker label.
 *
 * @return string
 */
	public function getLabel() {
		return $this->_label;
	}

/**
 * Return the marker styles url string.
 *
 * Note: the string is not url encoded.
 *
 * @return string
 * @link https://developers.google.com/maps/documentation/staticmaps/#MarkerStyles
 */
	public function build() {
		$styles = array();

		$size = $this->getSize();
		if (!empty($size)) {
			$styles[] = "size:{$size}";
		}

		$color = $this->getColor();
		if (!empty($color)) {
			$styles[] = "color:{$color}";
		}

		$label = $this->getLabel();
		if (!empty($label)) {
			$styles[] = "label:{$label}";
		}

		if (empty($styles)) {
			return '';
		}

		return implode(self::SEPARATOR, $styles);
	}
}
