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
defined('FILE_READ_MODE') OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
 */
defined('FOPEN_READ') OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('PROJECT_ENV')      OR define('PROJECT_ENV', 'DEV'); // enviroment senalizacion DEV/PROD

defined('PROJECT_NAME')   OR define('PROJECT_NAME', 'DFEED');
defined('DFEED_AMBIENTE') OR define('DFEED_AMBIENTE', PROJECT_ENV);

$project_env = PROJECT_ENV;
switch ($project_env) {
    case 'DEV':
        defined('DOMINIO_DINAMICO')           OR define('DOMINIO_DINAMICO', 'https://dfeed-cl-dev-ws.simpledatacorp.com');
        defined('APP_WS')                     OR define('APP_WS', DOMINIO_DINAMICO);
        defined('URL_IP_FORM_ENDPOINT_FORMS') OR define('URL_IP_FORM_ENDPOINT_FORMS', 'https://cl-ws-dev-dynamicform.simpledatacorp.com/?wsdl');
        defined('URL_INICIO')                 OR define('URL_INICIO', 'https://dfeed-cl-dev.simpledatacorp.com/');    // URL WEB
        defined('LIV_URL_GESTION')            OR define('LIV_URL_GESTION', 'http://liv-dev.simpledatacorp.com/liv/cl/v0.00.dfeed/liv/rest/core/livgestion');
        defined('URL_API')                 	  OR define('URL_API', 'http://api-dev-smartway.simpledatacorp.com/');    // URL API
        // Base de datos
        defined('USER_DB') OR define('USER_DB', 'prod_simpledata');
        defined('PASS_DB') OR define('PASS_DB', '4150_rhn');
        defined('HOST_DB') OR define('HOST_DB', 'localhost');
        defined('PORT_DB') OR define('PORT_DB', '3306');
        defined('SCHEMA_DB')              OR define('SCHEMA_DB', 'CL_DFEED_DINAMICFORMS');
        defined('SCHEMA_DB_SDM')          OR define('SCHEMA_DB_SDM', SCHEMA_DB);
        defined('DYNAMIC_FORMS')          OR define('DYNAMIC_FORMS', SCHEMA_DB);
        defined('SMARTWAY_telrad')        OR define('SMARTWAY_telrad', 'CL_DFEED_DEV');
        defined('SCHEMA_SMARTWAY_TELRAD') OR define('SCHEMA_SMARTWAY_TELRAD', SMARTWAY_telrad);
        defined('DYNAMIC_FORMS_MODULE')   OR define('DYNAMIC_FORMS_MODULE', 'dynamicForms');
	    defined('SCHEMA_DB_WDE')   OR define('SCHEMA_DB_WDE', 'CL_DFEED_WIFIDESIGN');
	    defined('URL_APP_WS_WDE')      OR define('URL_APP_WS_WDE', 'http://localhost/wifidesign/dfeed.cl/soap/v0.00/TDC.php?wsdl');

        break;
    case 'TEST':
    case 'QAS':
        defined('DOMINIO_DINAMICO')           OR define('DOMINIO_DINAMICO', 'https://dfeed-cl-qa-ws.simpledatacorp.com');
        defined('APP_WS')                     OR define('APP_WS', DOMINIO_DINAMICO);
        defined('URL_IP_FORM_ENDPOINT_FORMS') OR define('URL_IP_FORM_ENDPOINT_FORMS', 'https://cl-qas-dynamicform.simpledatacorp.com/?wsdl');
        defined('URL_INICIO')                 OR define('URL_INICIO', 'https://dfeed-cl-qa.simpledatacorp.com/');    // URL WEB
        defined('LIV_URL_GESTION')            OR define('LIV_URL_GESTION', 'http://liv-dev.simpledatacorp.com/liv/cl/v0.00.dfeed.qas/liv/rest/core/livgestion');
        defined('URL_API')                 	  OR define('URL_API', 'http://api-qas-smartway.simpledatacorp.com/');    // URL API 
        defined('URL_APP_WS_WDE')                 	  OR define('URL_APP_WS_WDE', 'http://localhost/wifidesign/dfeed.cl.qa/soap/v0.00/TDC.php?wsdl');
        // Base de datos
        defined('USER_DB') OR define('USER_DB', 'prod_simpledata');
        defined('PASS_DB') OR define('PASS_DB', '4150_rhn');
        defined('HOST_DB') OR define('HOST_DB', 'localhost');
        defined('PORT_DB') OR define('PORT_DB', '3306');
        defined('SCHEMA_DB')              OR define('SCHEMA_DB', 'CL_DFEED_DINAMICFORMS_QAS');
        defined('SCHEMA_DB_WDE ')         OR define('SCHEMA_DB_WDE', 'CL_DFEED_QA_WIFIDESIGN');
        defined('SCHEMA_DB_SDM')          OR define('SCHEMA_DB_SDM', SCHEMA_DB);
        defined('DYNAMIC_FORMS')          OR define('DYNAMIC_FORMS', SCHEMA_DB);
        defined('SMARTWAY_telrad')        OR define('SMARTWAY_telrad', 'CL_DFEED_QAS');
        defined('SCHEMA_SMARTWAY_TELRAD') OR define('SCHEMA_SMARTWAY_TELRAD', 'CL_DFEED_QAS');
        defined('DYNAMIC_FORMS_MODULE')   OR define('DYNAMIC_FORMS_MODULE', 'dynamicForms_qas');
	    defined('SCHEMA_DB_WDE')   OR define('SCHEMA_DB_WDE', 'CL_DFEED_WIFIDESIGN');
	    defined('URL_APP_WS_WDE')      OR define('URL_APP_WS_WDE', 'http://localhost/wifidesign/dfeed.cl/soap/v0.00/TDC.php?wsdl');

        break;
    case 'PROD':
        defined('DOMINIO_DINAMICO')           OR define('DOMINIO_DINAMICO', 'http://in-dfeedprdapp01/dfeed/soap/cl/v0.00');
        defined('APP_WS')                     OR define('APP_WS', DOMINIO_DINAMICO);
        defined('URL_IP_FORM_ENDPOINT_FORMS') OR define('URL_IP_FORM_ENDPOINT_FORMS', 'http://in-dfeedprdapp01/dfeed/dynamicForms/cl/soap/v0.00/?wsdl');
        defined('LIV_URL_GESTION')            OR define('LIV_URL_GESTION', 'http://liv.simpledatacorp.com/liv/cl/v0.00.dfeed/liv/rest/core/livgestion');
        defined('URL_API')                 	  OR define('URL_API', 'http://in-dfeedprdapp01/dfeed/rest/cl/v1.prod/');    // URL API
        defined('URL_INICIO')                 OR define('URL_INICIO', 'https://cl-dfeed.simpledatacorp.com/');    // URL WEB
	    defined('URL_APP_WS_WDE')                 	  OR define('URL_APP_WS_WDE', 'http://in-dfeedprdapp01/wifidesign/dfeed.cl/soap/v0.00/TDC.php?wsdl');

        
        // Base de datos
        defined('USER_DB') OR define('USER_DB', 'dfeedprod');
        defined('PASS_DB') OR define('PASS_DB', '#sdcdfeedprod#');
        defined('HOST_DB') OR define('HOST_DB', 'in-dfeed-bbdd');
        defined('PORT_DB') OR define('PORT_DB', '3306');
        defined('SCHEMA_DB')              OR define('SCHEMA_DB', 'CL_DFEED_DINAMICFORMS');
        defined('SCHEMA_DB_WDE ')         OR define('SCHEMA_DB_WDE', 'CL_DFEED_WIFIDESIGNENTERPRISE');
        defined('SCHEMA_DB_SDM')          OR define('SCHEMA_DB_SDM', SCHEMA_DB);
        defined('DYNAMIC_FORMS')          OR define('DYNAMIC_FORMS', 'dynamicForms_dfeed');
        defined('SMARTWAY_telrad')        OR define('SMARTWAY_telrad', 'CL_DFEED');
        defined('SCHEMA_SMARTWAY_TELRAD') OR define('SCHEMA_SMARTWAY_TELRAD', 'CL_DFEED');
        defined('DYNAMIC_FORMS_MODULE')   OR define('DYNAMIC_FORMS_MODULE', 'dynamicForms_dfeed');
	    defined('SCHEMA_DB_WDE')   OR define('SCHEMA_DB_WDE', 'CL_DFEED_WIFIDESIGN');
	    defined('URL_APP_WS_WDE')      OR define('URL_APP_WS_WDE', 'http://localhost/wifidesign/dfeed.cl/soap/v0.00/TDC.php?wsdl');

        break;

    default:
        break;
}

