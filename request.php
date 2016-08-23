<?php
/**
 * Example used as php ajax request
 * this is stand alone script to clled from another form script / page
 * or use as put with checking domain
 * this scripts is also to use as documentation about domain check methods
 */

// checking available files
if( !is_readable('extending.whoisdomain.php') ) {
    die('file extending.whoisdomain.php could not read !!');
} # -- if  readable continue

// require_once the extends class -- 
require_once 'extending.whoisdomain.php'; # call extend scripts example

/**
 * Callback
 */
$cachedir = dirname(__FILE__).'/cachedir'; # determine cache directory
$usecache = true; # set true if use cache
$class    = new extendSimpleWhoisDomain( $usecache, $cachedir ); // new class and use cache also determine cache directory

/**
 * set cache expires by default on class we use 1 hour or 3600 in seconds
 */
$cacheexpire = 3600; # determine cache expiration in seconds
$class->cacheexpire = $cacheexpire;

/**
 * set by commas '.com,.net,.org'
 * is for allowed extension to check
 * leave empty to allowed all available 
 */
$allowextension  = ''; # allowed extension to check domain availibility  separate by comma
$class->allowextension = $allowextension;

/**
 * set by commas '.com,.net,.org'
 * is for allowed extension to check whois
 * leave empty to allowed all available 
 */
$allowextensionwhois  = ''; # allowed extension to check domain whois separate by comma
$class->allowextensionwhois  = $allowextensionwhois ;

/**
 * set by commas '.com,.net,.org'
 * is for allowed extension to check whois
 * leave empty to allowed all available
 * but define to max count to execute request for mass bulk domain name available check 
 * // $allowextensionbulk = '.com,.net,.co,.us,.org,.info,.ma';
 */

$allowextensionbulk   = ''; # allowed extension to check domain whois separate by comma, first extension as priorities
$class->allowextensionbulk  = $allowextensionbulk;

/**
 * determine about error domain checking for classes
 */
$invalid_domain     = 'Invalid domain name : %domain%.';
$unsupport_domain   = 'Domain: %domain% is not supported.';    
$error_domain       = 'there\'s was an error when checking domain: %domain%.';    
$notallow_extension = 'Domain extension %extension% is not allowed for %domain%.';

/**
 * Set the variables
 */
$class->invalid_domain      = $invalid_domain;
$class->unsupport_domain    = $unsupport_domain;
$class->error_domain        = $error_domain;
$class->notallow_extension  = $notallow_extension;

/**
 * Set regex with custom regex.
 * you could use another characters eg: unicode character with function logic eg :
 * if ( $extension === 'jp' ) $regex = 'yourregex'
 */
$regex = '/^([-a-z0-9]{2,100})\.([a-z\.]{2,12})$/i'; // default regex
$class->set_regex_domain( $regex ); # set the regex

/**
 * determine request post
 * if have post
 */
