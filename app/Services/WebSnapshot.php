<?php

namespace App\Services;

class WebSnapshot {
	public static $snapshotBaseUrl = 'https://snapshot.apple-mapkit.com';
	public static $snapshotPath = '/api/v1/snapshot';
	public static $jsonParams = [
		'annotations',
		'overlays',
		'imgs',
	];

	/**
	 * Generates a signed URL to an Apple Maps snapshot image.
	 *
	 * @param string $center The center of the map, specified as either coordinates or an address
	 * @param array $additionalParams A keyed array of any additional map parameters; JSON parameters will be encoded automatically
	 * @return false|string
	 */
	public static function signedURL($center, $additionalParams = []) 
    {
        $teamId = config('services.apple.team');
        $keyId = config('services.apple.maps_key_id');
        $private_key = config('services.apple.maps_key');

		foreach (static::$jsonParams as $param) {
			if (isset($additionalParams[$param])) {
				$additionalParams[$param] = json_encode($additionalParams[$param]);
			}
		}

		$params = array_merge([
			'center' => $center,
			'teamId' => $teamId,
			'keyId' => $keyId,
		], $additionalParams);

		$request_uri = static::$snapshotPath . '?' . http_build_query($params);

		if (!$key = openssl_pkey_get_private($private_key)) {
			return false;
		}
        
		if (!openssl_sign($request_uri, $signature, $key, OPENSSL_ALGO_SHA256)) {
			return false;
		}

		return static::$snapshotBaseUrl . $request_uri . '&signature=' . urlencode(base64_encode($signature));
	}
}