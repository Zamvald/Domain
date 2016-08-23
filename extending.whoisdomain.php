<?php
/**
 * Extending Usage of class SimpleWhoisDomain
 *
 * I use these scripts is for example or you could use this class extends strucure as example use.
 * I was include / require file as the structure like the directory
 * @package SimpleWhoisDomain
 */


// check the files is readable by server
if( ! is_readable( 'mainscripts/class.SimpleWhoisDomain.php' ) ) {
    die('file class.SimpleWhoisDomain.php is not exist!');
}
// and also check whoisservers.php as needed by the file for whoisservers definition
if( ! is_readable( 'mainscripts/whoisservers.php' ) ) {
    die('file whoisservers.php is not exist!');
}

// include class.SimpleWhoisDomain.php from directory ( mainscripts )
require_once 'mainscripts/class.SimpleWhoisDomain.php';

/**
 * Extends the class Whois Domains
 */

class extendSimpleWhoisDomain extends SimpleWhoisDomain
{
    /**
     * Make sure you have function construct to contruct the parent
     * @param bool $usecache true if use cache false if not
     * @param string cache  the cache directory
     */
    public function __construct( $usecache=true, $cachedir='cache' )
    {

        /**
         * Determine the first called wether the scripts use cache or no,
         * you cal call as extendSimpleWhoisDomain( true, cache ) // true as use caching and cache as directorty cache
         * set $usecache as false to disable cache
         */
        $this->cache    = $usecache;

        /**
         * first determine the cache directory as call the class, this prevent first create cache directory as first class called
         */
        $this->cachedir = $cachedir;

        /**
         * call the parent constructor after determine the cache and cache directory
         * Contruct the parent to determine eg: whoisservers and cache directory
         */
        parent::__construct();
    }

    /**
     * Create cache directory set functions
     */
    public function set_cache_dir( $dir )
    {
        $$this->cachedir = $dir;
    }

    /**
     * Function to clear the cache
     * please no insert the arguments on directory cache on parent class
     * and make sure the cache directory is not change !! , and please know what you did or your file will be fly
     */
    public function delete_cache()
    {
        $this->clear_file_cache();
    }

    /**
     * Check wether this scripts domain checker & whois lookup is use cache
     * by default cache directory using name : ache on current the script run has been called
     * @return bool true if use
     */
    public function is_use_cache()
    {
        return $this->cache;
    }

    /**
     * @param string $string is the input bulk domain checker
     * @param integer / numeric $maxcount for max domain check on bulk domain checker
     */
    public function bulk_check( $string , $maxcount=false )
    {
        /**
         * Splitting domain by commas
         * @uses domain_splitbycomma
         * @return array domain name as 1 is available and blank is false and if the error if have an error
         */
        $domainarray = $this->domain_splitbycomma( $string );
        
        /**
         * @uses bulk_available_check() and this function need domain input as array
         * @return array domain name bulk_available_check( array $domainarray )
         */
        return $this->bulk_available_check( $domainarray, $maxcount );
    }

    /**
     * Check one domain name as the bulk extension check
     * @param string $string is the input bulk domain checker
     * @param integer / numeric $maxcount for max domain check on mass bulk domain checker
     * @param bool $show_when_is_notallow if has not allowed domain will be shown another extension
     * @param bool $rand  set true if use random if allowed extsnion bulk get same with extension whois
     */
    public function mass_single_check( $domain , $maxcount = 6 , $show_when_is_notallow = false, $rand = true)
    {
        return $this->bulk_available_single_check( $domain , $maxcount , $show_when_is_notallow, $rand );
    }

    /**
     * This function to set the regex of domain validation
     * Please make sure your regex is tested
     */
    public function set_regex_domain( $regex )
    {
        $this->regexdomain     = $regex ;
    }

}
