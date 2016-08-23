<?php
/**
 * Object oriented PHP for Domain checker and whois lookup
 *
 * @version 2.1
 * @package SimpleWhoisDomain
 * @author awan_move { @link http://codecanyon.com/user/awan_move }
 *
 * @revision
 * - May 5th 2014 :
 *       fix domain split by commas function that could not splitting extension only
 *       Added function bulk_available_single_check() to mass check domain name : -> one name with mass different extension
 * - May 14th 2014
 *      added whois servers : pub, pw, qa
 *      fix error positition bulk domain
 * - May 25th 2014
 *      added checkbox example usage
 * - June 19th 2014
 *      added shell_exec to get whois servers , that need by some domain ( eg: domain.com )
 * - June 20th 2014
 *      added method class on constructor arguments ( cache dir and usecache )
 * - October 2nd 2014
 *      fix unmatched / server match string words
 *      fix bulk domain check max num check
 *      fix .nu match domain  that always registered
 *      change app.js with more global use
 *      add class to each form tags on exampleuseajax.php, for selector ajax on app.js to easier to use
 */

class SimpleWhoisDomain
{
    /**
     * Determine if whois server use cache
     */
    public $cache               = true;

    /**
     * Determine the cache directory
     * you could change here
     */
    public $cachedir            = 'cache';

    /**
     * Determine cache expire
     */
    public $cacheexpire         = 3600;

    /**
     * @var array $whoisservers , for whois servers
     * determine on contruct
     */
    public $whoisservers        = array();

    /**
     * set by commas '.com,.net,.org'
     * is for allowed extension to check
     */
    public $allowextension      = '';

    /**
     * set by commas '.com,.net,.org'
     * is for allowed whois extension to check
     */
    public $allowextensionwhois  = '';

    /**
     * set by commas '.com,.net,.org'
     * is for allowed single bulk extension to check
     */
    public $allowextensionbulk   = '';

    /**
     * @param integer $port as the server port of method fputs socket connection
     */
    protected $port              = 43;

    /**
     * Set time out request domain information, while getting data
     */
    public $timeout             = -1;

    /**
     * Pattern domain validation
     * minimum 2 characters maximum 100 character with alpha numeric and dashed only
     * extension minimum 2 chars and max 8 characters.
     * this standard domain validation use  standard alphabetic,you could change it with other regex
     *
     */
    public $regexdomain         = "/^([-a-z0-9]{2,100})\.([a-z\.]{2,12})$/i";

    /**
     * Just determine if checking have error
     */
    protected $error           = false ;

     /**
     * Contructor
     * This contruict the whois data from whoisservers.php as array and determine variable $whoisservers
     * @param  string $cachedir the cache directory
     * @param  bool   $usecache useing cache or no
     * @return false  and print the error if whoisservers.php is not exists , so this class is not function
     */
    public function __construct($usecache = true, $cachedir = false)
    {
        if ( is_readable( dirname(__FILE__).'/whoisservers.php' ) ) {
            require_once dirname(__FILE__).'/whoisservers.php';
            $this->whoisservers = $whoisservers;
        } else {
            throw new Exception( 'whoisservers.php is not exist. Could not continue' );

            return false;
        }

        $this->cache = (bool) $usecache;

        if ($this->cache) {
            if ( is_string( $cachedir ) ) {
                $this->cachedir = $cachedir;
            }
            $this->create_cache_dir();
        }
    }

    /**
     * Show if has an error
     * @return bool
     */
    public function has_error()
    {
        return (bool) $this->error;
    }

    /**
     * Create Cache dir and index html
     * create htacess for protecting direct indexing file on cache
     * @return void
     */
    private function create_cache_dir()
    {
        if ( ! is_dir( $this->cachedir ) || is_dir( $this->cachedir ) && is_writable( $this->cachedir ) ) {
            if (  ! is_dir( $this->cachedir ) ) {
                @mkdir( $this->cachedir, 755 );
            }

            $indexfile = rtrim( $this->cachedir,'/').'/index.html';
            if( ! is_file( $indexfile )
                || is_file( $indexfile ) && filesize( $indexfile )  > 0 ) {
                @file_put_contents( $indexfile, '');
            }
            /**
             * Check if server using apache / litespeed softare
             * create htaccessfile
             */
            if ( stripos( ' '.$_SERVER['SERVER_SOFTWARE'], 'Apache') || stripos( ' '.$_SERVER['SERVER_SOFTWARE'], 'Litespeed') ) {
                $contenthtaccess = "order deny,allow \ndeny from all";
                $htaccessfile = rtrim( $this->cachedir,'/').'/.htaccess';
                if ( ! is_file( $htaccessfile ) || is_file( $htaccessfile ) &&  @file_get_contents( $htaccessfile ) !== $htaccessfile ) {
                    @file_put_contents( $htaccessfile, $contenthtaccess );
                }
            }

            $this->cache = true;

            return;
        }

        $this->cache = false;

        return;
    }

