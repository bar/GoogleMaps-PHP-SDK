<?php
namespace GoogleStaticMaps;

/**
 * Google Static Map Marker Custom Icon.
 *
 * @author Ber Clausen <ber.clausen [at] gmail.com>
 * @link https://developers.google.com/maps/documentation/staticmaps/#CustomIcons
 */
class MarkerCustomIcon {

/**
 * Marker separator.
 */
	const SEPARATOR = '|';

/**
 * Custom icon URL.
 *
 * @var string
 */
	protected $_icon = null;

/**
 * Custom icon shadow.
 *
 * @var boolean
 */
	protected $_shadow = null;

/**
 *
 */
	public function __construct($params = array()) {
		if (isset($params['icon'])) {
			$this->setIcon($params['icon']);
		}

		if (isset($params['shadow'])) {
			$this->setShadow($params['shadow']);
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
 * Set the marker custom icon URL.
 *
 * @param string $icon
 * @return MarkerCustomIcon
 */
	public function setIcon($icon) {
		$this->_icon = $icon;

		return $this;
	}

/**
 * Return the marker custom icon URL.
 *
 * @return string
 */
	public function getIcon() {
		return $this->_icon;
	}

/**
 * Set the marker custom icon shadow.
 *
 * @param boolean $shadow
 * @return MarkerCustomIcon
 */
	public function setShadow($shadow) {
		$this->_shadow = (bool)$shadow;

		return $this;
	}

/**
 * Return the marker custom icon shadow.
 *
 * @return boolean
 */
	public function getShadow() {
		return $this->_shadow;
	}

/**
 * Build the marker custom icon.
 *
 * @return mixed String on success, null on failure.
 * @TODO Test for a valid URL.
 */
	public function buildIcon() {
		$icon = $this->getIcon();
		if (empty($icon)) {
			return;
		}

		return $icon;
	}

/**
 * Build the marker custom icon shadow.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildShadow() {
		$shadow = $this->getShadow();
		if ($shadow === null) {
			return;
		}

		return $shadow ? 'true' : 'false';
	}

/**
 * Return the marker custom icon url string.
 *
 * Note: the string is not url encoded.
 *
 * @return string
 * @link https://developers.google.com/maps/documentation/staticmaps/#CustomIcons
 */
	public function build() {
		$customIcon = array();

		$icon = $this->buildIcon();
		if (!empty($icon)) {
			$customIcon[] = "icon:{$icon}";
		}

		$shadow = $this->buildShadow();
		if (isset($shadow)) {
			$customIcon[] = "shadow:{$shadow}";
		}

		if (empty($customIcon)) {
			return '';
		}

		return implode(self::SEPARATOR, $customIcon);
	}
}
