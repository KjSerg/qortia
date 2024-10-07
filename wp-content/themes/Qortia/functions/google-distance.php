<?php

function getDistance( $addressFrom, $addressTo, $unit = '' ) {
	// Google API key
	$apiKey = 'AIzaSyCbQNyo-qkvvV4xuto_LZDehgUnqCJtuHs';
	if ( $google_map_api_key = carbon_get_theme_option( 'google_map_api_key' ) ) {
		$apiKey = $google_map_api_key;
	}

	// Change address format
	$formattedAddrFrom = str_replace( ' ', '+', $addressFrom );
	$formattedAddrTo   = str_replace( ' ', '+', $addressTo );

	// Geocoding API request with start address
	$geocodeFrom = file_get_contents( 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrFrom . '&sensor=false&key=' . $apiKey );
	$outputFrom  = json_decode( $geocodeFrom );
	if ( ! empty( $outputFrom->error_message ) ) {
		return $outputFrom->error_message;
	}

	// Geocoding API request with end address
	$geocodeTo = file_get_contents( 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddrTo . '&sensor=false&key=' . $apiKey );
	$outputTo  = json_decode( $geocodeTo );
	if ( ! empty( $outputTo->error_message ) ) {
		return $outputTo->error_message;
	}

	// Get latitude and longitude from the geodata
	$latitudeFrom  = $outputFrom->results[0]->geometry->location->lat;
	$longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
	$latitudeTo    = $outputTo->results[0]->geometry->location->lat;
	$longitudeTo   = $outputTo->results[0]->geometry->location->lng;

	// Calculate distance between latitude and longitude
	$theta = $longitudeFrom - $longitudeTo;
	$dist  = sin( deg2rad( $latitudeFrom ) ) * sin( deg2rad( $latitudeTo ) ) + cos( deg2rad( $latitudeFrom ) ) * cos( deg2rad( $latitudeTo ) ) * cos( deg2rad( $theta ) );
	$dist  = acos( $dist );
	$dist  = rad2deg( $dist );
	$miles = $dist * 60 * 1.1515;

	// Convert unit and return distance
	$unit = strtoupper( $unit );
	if ( $unit == "K" ) {
		return round( $miles * 1.609344, 0 ) . ' км';
	} elseif ( $unit == "M" ) {
		return round( $miles * 1609.344, 0 ) . ' метрів';
	} else {
		return round( $miles, 0 ) . ' миль';
	}
}

function getLocaleCity( $address, $language = 'uk' ) {
	$_string = 'city_google_' . str_replace( ' ', '_', $address );
	if ( false !== ( $res = get_transient( $_string ) ) ) {
		return $res;
	}
	$apiKey = 'AIzaSyCbQNyo-qkvvV4xuto_LZDehgUnqCJtuHs';
	if ( $google_map_api_key = carbon_get_theme_option( 'google_map_api_key' ) ) {
		$apiKey = $google_map_api_key;
	}
	$address     = urlencode( $address );
	$geocodeFrom = file_get_contents( 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=' . $apiKey . '&language=' . $language );
	$outputFrom  = json_decode( $geocodeFrom );
	if ( ! empty( $outputFrom->error_message ) ) {
		return $outputFrom->error_message;
	}
	$res = $outputFrom->results[0]->address_components[0]->long_name;
	if ( isset( $outputFrom->results[0]->address_components[2]->long_name ) ) {
		$res .= ', ' . $outputFrom->results[0]->address_components[2]->long_name;
	}
	set_transient( $_string, $res, 60 );

	return $res;
}

function getCoordinatesAddress( $address, $language = 'uk' ) {
	$_string = 'google_address_coordinates_' . str_replace( ' ', '_', $address );
	if ( false !== ( $res = get_transient( $_string ) ) ) {
		return $res;
	}
	$address = urlencode( $address );
	$apiKey  = 'AIzaSyCbQNyo-qkvvV4xuto_LZDehgUnqCJtuHs';
	if ( $google_map_api_key = carbon_get_theme_option( 'google_map_api_key' ) ) {
		$apiKey = $google_map_api_key;
	}
	$geocodeFrom = file_get_contents( 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false&key=' . $apiKey . '&language=' . $language );
	$outputFrom  = json_decode( $geocodeFrom );
	if ( ! empty( $outputFrom->error_message ) ) {
		return $outputFrom->error_message;
	}
	$latitude  = $outputFrom->results[0]->geometry->location->lat;
	$longitude = $outputFrom->results[0]->geometry->location->lng;
	$res       = "$latitude,$longitude";
	set_transient( $_string, $res, 60 );

	return $res;
}

function getDistanceByCoordinates( $arr = array() ) {

	$latitudeFrom  = (float) $arr['location_from']['lat'];
	$longitudeFrom = (float) $arr['location_from']['lng'];
	$latitudeTo    = (float) $arr['location_to']['lat'];
	$longitudeTo   = (float) $arr['location_to']['lng'];
	$unitShow      = $arr['unit_show'] ?? true;
	// Calculate distance between latitude and longitude
	$theta = $longitudeFrom - $longitudeTo;
	$dist  = sin( deg2rad( $latitudeFrom ) ) * sin( deg2rad( $latitudeTo ) ) + cos( deg2rad( $latitudeFrom ) ) * cos( deg2rad( $latitudeTo ) ) * cos( deg2rad( $theta ) );
	$dist  = acos( $dist );
	$dist  = rad2deg( $dist );
	$miles = is_nan( $dist ) ? 0.5 : $dist * 60 * 1.1515;
	// Convert unit and return distance
	$unit = strtoupper( $arr['unit'] );
	if ( $unit == "K" ) {
		return round( $miles * 1.609344, 0 ) . ( $unitShow ? ( ' км' ) : '' );
	} elseif ( $unit == "M" ) {
		return round( $miles * 1609.344, 0 ) . ( $unitShow ? ' метрів' : '' );
	} else {
		return round( $miles, 0 ) . ( $unitShow ? ' миль' : '' );
	}
}

function getDrivingDistance( $origin, $destination ) {
	$md5      = 'DrivingDistance__' . md5( $origin . $destination );
	$distance = get_transient( $md5 );
	if ( $distance === false ) {
		$apiKey = 'AIzaSyCbQNyo-qkvvV4xuto_LZDehgUnqCJtuHs';
		if ( $google_map_api_key = carbon_get_theme_option( 'google_map_api_key' ) ) {
			$apiKey = $google_map_api_key;
		}
		$url         = 'https://maps.googleapis.com/maps/api/distancematrix/json';
		$params      = [
			'origins'      => $origin,
			'destinations' => $destination,
			'mode'         => 'driving',
			'key'          => $apiKey
		];
		$queryString = http_build_query( $params );
		$requestUrl  = $url . '?' . $queryString;
		$ch          = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $requestUrl );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$response = curl_exec( $ch );
		curl_close( $ch );
		$data = json_decode( $response, true );
		if ( $data['status'] == 'OK' ) {
			$distance = $data['rows'][0]['elements'][0]['distance']['value'];
			$distance = $distance / 1000;
			set_transient( $md5, $distance, 30 * DAY_IN_SECONDS );

			return $distance;
		} else {
			return 0;
		}
	}

	return $distance;
}