    /**
     * Clear All files on cache directory ,
     * becareful with use this function or all your file will be dead
     * @param  string $dir the directory
     * @return remove all files on directory
     */
    protected function clear_file_cache($dir=false)
    {
        if ( ! $dir || strpos( $dir, $this->cachedir ) === FALSE ) { # prevent change directory with strpos
            $dir = $this->cachedir;
        }

        foreach ( scandir( $dir ) as $file ) {
            if (
                '.' === $file || '..' === $file                               # ignore directory
                || ! is_file( $file ) && strpos( $file, 'cache' ) === false   # just delete with file name start with cache.md5(file) avoid deleting unwanted files deleted
                ) {
              continue; # continue loop ignore this
            }
            if ( is_dir("$dir/$file") ) {
              $this->clear_file_cache( "$dir/$file" );
            } else {
              unlink("$dir/$file");
            }
        }
    }

    /**
     * By default whois server use port 43 and TCP connection to allowed access and getting data and use method fputs
     * so we must use fputs with php function itself to getting data from whois servers
     * @param string server as the server whois
     * @param $domain full domain name
     * @return string data domain from server
     */
    protected function socket($server, $domain)
    {
        $domain_cachefile = rtrim( $this->cachedir,'/').'/cache.'.md5( strtolower( $domain.$server ) ); // cahce file name
        $arr   = is_readable( $domain_cachefile ) && is_string( @unserialize( @file_get_contents( $domain_cachefile ) ) ) ?
                @unserialize( @file_get_contents( $domain_cachefile ) ) : false;

        if( $this->cache && ( ! is_readable( $domain_cachefile ) || ! $arr || $arr && ( time() - filemtime( $domain_cachefile ) ) > $this->cacheexpire )
            || ! $this->cache
        ) {

            /**
             * Detect if OS is not windows ( is linux ) , and shell_exec is allowed
             * also is server whois.verisign-grs.com | whois.crsnic.net
             * will be checked first to get whois server from Shell
             * eg : google.com or domain.com
             */
            if( strpos( PHP_OS, 'win' ) === false && function_exists('shell_exec') &&
                ( strtolower( $server ) == 'whois.crsnic.net' || strtolower( $server ) == 'whois.verisign-grs.com' )
                ) {

                @set_time_limit(10);
                $string = @shell_exec( "whois $domain" );
                // if response has busy determine variable busy
                $busy = strpos( $string, 'busy') !== false ? true : false;
                if ($string && $busy === false) {
                    preg_match("/redirected to\s*(.*)\s*]/", strtolower( $string ), $matches );
                    $server = isset( $matches[1] ) ? $matches[1] : $server;
                }
                @set_time_limit($this->timeout);

            }

            $fp = @fsockopen( $server, $this->port, $errno, $errstr, $this->timeout ); # getting connection
            if (! $fp) {
                $out =  $errno.' : '.$errstr;
                $this->error = true;
            } else {
                fputs( $fp, $domain."\r\n" );
                $out = "";
                while ( ! feof( $fp ) ) {
                    $out .= fread( $fp, 4096 );
                }

                fclose( $fp );

                $this->error = false;

                if (
                     $this->cache && ( ! is_file( $domain_cachefile ) || is_writable( $domain_cachefile ) )
                    && ( ! isset( $busy ) || isset( $busy ) && $busy === false || strpos( $out, 'busy') === false )
                ) {
                    @file_put_contents( $domain_cachefile, serialize( $out ) ); # puts the content
                }
            }
        } else {
            $out = @unserialize( @file_get_contents( $domain_cachefile ) );
            $this->error = false;
        }

        return $out;
    }

