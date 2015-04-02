<?php
namespace LeroyMerlin\GeoTools;

use Curl\Curl;

/**
 * Finds the location of a given IP in the globe
 *
 * @package  LeroyMerlin\GeoTools
 *
 * @license  MIT
 */
class IpLocator
{
    /**
     * Returns a location for the given IP
     *
     * @param  string   $ip
     *
     * @return string[] Location information
     */
    public function getLocation($ip)
    {
        $curl = new Curl;
        $curl->get('http://ip-api.com/json/'.$ip);

        if (! $curl->error) {
            return json_decode($curl->response, true);
        }

        return [];
    }

    /**
     * Returns a latitude and longitude for the given IP
     *
     * @param  string      $ip
     *
     * @return int[]|null  Array containing 'x' and 'y' keys for the latitude and longitude
     */
    public function getCoordinates($ip)
    {
        $result = $this->getLocation($ip);

        if (isset($result['lat']) && isset($result['lon'])) {
            return ['x' => $result['lat'], 'y' => $result['lon']];
        }

        return null;
    }
}
