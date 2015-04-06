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
     * @var Curl
     */
    protected $curl;

    /**
     * Constructs a new IpLocator
     *
     * @param Curl
     */
    public function __construct(Curl $curl = null)
    {
        $this->curl = $curl ?: new Curl;
    }

    /**
     * Returns a location for the given IP
     *
     * @param  string   $ip
     *
     * @return string[] Location information
     */
    public function getLocation($ip)
    {
        $this->curl->get('http://ip-api.com/json/'.$ip);

        if (! $this->curl->error) {
            return json_decode($this->curl->response, true);
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
