<?
include("RIS.php");

/**
 * Name of the Reddit to scrape images from. 
 * Example: pics, aww, etc.
 */
$reddit = "pics";

/**
 * Number of pages to scrape pages from. Each
 * page has 100 *possible* image links. 
 */
$pages = 5;

/**
 * How to call the script. 
 */
$t = new RIS($reddit, $pages);

?>
