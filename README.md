# GeoTools

`leroy-merlin-br/geo` is a simple to use set of tools for geolocation. It's an abstraction built on top of the powerfull `phayes/geophp`.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/37797681-891b-49e2-beae-af6576662f0b/small.png)](https://insight.sensiolabs.com/projects/37797681-891b-49e2-beae-af6576662f0b)

## Region matching

With the `LeroyMerlin\GeoTools\RegionMatcher` you can easily test if a coordinate is inside of a region.

**Example of use:**

```PHP
$regionMatcher = new LeroyMerlin\GeoTools\RegionMatcher;

$regionMatcher->loadRegion('/path/to/myRegion.kml');
$regionMatcher->loadRegion('/path/to/intersectingRegion.kml');
$regionMatcher->loadRegion('/path/to/farAwayRegion.kml');

$regionMatcher->getRegionsThatMatches(23, 23);
// returns ['myRegion', 'intersectingRegion']
```

## IP to geolocation

`LeroyMerlin\GeoTools\IpLocator` uses _ip-api.com_ to find out the geolocation of a given IP address.

**Example of use:**

```PHP
$locator = new LeroyMerlin\GeoTools\IpLocator;

$locator->getLocation('208.80.152.201');
// array(
//   'as' => 'AS14907 Wikimedia Foundation Inc.',
//   'city' => 'San Francisco',
//   'country' => 'United States',
//   'countryCode' => 'US',
//   'isp' => 'Wikimedia Foundation',
//   'lat' => 37.7898,
//   'lon' => -122.3942,
//   'org' => 'Wikimedia Foundation',
//   'query' => '208.80.152.201',
//   'region' => 'CA',
//   'regionName' => 'California',
//   'status' => 'success',
//   'timezone' => 'America/Los_Angeles',
//   'zip' => '94105'
// )

$locator->getCoordinates('208.80.152.201');
// array(
//   'x' => 37.7898,
//   'y' => -122.3942
// )
```
