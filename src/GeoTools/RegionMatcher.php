<?php

use LeroyMerlin\GeoTools\Exception\GeoDataException;
use Icecave\Isolator\Isolator;
use GeoPHP\Adapter\KML;
use GeoPHP\Geometry\Polygon;
use GeoPHP\Geometry\Point;

/**
 * The region matcher can load a bunch of polygons (from KML files) and then
 * test in which of the regions a geo location point is inside.
 *
 * @package  LeroyMerlin\GeoTools
 *
 * @license  MIT
 */
class RegionMatcher
{
    /**
     * Isolated PHP instance
     * @var Isolator
     */
    public $php;

    /**
     * The loaded regions
     * @var Polygon[]
     */
    public $regions = [];

    public function __construct(Isolator $php = null)
    {
        $this->php = $php ?: new Isolator;
    }

    /**
     * Loads the given KML file
     *
     * @param  string $kmlFilename The file to be loaded
     * @param  string $regionName  The name of the region. If omitted the filename will be used as the region name
     *
     * @return boolean Success
     */
    public function loadRegion($kmlFilename, $regionName = null)
    {
        $data = null;

        if ($this->php->file_exists($kmlFilename)) {
            $data = $this->php->file_get_contents($kmlFilename);
        }

        if (! $data) {
            throw new GeoDataException("Error reading file $kmlFilename", 4002);
        }

        if (! $regionName) {
            $regionName = $this->php->basename($kmlFilename, 'kml');
        }

        return $this->loadRegionData($data, $regionName);
    }

    /**
     * Loads a region with the data of the KML
     *
     * @param  string $kmlContent A KML string
     * @param  string $regionName The name of the region
     *
     * @return boolean Success
     */
    public function loadRegionData($kmlContent, $regionName)
    {
        $adapter  = new KML;
        $polygon = $adapter->read($kmlContent);

        if ($polygon instanceof Polygon) {
            return $this->addRegion($polygon, $regionName);
        }

        throw new GeoDataException("Region ".$regionName." data cannot be loaded as a Polygon", 4001);
    }

    /**
     * Test the given coordenates in each of the loaded regions and return an
     * array with the regions that intersect with the coordenates
     *
     * @param  int      $x Longitude
     * @param  int      $y Latitude
     *
     * @return string[] The name of the regions that the point is inside
     */
    public function getRegionsThatMatches($x, $y)
    {
        return $this->getRegionsThatMatchesPoint(new Point($x, $y));
    }

    /**
     * Test the given point in each of the loaded regions and return an array
     * with the regions that the point hits
     *
     * @param  Point  $point The point to be tested
     *
     * @return string[]      The name of the regions that the point is inside
     */
    public function getRegionsThatMatchesPoint(Point $point)
    {
        $result = [];

        foreach ($this->regions as $name => $polygon) {
            if ($polygon->pointInPolygon($point)) {
                $result[] = $name;
            }
        }

        return $result;
    }

    /**
     * Adds a region polygon to the RegionMatcher
     *
     * @param Polygon $regionPolygon
     * @param string  $regionName
     *
     * @return  boolean Success
     */
    protected function addRegion(Polygon $regionPolygon, $regionName)
    {
        $this->regions[$regionName] = $regionPolygon;

        return true;
    }
}
