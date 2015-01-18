<?php
/**
 * Class LocalCache
 * Creates and writes local cache to a JSON file. Can be extended
 * to incorporate other flat file types such as XML, text, or even
 * a database such as MySQL or PostgresQL.
 * @author Dennis Thompson
 * @license MIT
 * @version 1.0
 * @copyright AtomicPages LLC 2014
 */

if(!class_exists("Skeleton_WP_LocalCache")) {

	class Skeleton_WP_LocalCache {

		private $filename, $expire, $isCached, $log;

		public function __construct( $filename, $expire ) {
			$this->log = new Log( "local-cache-error.log" );
			try {
				if ( ! is_string( $filename ) ) {
					throw new InvalidArgumentException( "First parameter expects to be a string", 1 );
				}
			} catch( InvalidArgumentException $e ) {
				$this->log->log( array( $e->getMessage(), "Attempting to recover filename..." ) );
				$filename = strval( $filename );
			}

			try {
				if ( ! is_numeric( $expire ) ) {
					throw new InvalidArgumentException( "Second parameter expects to be a valid unix timestamp", 1 );
				}
			} catch( InvalidArgumentException $e ) {
				$this->log->log( array( $e->getMessage(), "Attempting to recover expire..." ) );
				$expire = intval( $expire );
				if ( $expire < 0 ) {
					$expire = abs( $expire ); // make it positive
				}
			}

			$this->filename = $filename;
			$this->expire   = $expire;
			$this->isCached = false;
		}

		/**
		 * Returns true if information has been cached
		 * @return bool
		 */
		public function isCached() {
			return $this->isCached;
		}

		/**
		 * Returns the unix timestamp of when the cache will expire
		 * @return int
		 */
		public function getExpireTime() {
			return $this->expire;
		}

		/**
		 * Sets the expiration time
		 *
		 * @param int
		 */
		public function expire( $timestamp ) {
			$this->expire = $timestamp;
		}

		public function getExtension() {
			if ( isset( $this->filename ) ) {
				$tmp = explode( ".", $this->filename );

				return $tmp[ count( $tmp ) - 1 ];
			}

			return "";
		}

		/**
		 * Writes data to file. Returns false on failure.
		 *
		 * @param $data
		 *
		 * @return bool
		 * @see self::FILE_EXT
		 */
		public function write( $data ) {
			if ( $this->getExtension() == "json" ) {
				if ( ! is_array( $data ) && ! $this->array_is_associative( $data ) ) {
					throw new InvalidArgumentException( "First parameter expects to be an associative array", 1 );
				}

				try {
					if ( ! file_exists( $this->filename ) || filemtime( $this->filename ) > $this->expire ) {
						$fp = fopen( $this->filename, "w" );
						if ( ! is_null( $fp ) ) {
							$json = $this->buildJsonString( $data );
							if ( flock( $fp, LOCK_EX ) ) { // acquire exclusive lock
								if ( ! ftruncate( $fp, 0 ) ) { // truncate the file
									rewind( $fp ); // rewind the stream just in case...
								}
								fwrite( $fp, $json );
								flock( $fp, LOCK_UN ); // release the lock
							}
							fclose( $fp );
							$this->isCached = true;
						} else {
							throw new ErrorOpeningFileException( "Error opening $this->filename for writing. Aborting..." );
						}
					}
				} catch( ErrorOpeningFileException $e ) {
					$this->log->log( array(
						$e->getMessage(),
						"Program exited with status of " . $e->getCode(),
						$e->getTraceAsString()
					) );

					return false;
				}

				return true;
			}

			return false;
		}

		/**
		 * Builds a JSON string based on a hash table (associative array) input
		 *
		 * @param $hash
		 *
		 * @return string
		 */
		private function buildJsonString( $hash ) {
			try {
				if ( ! is_array( $hash ) && ! $this->array_is_associative( $hash ) ) {
					throw new InvalidArgumentException( "First parameter expects to be an associative array", 1 );
				}
			} catch( InvalidArgumentException $e ) {
				$this->log->log( array(
					$e->getMessage(),
					"Program exited with status of " . $e->getCode(),
					$e->getTraceAsString()
				) );
			}

			$json = "{\"expire\":" . $this->expire . ",";
			$json .= "\"images\":[";
			$separator = ",";
			$count     = count( $hash );
			for ( $i = 0; $i < $count; $i ++ ) {
				if ( $i == $count - 1 ) {
					$separator = "";
				}
				$json .= json_encode( $hash[ $i ]->images ) . $separator;
			}
			$json .= "]}";
			unset( $separator ); // deallocate memory for $separator

			return $json;
		}

		/**
		 * Tests if an array is associative or not. Returns true if it is.
		 * Note: There are known issues with this code! unlink($array[0])
		 * will return a false positive.
		 *
		 * @param $array
		 *
		 * @return bool
		 * @see http://stackoverflow.com/a/173479/1545556 - known issues
		 */
		private function array_is_associative( $array ) {
			return array_keys( $array ) !== range( 0, count( $array ) - 1 );
		}

	}

}