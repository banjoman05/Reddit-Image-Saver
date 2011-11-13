<?
/**
 * This class scrapes image links from a given (sub)Reddit and saves
 * the images in a folder. This script will also check for identical 
 * images (same file names) to avoid duplicated.
 *
 * View 'example.php' for usage instructions.
 *
 * @author Josh Grochowski (josh at kastang dot com)
 */

class RIS {

    var $after = "";
    var $reddit = "";

    /**
     * @param $reddit: Name of the sub-Reddit.
     * @param $pages: Number of pages of images to scrape. Each page
     * contains 100 possible image links.
     */
    public function __construct($reddit, $pages) {

        $this->reddit = $reddit;

        //Creates the Directory where the images will be stored 
        //only if the folder doesn't already exist.
        if(!file_exists($this->reddit)) {
            mkdir($this->reddit, 0755);
        }

        $pCounter = 1;
        while($pCounter <= $pages) {
            $url = "http://reddit.com/r/$reddit/.json?limit=100&after=$this->after";
            $this->getImagesOnPage($url);
            $pCounter++;
        }

    }

    /**
     * This function will parse the contents of the given Reddit JSON URL and
     * save all Image links.
     *
     * @param $url: Reddit JSON Url
     */
    private function getImagesOnPage($url) {

        $json = file_get_contents($url);
        $js = json_decode($json);

        foreach($js->data->children as $n) {
            if(preg_match('(jpg$|gif$|png$)', $n->data->url, $match)) {
                echo $n->data->url."\n";
                $this->saveImage($n->data->url);
            }

            $this->after = $js->data->after;
        }
    }

    /**
     * Given an Image URL, save the image to the proper directory.
     *
     * @param $url: URL of an Image
     */
    private function saveImage($url) {
        $imgName = explode("/", $url);
        $img = file_get_contents($url);

        //if the file doesnt already exist...
        if(!file_exists($this->reddit."/".$imgName[(count($imgName)-1)])) {
            file_put_contents($this->reddit."/".$imgName[(count($imgName)-1)], $img);
        }
    }
}

?>
