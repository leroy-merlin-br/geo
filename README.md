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
