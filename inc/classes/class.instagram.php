<?php

require("class.log.php");
require("class.local-cache.php");
require("class.exceptions.php");

define("SKELETON_WP_CACHE_FILE_NAME", $_SERVER["DOCUMENT_ROOT"] . "/insta_cache.json");

/**
 * Class Instagram
 * Retrieves data via the Instagram API
 * @author Dennis Thompson
 * @license MIT
 * @version 1.0
 * @copyright AtomicPages LLC 2014
 */
class InstagramGallery {

	private $count, $accessToken, $id, $log, $cache, $expire;
	public function __construct($id, $token, $count = 10) {
		$this->accessToken = $token;
		$this->id          = $id;
		$this->count       = $count;
		$this->cache       = new Skeleton_WP_LocalCache(SKELETON_WP_CACHE_FILE_NAME, time() + 60 * 60 * 2);
		$this->log         = new Skeleton_WP_Log("instagram-error.log");
		$this->expire      = $this->expireTime();
	}

	/**
	 * Sets the number of items to get from an array
	 * @param int $count
	 */
	public function count($count) {
		$this->count = $count;
	}

	/**
	 * Returns the number if items to display
	 * @return int
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * Gets the images either from the local cache file or from the request
	 * be it cURL or file_get_contents
	 * @return array|null
	 * @access public
	 */
	public function getImages() {
		$result = NULL;

		if($this->expire != 0 && $this->expire < time()) { // cache is invalidated
			$result = $this->curl("https://api.instagram.com/v1/users/" . $this->id . "/media/recent/?access_token=" . $this->accessToken);
			$result = json_decode($result);
			$this->filter($result);
			$this->cache->write($result); // update cache
		} else {
			if(!($result = $this->readCache())) {
				$this->getImages(); // try again
				return $result;
			}
			unset($this->cache, $this->log); // free memory
			$result = json_decode($result);
		}

		return $result;
	}

	/**
	 * Sets the access token
	 * @param string $token
	 * @access protected
	 */
	protected function accessToken($token) {
		$this->accessToken = $token;
	}

	/**
	 * Returns the access token
	 * @return string
	 * @access protected
	 */
	protected function getAccessToken() {
		return $this->accessToken;
	}

	/**
	 * Sets the Instagram ID
	 * @param $id
	 * @access protected
	 */
	protected function id($id) {
		$this->id = $id;
	}

	/**
	 * Returns the Instagram ID
	 * @return string
	 * @access protected
	 */
	protected function getID() {
		return $this->id;
	}

	/**
	 * Returns the expireTime as found in the local cache file
	 * @return int
	 */
	private function expireTime() {
		if(file_exists(SKELETON_WP_CACHE_FILE_NAME)) {
			$json = file_get_contents(SKELETON_WP_CACHE_FILE_NAME, false, null, -1, 20);
			$json .= "}";
			$array = json_decode($json);
			return $array->expire;
		}

		return 0;
	}

	/**
	 * A method that returns the string stored in the cache file. Returns false on failure
	 * and resets Instagram::expire to 0
	 * @return bool|string
	 */
	private function readCache() {
		try {
			if(!file_exists(SKELETON_WP_CACHE_FILE_NAME)) {
				throw new ErrorOpeningFileException(SKELETON_WP_CACHE_FILE_NAME . " not found!");
			} else {
				return file_get_contents(SKELETON_WP_CACHE_FILE_NAME);
			}
		} catch(ErrorOpeningFileException $e) {
			$this->log->log($e->getMessage());
			$this->expire = 0;
		}

		return false;
	}

	/**
	 * A function that returns the result of a cURL request
	 * @param string $url
	 * @param array  $options
	 * @return mixed
	 * @access private
	 */
	private function curl($url, $options = array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_TIMEOUT => 20)) {
		$result = NULL;
		try {
			if(!function_exists("curl_init")) {
				throw new BadFunctionCallException("cURL is not enabled on this host! It must be enabled for this
				script to work!", 1);
			} else {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt_array($ch, $options);
				$result = curl_exec($ch);
				curl_close($ch);
			}
		} catch(BadFunctionCallException $e) {
			$this->log->log(array($e->getMessage(), "Trying to fetch output with file_get_contents"));
			$result = $this->getRemoteFile($url);
			if(!$result) {
				return null;
			}
		}

		return $result;
	}

	/**
	 * Gets remote file using fopen
	 * @param $url
	 * @return string
	 */
	private function getRemoteFile($url) {
		try {
			if(!ini_get("allow_url_fopen")) {
				$this->log->log("Neither cURL or allow_url_fopen are enabled on this host! Attempting to enable
				allow_url_fopen");
				if(!ini_set("allow_url_fopen", "1")) { // attempt to override ini settings
					throw new IniConfigurationException("Unable to enable allow_url_fopen", 1);
				}
			}
		} catch(IniConfigurationException $e) {
			$this->log->log($e->getMessage());
			return null;
		}

		$opts = array(
			"http" => array(
				"method" => "GET",
				// http://stackoverflow.com/questions/477816/what-is-the-correct-json-content-type
				"header" => "Content-type: application/json\r\n"
			)
		);
		$context = stream_context_create($opts);

		return file_get_contents($url, false, $context);
	}

	/**
	 * Filter specific information from parameter
	 * @param object &$object
	 * @access protected
	 */
	protected function filter(&$object) {
		$object = $object->data;
	}

}