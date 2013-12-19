<?php
namespace Google\StaticMaps;

/**
 * Google Static Map Location.
 *
 * @author Ber Clausen <ber.clausen [at] gmail.com>
 * @link https://developers.google.com/maps/documentation/staticmaps/#MarkerLocations
 */
class Location {

/**
 * Address.
 *
 * @var string
 */
	protected $_address = null;

/**
 * Latitude.
 *
 * @var float
 */
	protected $_latitude = null;

/**
 * Longitude.
 *
 * @var float
 */
	protected $_longitude = null;

/**
 *
 */
	public function __construct($params = array()) {
		if (isset($params['address'])) {
			$this->setAddress($params['address']);
		}

		if (isset($params['latitude'])) {
			$this->setLatitude($params['latitude']);
		}

		if (isset($params['longitude'])) {
			$this->setLongitude($params['longitude']);
		}
	}

/**
 * Return the marker location url string.
 *
 * @return string
 */
	public function __toString() {
		return $this->build();
	}

/**
 * Set the marker location address.
 *
 * @param float $longitude
 * @return Location
 */
	public function setAddress($address) {
		$this->_address = $address;

		return $this;
	}

/**
 * Return the marker location address.
 *
 * @return string
 */
	public function getAddress() {
		return $this->_address;
	}

/**
 * Set the marker location latitude.
 *
 * @param float $latitude
 * @return Location
 */
	public function setLatitude($latitude) {
		$this->_latitude = (float)$latitude;

		return $this;
	}

/**
 * Return the marker location latitude.
 *
 * @return float
 */
	public function getLatitude() {
		return $this->_latitude;
	}

/**
 * Set the marker location longitude.
 *
 * @param float $longitude
 * @return Location
 */
	public function setLongitude($longitude) {
		$this->_longitude = (float)$longitude;

		return $this;
	}

/**
 * Return the marker location longitude.
 *
 * @return float
 */
	public function getLongitude() {
		return $this->_longitude;
	}

/**
 * Build the marker location point.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildPoint() {
		$latitude = $this->getLatitude();
		$longitude = $this->getLongitude();
		if (!isset($latitude) || !isset($longitude)) {
			return;
		}

		return (string)$latitude . ',' . (string)$longitude;
	}

/**
 * Build the marker address.
 *
 * @return mixed String on success, null on failure.
 */
	public function buildAddress() {
		$address = $this->getAddress();
		if (empty($address)) {
			return;
		}

		return (string)$address;
	}

/**
 * Return the marker location url string.
 *
 * Latitude/longitude is preferred instead of address.
 *
 * Note: the string is not url encoded.
 *
 * @return string
 * @link https://developers.google.com/maps/documentation/staticmaps/#MarkerLocations
 */
	public function build() {
		$point = $this->buildPoint();
		if (!empty($point)) {
			return $point;
		}

		$address = $this->buildAddress();
		if (!empty($address)) {
			return $address;
		}

		return '';
	}
}
