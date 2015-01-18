<?php

/**
* Class ErrorOpeningFileException
* An exception class that gives a little more detail regarding the nature of the exception without need for
* excessive explanation.
* @author Dennis Thompson
* @license MIT
*/

if(!class_exists("ErrorOpeningFileException")) {

	class ErrorOpeningFileException extends Exception {

		public function __construct( $message, $code = 2, Exception $previous = null ) {
			parent::__construct( $message, $code, $previous );
		}

	}

}

/**
* Class IniConfigurationException
* An exception class that throws an error when there are unmet dependencies in the ini configuration
* and PHP is unable to change the value during runtime
* @author Dennis Thompson
* @license MIT
*/
if(!class_exists("IniConfigurationException")) {

	class IniConfigurationException extends Exception {

		public function __construct( $message, $code = 3, Exception $previous = null ) {
			parent::__construct( $message, $code, $previous );
		}

	}

}