if( isset( $_POST['domain'] ) ) {
    
    $error = false; # reset error variable as false
    // if  post domain empty
    if( $_POST['domain'] == '' ) {
        $error .= 'Domain name could not be empty';
    } else { # else if not empty
        // define array request method
        $requestmethod = array( 'single', 'whois', 'bulkcheck', 'masscheck', 'bulkcheckbox');
        
        // just use small trick to avoid unavailable request checking
        if( ! isset( $_POST['request'] ) 
            || isset( $_POST['request'] ) && ! in_array( $_POST['request'], $requestmethod ) )
        { 
            $error .= 'Invalid method use!'; 
        }

    }
    
    // if some has error print the error
    if( $error ) {

        echo "<p class=\"errordomain alert alert-danger\">{$error}</p>";

    // if no error
    } else { 
        
        /**
         * if request single
         */
        if( $_POST['request'] == 'single' ) {
            $checksingle = $class->is_available( $_POST['domain'] );
            
            $extension  = $class->split_extension( $_POST['domain'] ); # get just extension
            $domainname = $class->split_domain( $_POST['domain'] );    # get just name of domain
            
            // example usage with link
            if( $checksingle === true ) { # identical true if available
                
                /**
                 * This method is use bootstrap 3
                 */
                echo "<p class=\"availabledomain alert alert-success\">
                <span class=\"pull-left\">
                    {$domainname}{$extension}
                </span>
                <span class=\"pull-right\">
                    Available <a data-toggle=\"tooltip\" title=\"order {$domainname}{$extension} \" data-placement=\"left\" href=https://web2get.nl/offerte.html><i class=\"glyphicon glyphicon-shopping-cart\"></i></a>
                </span>
                <span class=\"clearfix\"></span>
                </p>";

            } else {
                if( $checksingle === false ) { # identical false if unavailable
                    echo "<p class=\"unavailabledomain alert alert-warning\">{$domainname}{$extension} is registered.</p>";
                } else { # if not false or  or true will be error then return the $checksingle output
                    echo "<p class=\"errordomain alert alert-danger\">{$checksingle}</p>";
                }
            }
        } # end single

        /**
         * if request whois
         */
        if( $_POST['request'] == 'whois' ) {

            // you could validate domain name ,
            if( $class->domain_name_validation( $_POST['domain'] )  === true ) { // if valid
                
                $whois = $class->get_whois( $_POST['domain'] );
                
                // check if has no error
                if( $class->has_error() === false ) {
                    /**
                     * this is returning of success check
                     * and we could to negotiate about the recheck available domainname
                     * because we use cache ,, so dont worry about recheck to the server becasue we have cache files
                     * use this if you know what youll do 
                     * or just use some trick eg: if( in_array($extensionhascheck, $yourarrayextensiontocheck ) && $class->is_available( $thedomain ))  the do below
                     */


                    // if ( $class->is_available( $_POST['domain'] ) === true ) {                    
                    //     $extension  = $class->split_extension( $_POST['domain'] ); # get just extension
                    //     $domainname = $class->split_domain( $_POST['domain'] );    # get just name of domain                        
                    //     /**
                    //      * This method is use bootstrap 3
                    //      */
                    //     echo "<p class=\"availabledomain alert alert-success\">
                    //     <span class=\"pull-left\">
                    //         {$domainname}{$extension}
                    //     </span>
                    //     <span class=\"pull-right\">
                    //         is not registered  <a data-toggle=\"tooltip\" title=\"order {$domainname}{$extension} \" data-placement=\"left\" href=\"?domain={$domainname}&amp;ext={$extension}\"><i class=\"glyphicon glyphicon-shopping-cart\"></i></a>
                    //     </span>
                    //     <span class=\"clearfix\"></span>
                    //     </p>";
                    
                    // } else { # and then if has been registered show the whois
                        echo "<pre class=\"whois\">{$whois}</pre>";
                    // }

                } else {
                    echo "<p class=\"errordomain alert alert-danger\">There was an error while getting information of whois.<br /> {$whois}</p>";
                }

            // else if not valid domain name
            } else {
                echo "<p class=\"errordomain alert alert-danger\">Invalid Domain name: ".$_POST['domain']." </p>";
            }
            
        } # end whois

        /**
         * if bulk check
         */
        if( $_POST['request'] == 'bulkcheck' ) {
            
            /**
             * as you know output of bulk check is an array, so you must split the array
             * $result = array('domainame' => ,)
             */

            /**
             * You must split the commas to make the post bulk as array
             * @uses domain_splitbycomma( thedomainbulk );
             * @return array 
             */
            $domain = $class->domain_splitbycomma( $_POST['domain'] );
            $max = 6; // set to 6 maximal bulk check set to false is you want unlimited

            /**
             * Checking the domain with bulk
             */
            $bulk = $class->bulk_available_check( $domain, $max );

            $result = ''; // reset
            foreach( $bulk as $key => $theresultbulk ) {                
                if( $theresultbulk === true ) {

                    // check if available
                    $extension  = $class->split_extension( $key ); # get just extension
                    $domainname = $class->split_domain( $key );    # get just name of domain
                    $result    .= 
                    
                    /**
                    * This method is use bootstrap 3
                    */
                    "<p class=\"availabledomain alert alert-success\">
                    <span class=\"pull-left\">
                        {$domainname}{$extension}
                    </span>
                    <span class=\"pull-right\">
                        Available <a data-toggle=\"tooltip\" title=\"order {$domainname}{$extension} \" data-placement=\"left\" href=\"?domain={$domainname}&amp;ext={$extension}\"><i class=\"glyphicon glyphicon-shopping-cart\"></i></a>
                    </span>
                    <span class=\"clearfix\"></span>
                    </p>";

                } elseif( empty( $theresultbulk ) ) {
                    $result    .= "<p class=\"unavailabledomain alert alert-warning\">{$key} is registered.</p>";
                } else {
                    /**
                     * this is optionals but i recommended to avoid error check 
                     */
                    $result     .= "<p class=\"errordomain alert alert-danger\">{$theresultbulk}</p>";
                }

            } # endforeach

            // check again the result if empty , so the value has error input
            $result = $result !== '' ? $result : "<p class=\"errordomain alert alert-danger\">Thre's was error where executing your request. Please try again later.</p>";

            // print the result
            echo $result;

        } # end bulkcheck

        /**
         * if mass single check
         */
        if( $_POST['request'] == 'masscheck' ) {

            $domain = $_POST['domain'];
            /**
             * Checking the domain with bulk
             */
            $max  = 6; // set max domain to checked
            $show_when_is_notallow = false; // allowed if extension check not allowed
            $rand = true; // set random is true if $allowextensionbulk is empty or not define 
            $bulk = $class->bulk_available_single_check( $domain , $max , $show_when_is_notallow, $rand );

            $result = ''; // reset
            foreach( $bulk as $key => $theresultbulk ) {                
                if( $theresultbulk === true ) {

                    // check if available
                    $extension  = $class->split_extension( $key ); # get just extension
                    $domainname = $class->split_domain( $key );    # get just name of domain
                    $result    .= 
                    
                    /**
                    * This method is use bootstrap 3
                    */
                    "<p class=\"availabledomain alert alert-success\">
                    <span class=\"pull-left\">
                        {$domainname}{$extension}
                    </span>
                    <span class=\"pull-right\">
                        Available <a data-toggle=\"tooltip\" title=\"order {$domainname}{$extension} \" data-placement=\"left\" href=\"?domain={$domainname}&amp;ext={$extension}\"><i class=\"glyphicon glyphicon-shopping-cart\"></i></a>
                    </span>
                    <span class=\"clearfix\"></span>
                    </p>";

                } elseif( empty( $theresultbulk ) ) {
                    $result    .= "<p class=\"unavailabledomain alert alert-warning\">{$key} is registered.</p>";
                } else {
                    /**
                     * this is optionals but i recommended to avoid error check 
                     */
                    $result     .= "<p class=\"errordomain alert alert-danger\">{$theresultbulk}</p>";
                }

            } # endforeach

            // check again the result if empty , so the value has error input
            $result = $result !== '' ? $result : "<p class=\"errordomain alert alert-danger\">Thre's was error where executing your request. Please try again later.</p>";

            // print the result
            echo $result;
        }

        /**
         * if mass checkbox check
         */
        if( $_POST['request'] == 'bulkcheckbox' ) {

            $max    = false; // set max for false , prevent set max 
            $domain = $_POST['domain'];
            $ext    = isset( $_POST['ext']) && ! empty( $_POST['ext'] ) ? $_POST['ext'] :false;
            
            // split just take the domain name check it as match, check with strpos if has . / dot
            $domain = strpos($domain, '.' ) === true ? $class->split_domain( $domain ) : $domain;
            
            // if extension is not empty -- continue
            if( $ext !== false ) {

                $result = ''; // just reset
                // check result if extenison is array
                if( is_array( $ext ) ) {
                    $newdomain = array();
                    // split and create new domain
                    foreach ( $ext as $key => $value ) {
                        $newdomain[] = $domain.$value; // domain name + extension
                    }

                    $bulk = $class->bulk_available_check( $newdomain, $max ); // check it

                    foreach( $bulk as $key => $theresultbulk ) {
                        if( $theresultbulk === true ) {

                            // check if available
                            $extension  = $class->split_extension( $key ); # get just extension
                            $domainname = $class->split_domain( $key );    # get just name of domain
                            $result    .= 
                            
                            /**
                            * This method is use bootstrap 3
                            */
                            "<p class=\"availabledomain alert alert-success\">
                            <span class=\"pull-left\">
                                {$domainname}{$extension}
                            </span>
                            <span class=\"pull-right\">
                                Available <a data-toggle=\"tooltip\" title=\"order {$domainname}{$extension} \" data-placement=\"left\" href=\"?domain={$domainname}&amp;ext={$extension}\"><i class=\"glyphicon glyphicon-shopping-cart\"></i></a>
                            </span>
                            <span class=\"clearfix\"></span>
                            </p>";

                        } elseif( empty( $theresultbulk ) ) {
                            $result    .= "<p class=\"unavailabledomain alert alert-warning\">{$key} is registered.</p>";
                        } else {
                            /**
                             * this is optionals but i recommended to avoid error check 
                             */
                            $result     .= "<p class=\"errordomain alert alert-danger\">{$theresultbulk}</p>";
                        }

                    } # endforeach
                } else {
                    $result = "<p class=\"errordomain alert alert-danger\">Invalid extension detected.</p>";
                }

            }  else {
                $result = "<p class=\"errordomain alert alert-danger\">Please choose domain extension.</p>";
            }
            // print result
            echo $result;
        }

    } # end else if no error

} else {

    /**
     * if no post domain
     */
    // echo "<p class=\"errordomain\">No request accepted!</p>";
}