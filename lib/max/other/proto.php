<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * Functions used in UI prototypes, to be removed 
 * after the UIs are fully implemented. 
 */

/** Campaign-zone linking prototype */
$websiteNameIndex = 0;
$zoneNameIndex = 0;

$websiteNames = array("www.test.com", "ebay.com", "openx.org", "my.blog.com", "computers.com");
$zoneNames = array("Home page top", "Home page side", "Product page bottom", "Specials", "Tiny");

function generateWebsiteName()
{
  global $websiteNameIndex, $websiteNames;
  return $websiteNames[$websiteNameIndex++ % count($websiteNames)];
}

function generateZoneName()
{
  global $zoneNameIndex, $zoneNames;
  return $zoneNames[$zoneNameIndex++ % count($zoneNames)];
}

function getWebsites($advertiserId, $campaignId, $searchPhrase, $status = 'all', $category = 'Finance') {
  $websiteCount = $status == 'available' ? 5 : 2;
  $zoneCount = $status == 'available' ? 4 : 2;

  $websites = array();
  for ($i = 0; $i < $websiteCount; $i++) {
    $zones = array();
    
    $websiteName = generateWebsiteName();
    $websiteNameHighlighted = str_replace($searchPhrase, "<b>" . $searchPhrase. "</b>", $websiteName);
  
    $websiteMatched = strlen($websiteNameHighlighted) > strlen($websiteName) || empty($searchPhrase);
    $zonesMatched = false;
    
    for ($j = 0; $j < $zoneCount; $j++) {
      $zoneName = generateZoneName();
      $zoneNameHighlighted = str_replace($searchPhrase, "<b>" . $searchPhrase. "</b>", $zoneName);
      
      $zoneMatched = strlen($zoneNameHighlighted) > strlen($zoneName)|| empty($searchPhrase);
      $zonesMatched = $zonesMatched || $zoneMatched;
      
      if ($zoneMatched || $websiteMatched) {
        array_push($zones, array(id=> $j, linked => ($j % 3) == 0, name => $zoneNameHighlighted, ctr => 0.003, cr => 0.001, ecpm => 0.23, category => $category, description => ""));
      }
    }
    
    if ($websiteMatched || $zonesMatched) {
      array_push($websites, array(id => $i, linked => false, name => $websiteNameHighlighted, ctr => 0.08, cr => 0.02, ecpm => 3.45, category => $category, description => "", zones => $zones));
    }
  }
  
  return $websites;
}
?>