defined('URL_IP_FORM_ENPOINT')   OR define('URL_IP_FORM_ENPOINT', DOMINIO_DINAMICO . '/TDC.php?wsdl');
defined('URL_IP_FORM_ENPOINT2')  OR define('URL_IP_FORM_ENPOINT2', URL_IP_FORM_ENPOINT);
defined('URL_IP_FORM_ENDPOINT4') OR define('URL_IP_FORM_ENDPOINT4', URL_IP_FORM_ENPOINT);
defined('URL_APP_WS')            OR define('URL_APP_WS', APP_WS . "/TDC.php?wsdl");
defined('URL_DASHBOARD_DFEED_RETIROS')   OR define('URL_DASHBOARD_DFEED_RETIROS', "https://dashboard.simpledatacorp.com/dfeed.html?embedded&section=dfeed");
defined('URL_DASHBOARD_DFEED_INSTALACIONES')   OR define('URL_DASHBOARD_DFEED_INSTALACIONES', "https://dashboard.simpledatacorp.com/dfeedInstalaciones.html?embedded&section=dfeedInstalaciones");
defined('URL_DASHBOARD_DFEED_ENTREGAS')   OR define('URL_DASHBOARD_DFEED_ENTREGAS', "https://dashboard.simpledatacorp.com/dfeedEntregas.html?embedded&section=dfeedEntregas");

