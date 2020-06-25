<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

//RazorPay Credentail
	//define('RAZOR_KEY_ID', 'rzp_test_QERx8gpLbfnHUB');
	//define('RAZOR_KEY_SECRET', 'SeR7TzYwVmCWplEaygwb9Hfd');
	
        //Test
         define('RAZOR_KEY_ID', 'rzp_test_wRpAs7qHBJJUlG');
         define('RAZOR_KEY_SECRET', 'FcCEADmc1gCu9Q1QED3seKLV');

        //Live
//	 define('RAZOR_KEY_ID', 'rzp_live_GhfJmsZOvw4Nf2');
//	 define('RAZOR_KEY_SECRET', 'kyMShMJS3pHTaYzSo6DcnVQg');

	
	//Blue Dart Credrential
	//define('LicenceKey','4ecbd06dc0b9737d69120029cb05c9df');
	//define('LoginID','BOM00001');
	//define('Version','1.3');
	//define('CustomerCode','099960');
        
	
    //-------------Testing-------------->
    define('Api_type','S');
    define('LicenceKey','shpfrizntrznsoenuinitepppenfhuun');
    define('LoginID','PNQ68152');
    define('Version','1.3');
    define('CustomerCode','053141');
        
    //-------------Live-------------->
//    define('Api_type','S');
//    define('TrackingKey','shpfrizntrznsoenuinitepppenfhuun');
//    define('LicenceKey','mjhtlhgjempe6omflfnooh0vhove7pvu');
//    define('LoginID','PNQ68152');
//    define('Version','1.3');
//    define('CustomerCode','053141');
        
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/*******************
 * File sizes and dimesions of file upload for products, categories, banner,
 * app-banner, web-banner
 */

/*** product parameters start */
define('PD_IMG_HT', 750);
define('PD_IMG_WT', 750);
define('PD_IMG_SIZE', 100);
/** product parameters end ***/

/*** category parameters start */
define('CAT_IMG_HT', 200);
define('CAT_IMG_WT', 200);
define('CAT_IMG_SIZE', 30);
/** category parameters end ***/

/*** category banner parameters start */
define('CAT_BANNER_HT', 184);
define('CAT_BANNER_WT', 1200);
define('CAT_BANNER_SIZE', 150);
/** category parameters end ***/

/*** mobile app banner parameters start */
define('APP_BANNER_HT', 400);
define('APP_BANNER_WT', 900);
define('APP_BANNER_SIZE', 150);
/** app banner parameters end ***/

/*** web banner parameters start */
define('WEB_IMG_HT', 400);
define('WEB_IMG_WT', 900);
define('WEB_IMG_SIZE', 150);
/** web banner parameters end ***/