    /**
     * If on whois servers have http use curl as method if use http methods
     *
     * @param  string $url    as whois server url
     * @param string method get or post as method curl request
     * @param  string $domain the domain name
     * @return string $data
     */
    protected function curl($url = false, $method = 'get' , $domain)
    {
        if ( ! function_exists( 'curl_init' ) ) {
            echo 'Curl Must Be enabled  on your server !!';

            return false;
        }

        if (! $url) {
            return false;
        }

        $val = 1;
        if ( strtolower( $method ) !== 'post' ) {
            $val = 0;
        }

        $domain_cachefile = rtrim( $this->cachedir,'/').'/cache.'.md5( strtolower( $domain.$url ) );
        $arr   = is_readable( $domain_cachefile ) && is_string( @unserialize( @file_get_contents( $domain_cachefile ) ) )
                ? @unserialize( @file_get_contents( $domain_cachefile ) ) : false;
        if( $this->cache && ( ! is_readable( $domain_cachefile ) || ! $arr || $arr && ( time() - filemtime( $domain_cachefile ) ) > $this->cacheexpire )
            || ! $this->cache
        ) {

            $ch  = curl_init();                                  # begin transaction
            $url = $url.$domain;                                 # determine the uri to use as request
            curl_setopt( $ch, CURLOPT_URL, $url );               # set uri request on curl
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0 );       # allow follow location set false
            curl_setopt( $ch, CURLOPT_TIMEOUT, $this->timeout ); # set time out curl request
            curl_setopt( $ch, CURLOPT_POST, $val );              # set post request true or false use method
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );       # return transfer data
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );       # do not verify the host if use ssl
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );       # donot verify peer connection if use ssl
            $data = curl_exec( $ch );                            # execute the transaction
            $error = curl_error($ch);                            # check error
            curl_close( $ch );                                   # close the transaction
            if (!$error) {
                if ( strpos( $data, '<body>') ) {
                    $data = explode('<body>', $data);
                    $data = explode('</body>',$data[1]);
                    $data = $data[0];
                }

                $data = strip_tags($data);
                if ( $this->cache && ( ! is_file( $domain_cachefile ) || is_writable( $domain_cachefile ) ) ) {   $this->error = false; # set error as false
                    @file_put_contents( $domain_cachefile, serialize( $data ) ); # puts the content
                }
            } else {
                $this->error = true;
                $data = $error;
            }
        } else {
            $data = @unserialize( @file_get_contents( $domain_cachefile ) );
            $this->error = false;
        }

        return $data;

    }

    /**
     * get all whois array
     * @return array
     *               array('.ext' => array('whoisserver.com','matcher'), etc...);
     */
    protected function get_array_whois()
    {
        if ( ! is_array( $this->whoisservers ) || empty( $this->whoisservers ) ) {
            return false;
        }

        $whois = array();
        foreach ($this->whoisservers as $key => $value) {
            $whois[$key] = $value;
        }

        return $whois;
    }

    /**
     * @return array() avaliable whois extension
     * @return array   data
     */
    protected function get_whois_available_extension()
    {
        if ( ! is_array( $this->whoisservers ) || empty( $this->whoisservers ) ) {
            return false;
        }

        return array_keys( $this->whoisservers );
    }

    /**
     * Check allowed extension when use bulk / single allowed domain checker
     * is not include as bulk domain checker bulk single domain name
     * @return bool true if not empty
     */
    protected function checkallowedextension()
    {
        if ( ! $this->allowextension || $this->allowextension == ''
            || empty( $this->allowextension ) || ! is_string( $this->allowextension ) ) {
            return true;
        }

        return false;
    }

    /**
     * Check allowed extension when use bulk single allowed domain checker
     * is just for include as bulk domain checker bulk single domain name
     * @return bool true if not empty
     */
    protected function checkallowextensionbulk()
    {

        if ( ! $this->allowextensionbulk || $this->allowextensionbulk == ''
            || empty( $this->allowextensionbulk ) || ! is_string( $this->allowextensionbulk ) ) {
            return true;
        }

        return false;
    }

    /**
     * Check allowed extension when use whois domain checker
     * is for include as single and bulk domain checker domain name
     * @return bool true if not empty
     */
    protected function checkallowedextensionwhois()
    {
        if ( ! $this->allowextensionwhois || $this->allowextensionwhois == ''
            || empty( $this->allowextensionwhois ) || ! is_string( $this->allowextensionwhois ) ) {
            return true;
        }

        return false;
    }

    /**
     * Check allowed extension to checking domain
     * @return array domain extension
     */
    public function allowextension()
    {
        if ( ! $this->checkallowedextension() ) {
            return $this->domain_splitbycomma( $this->allowextension );
        }

        return $this->get_whois_available_extension();
    }

    /**
     * Check allowed extension when use bulk single allowed domain checker
     * is just for include as bulk domain checker bulk single domain name
     * @return bool true if not empty
     */
    protected function allowextensionbulk()
    {
        if ( ! $this->checkallowextensionbulk() ) {
            return $this->domain_splitbycomma( $this->allowextensionbulk );
        }

        return $this->get_whois_available_extension();
    }

     /**
     * Check allowed extension to checking domain
     * @return array domain extension as whois
     */
    public function allowextensionwhois()
    {
        if ( ! $this->checkallowedextensionwhois() ) {
            $unique = array_unique(
                            array_merge(
                                $this->allowextension(),
                                $this->allowextensionbulk(),
                                $this->domain_splitbycomma( $this->allowextensionwhois)
                            )
                        );

            return array_values( $unique ); #renumbering the array
        }

        return $this->get_whois_available_extension();
    }

    /**
     * Get available extension if extension is not match blank
     * @param $extension the domain extension
     * @return string whois server uri match words
     */
    protected function get_whois_match($extension)
    {
        $arraywhois = $this->get_array_whois();
        if( is_array( $arraywhois ) && in_array( $extension, $this->get_whois_available_extension() )
            && isset( $arraywhois[$extension][1] ) && $arraywhois[$extension][1] !== '' ) {
            return $arraywhois[$extension][1];
        }

        return false;
    }

    /**
     * Get whois servers by extension
     * @param $extension the domain extension
     * @return string whois server uri
     */
    protected function get_whois_server($extension)
    {
        $extension = strtolower( $extension );
        $arraywhois = $this->get_array_whois();
        if( is_array( $arraywhois ) && in_array( $extension, $this->get_whois_available_extension() )
            && isset( $arraywhois[$extension][0] ) && $arraywhois[$extension][0] !== '' ) {
            return trim( $arraywhois[$extension][0] );
        }

        return false;
    }

    /**
     * Domain Validation for validate domain is valid or no
     * @param  string $domain full domain name
     * @return bool   true if valid
     */
    public function domain_name_validation($domain)
    {
        // if is not match criteria valid domain will be return false
        if ( ! preg_match( $this->regexdomain, $domain ) ) {
            return false;
        }

        return true;
    }

    /**
     * Split and get just domain name return domain name if valid domain
     * @param  string $domain full domain name
     * @return string split value
     */
    public function split_domain($domain)
    {
        // validate domain name
        if ( $this->domain_name_validation( $domain ) ) {
            $split = preg_split( '/[\s.]/', $domain ); # split and take after first dot

            return (string) reset( $split );
        }

        return false;
    }

    /**
     * Split and get just domain extension
     * @return string extension
     */
    public function split_extension($domain)
    {
        // validate domain name
        if ( $this->domain_name_validation( $domain ) ) {
            # split domain name and use replace domain name

            return str_replace(
                                $this->split_domain( strtolower ( $domain ) ),
                                '',
                                strtolower( $domain )
                            );
        }

        return false;
    }

    /**
     * Spliting domain by commas for allowedextensionwhois and allowedextension
     *
     * @param  string $input the list of domain name
     * @revision fix bug extension only to be check
     * @return array  array_values exploded string $input
     */
    public function domain_splitbycomma($input)
    {
        if ( ! is_string ( $input ) ) {
            echo 'input must be string';

            return false;
        }

        // removed
        // $replace = preg_replace( '/[^-a-z0-9.,]/', '', $input ); // replace unaccepted characters
        $explode = explode(',', trim( $input, ',') ); // commas into array

        $allext = $this->get_whois_available_extension();

        $result = array();
        /**
         * Loop it also remove unavailable extension
         */
        foreach ($explode as $value) {
            $v = $value;
            // fix just extension only
            $s = $this->split_extension( $value );
            if ( ! empty( $s ) ) {
                $v = $this->split_extension( $value ); # split extension
            }
            if ( ! in_array( $v, $allext ) ) {
                $result[] = false;
            } else {
                $result[] = $value;
            }
        }

        $filtering = array_filter( $result );    # filter the empty arrays
        $unique    = array_unique( $filtering ); # get unique value to prevents duplicates value

        return array_values( $unique );          # renumbering the arrays
    }

    /**
     * String to show about the invalid domain name
     */
    public $invalid_domain     = 'Invalid domain name : %domain%.';

    /**
     * String to show about the domain is not support
     */
    public $unsupport_domain   = 'Domain: %domain% is not supported.';

    /**
     * String to show about the error was generated when checking domain
     */
    public $error_domain       = 'there\'s was an error when checking domain: %domain%.';

    /**
     * String to show about the extension is not allowed
     */
    public $notallow_extension = 'Domain extension %extension% is not allowed for %domain%.';

    /**
     * Protcted function for knowing replace words with  %domain% as domain name , %extension% as domain extension and %name% as just domain name
     * @return string replace and the words
     */
    protected function split_error($domain, $type)
    {
        $thedomainname = $this->split_domain( $domain ); # split the domain name
        $theextension  = $this->split_extension( $domain ); # split the extension name
        if ( isset( $this->$type ) ) {
            $langs         = $this->$type;

            return str_replace( array(
                                    strtolower('%domainname%'),
                                    strtolower('%extension%'),
                                    strtolower('%domain%')
                                ),
                                array(
                                    $thedomainname,
                                    $theextension,
                                    $domain
                                ),
                                $langs
                            );
        }
    }

    /**
     * Getting connection whois
     * @param  string $domain full domain name
     * @return string whois information
     */
    protected function get_the_whois($domain)
    {
        $result = $this->split_error( $domain, 'invalid_domain' );
        $this->error = true; # as default error has true when first check
        // if domain valid
        if ( $this->domain_name_validation( $domain ) ) {
            // get extension
            $extension = $this->split_extension( $domain );
            // get whois server
            $server = $this->get_whois_server( $extension );

            if ( $server && in_array( $extension, $this->allowextensionwhois() ) ) {

                // if use method http
                if ( preg_match('/http/', $server ) ) {
                    $result = $this->curl( $server, 'get', $domain );
                } else {
                    $result = $this->socket( $server, $domain );
                }
            } else {
                $result = $this->split_error( $domain, 'unsupport_domain' );
                $this->error = true;
            }
        }

        return $result;
    }

    /**
     * Get whois with single domain if have another real whois server will be checking again real server
     * @return string $result
     */
    public function get_whois($domain)
    {
        $result = $this->get_the_whois( $domain );
        if ( is_string( $result ) && strpos( strtolower( $result ), 'whois server:') ) {
            if (preg_match("/whois server: (.*)/", strtolower( $result ), $matches ) && isset($matches[1])) {

                // check error
                $err = $this->has_error();

                $server = strpos( strtolower( $matches[1] ) , 'http://' ) === false ? trim( $matches[1],'/') : $matches[1] ; # fix slashed

                # secondary whois server exist
                if ($server) {
                    $res = $this->socket( $server, $domain );
                    if ( $res && $this->has_error() === false ) {

                        $result = $res;
                    } elseif ($result && $err === false) {

                        $this->error = false;
                        $result = $result;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Check availability domain
     * @return true if available
     */
    public function is_available($domain , $is_singlebulk = false)
    {
        $result         = $this->split_error( $domain, 'invalid_domain' );
        $this->error    = true;

        // added new method is_singlebulk determine as the single calling domain name and checking mass single name domain
        $allowextension = $is_singlebulk === true ? $this->allowextensionbulk() : $this->allowextension(); # fix false position

        if ( $this->domain_name_validation( $domain ) ) {
            $result = false;
            $extension = $this->split_extension( $domain );
            if ( in_array( $extension, $allowextension ) ) {

                $res = $this->get_the_whois( $domain );

                if ( $res && $this->has_error() === false ) {
                    // get whois match
                    $v = $this->get_whois_match( $extension );
                    # remove spaces & tab for more specific string to lower
                    $theresult  = strtolower( str_replace(
                                                        array(' ', "\t"),
                                                        '',
                                                        $res
                                                    )
                                                );
                    $thematch   = strtolower( str_replace(
                                                        array(' ', "\t"),
                                                        '',
                                                        $v
                                                    )
                                                );

                    $result     = stripos( $theresult , $thematch ) !== false ? true : false ; # use avail for returning;
                } else {

                    $result = $this->split_error( $domain, 'error_domain' );
                    $this->error = true;
                }

            } else {
                $result = $this->split_error( $domain, 'notallow_extension' );
                $this->error = true;
            }
        }

        return $result;
    }

    /**
     * Bulk check Available domain
     * @param  array $domain eg: array('domain.com','domain.net'......)
     * @param integer / numeric string maximal bulk available check uses set false to unlimited
     * @return array $check
     */
    public function bulk_available_check(array $domain, $max = false)
    {
        $check = array();
        if ( $max && is_numeric( $max ) && $max > 0 ) {
            $max = abs($max);
        } else {
            $max = false;
        }

        $check = array();
        $count = 1; # count from 1
        foreach ($domain as $domainname) {
            $check[$domainname] = $this->is_available( $domainname );
            if ($max && $count++ >= $max) {
                    break;
            }
        }

        return $check;
    }

    /**
     * Checking domain when use single domain name to checking bulk domain
     * single input as domain adn wuill be checked
     *
     * @param  string  $domain                just name of domain or full domain name , if use full domain name will be printed as extension first priority
     * @param  numeric $max                   as maximal count bulk domain check
     * @param  bool    $show_when_is_notallow if has not allowed domain will be shown another extension
     * @param  bool    $rand                  if has not extension defined use random extension to check , true if yes false is not
     * @return array   $check
     */
    public function bulk_available_single_check($domain , $max = 6 , $show_when_is_notallow = false, $rand = true)
    {
        $check = array(); # reset
        if ( $max && is_numeric( $max ) && $max > 0 ) {
            $max = abs($max);
        } else {
            $max = 6;
        }

        // if domain is array will be get it to bulk_available_check() function
        if ( is_array( $domain ) ) {
            return $this->bulk_available_check( $domain, $max );
        }

        // determine all available extension
        $allowextension = (array) $this->allowextensionbulk();

        // splitting domain name if is the full domain name
        $domainext      = $this->split_extension( $domain );
        $the_domainname = $domainext && $this->split_domain( $domain )
                        ? $this->split_domain( $domain ) : strtolower( (string) $domain );

        if ( $domainext && ! in_array( $domainext, $allowextension ) ) {
            $this->error = true;
            $check[$the_domainname.$domainext] = $this->split_error( $domain, 'notallow_extension' );
            // if no show when is not allow stop here
            if (! $show_when_is_notallow) {
                return $check;
            }
        }

        /**
         * if random is boolean identical true
         * and allow extension single bulk is same witj bulk extension
         * random the arrays
         */
        if ( $rand === true && $allowextension == $this->get_whois_available_extension() ) {
              /**
               * Randoming the array
               */
              $keys = array_keys($allowextension);
              shuffle($keys);
              $random = array();

              // create new array
              foreach ($keys as $key) {
                $random[$key] = $allowextension[$key];
              }

              $allowextension = array(); // emptying array
              // sorting the new key for random and determine new allow extension
              foreach ($random as $k => $v) {
                $allowextension[] = $v;
              }
        }

        $the_domain = array();
        foreach ($allowextension as $key => $extension) {
            if ( $domainext && $extension == strtolower( (string) $domainext ) ) {
                $the_domain[0] = $the_domainname.$extension; // sorting as 0 start of array
                continue;
            }
            $the_domain[] = $the_domainname.$extension;
        }

        $check = array();
        $count = 1; # count from 1
        foreach ($the_domain as $domainname) {
            $set = $this->is_available( $domainname );

            if ($this->error) {
                // ignore the error and do not prints
                $this->error = false;
                continue;
            }

            $check[$domainname] = $this->is_available( $domainname );
            if ($max && $count++ >= $max) {
                break;
            }
        }

        return $check;
    }
}