//IMAGENES DE WIFI DESIGN
define('URL_HEATMAP', DOMINIO_DINAMICO . '/images/fotosWifiDesign/');

defined('DIRECTORIO_UPLOAD')   OR define('DIRECTORIO_UPLOAD', INTERFACE_HOME_PATH);

define('STATUSABIERTO', '1'); //Abierto
define('STATUSRECEIVED', '2'); //Recibido
define('STATUSINPROGRESS', '3'); //En Progeso
define('STATUSONSITE', '4'); //En el lugar
define('STATUSRESOLVED', '5'); //Resuelto
define('STATUSCLOSE', '6'); //Cerrado
define('STATUSPOSTPONE', '7'); //Pospuesto
define('STATUSSUSPENDED', '8'); //Suspendido
define('STATUSCANCEL', '9'); //Cancelado
define('STATUSCLOSEPARTIAL', '10'); //Cerrado Parcial
define('STATUSASIGN', '11'); //Asignado
define('STATUSVISUALIZED', '12'); //Visualizado
define('STATUSONROUTE', '13'); //En Camino al cliente
define('STATUSREASIGN', '14'); //Reasignado
define('DOMINIO_DINAMICO_MC', DOMINIO_DINAMICO);
//CONSTANTES RETIRO

// Estatus de viaje
define('STATUS_JOUR_EN_VIAJE', '2'); // En viaje
define('STATUS_JOUR_FIN_VIAJE', '4'); // Fin de viaje

define('ID_STOCK_PROV', 5);
define('LOTE_RETIRO_PROV', 5);
define('IDBRAND_NOBRAND', 26);
define('IDMODEL_NOMODEL', 54);
define('ID_STOCK_SIMPLEDATA', 2);
define('ID_STOCK_TELEFONICA', 1);

// SKILL
define('DFEED_SKILL_ID_INSTALL_REP', 1);
define('DFEED_SKILL_ID_INSTALL_DECO', 2);
define('DFEED_SKILL_ID_RETIRED', 3);

////////////////////////////////////////////////////////////////////////////////
define('URL_CAPSULA', '/CARPETA_CONTENEDORA/CARPETA_CAPSULAS/'); // URL DE LAS CÁPSULAS
define('URL_MANUAL', '/CARPETA_CONTENEDORA/CARPETA_MANUALES/'); // URL DE LAS CÁPSULAS
define('LOAD_GIF', DOMINIO_DINAMICO . '/toolbox/pe/portal/v0.01/loadGif/loading.gif');
define('DIRECTORIO_CAPSULA', DIRECTORIO_UPLOAD . '/CARPETA_CONTENEDORA/CARPETA_CAPSULAS/'); // URL DE LAS CAPSULAS
define('DIRECTORIO_MANUAL', DIRECTORIO_UPLOAD  . '/CARPETA_CONTENEDORA/CARPETA_MANUALES/'); // URL DE LOS MANUALES
define('PAGINADO_CANT', '10');
define('CSV_DIR', DOMINIO_DINAMICO . '/files/usability/');
define('URL_IP', DOMINIO_DINAMICO . '/TDC.php?wsdl'); // IP de servicios para Bandeja Comercial

define('DYNAMIC_FORM_IMG_PATH', '/images/dynamicforms/');
define('CURLOPT_URL_MQ_NOTIF', 'http://10.186.241.15:15672/api/exchanges/%2f/amq.default/publish');
define('AUTHORIZATION_MQ_NOTIF', 'YWRtaW46anU3eWh0ZzV0cnQ=');

define('SESSION_LOST_CODE', 5);
define('SESSION_LOST_DESCRIPTION', 'Sesion Caducada');
//GOOGLE API

//define('API_KEY_GOOGLE', 'AIzaSyCR14gt8h_06gR-rT5xz87jRvodZpDhkRc');
//define('API_KEY_GOOGLE', 'AIzaSyCyJLX4Wqk46nxHc5Juv1kdzVYFLSGbO3M');
define('API_KEY_GOOGLE', 'AIzaSyBKfU9K0g7CvAxBm7aqDsq0bNVdCHe3r8M');
define('GOOGLE_API', 'https://maps.googleapis.com/maps/api/js?key=' . API_KEY_GOOGLE . '&libraries=places,visualization,drawing sync defer');

// TIMES DFEED
define('TIME_START_AM', '08:00:00');
define('TIME_END_AM', '12:00:00');
define('TIME_START_PM', '12:00:01');
define('TIME_END_PM', '19:00:00');
//MANUALES
//define('URL_CAPSULA', URL_INICIO . 'CARPETA_CONTENEDORA/CARPETA_CAPSULAS/'); // URL DE LAS CÁPSULAS
//define('URL_MANUAL', URL_INICIO . 'CARPETA_CONTENEDORA/CARPETA_MANUALES/'); // URL DE LAS CÁPSULAS
