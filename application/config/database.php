<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  | DATABASE CONNECTIVITY SETTINGS
  | -------------------------------------------------------------------
  | This file will contain the settings needed to access your database.
  |
  | For complete instructions please consult the 'Database Connection'
  | page of the User Guide.
  |
  | -------------------------------------------------------------------
  | EXPLANATION OF VARIABLES
  | -------------------------------------------------------------------
  |
  |	['hostname'] The hostname of your database server.
  |	['username'] The username used to connect to the database
  |	['password'] The password used to connect to the database
  |	['database'] The name of the database you want to connect to
  |	['dbdriver'] The database type. ie: mysql.  Currently supported:
  mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
  |	['dbprefix'] You can add an optional prefix, which will be added
  |				 to the table name when using the  Active Record class
  |	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
  |	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
  |	['cache_on'] TRUE/FALSE - Enables/disables query caching
  |	['cachedir'] The path to the folder where cache files should be stored
  |	['char_set'] The character set used in communicating with the database
  |	['dbcollat'] The character collation used in communicating with the database
  |				 NOTE: For MySQL and MySQLi databases, this setting is only used
  | 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
  |				 (and in table creation queries made with DB Forge).
  | 				 There is an incompatibility in PHP with mysql_real_escape_string() which
  | 				 can make your site vulnerable to SQL injection if you are using a
  | 				 multi-byte character set and are running versions lower than these.
  | 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
  |	['swap_pre'] A default table prefix that should be swapped with the dbprefix
  |	['autoinit'] Whether or not to automatically initialize the database.
  |	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
  |							- good for ensuring strict SQL while developing
  |
  | The $active_group variable lets you choose which connection group to
  | make active.  By default there is only one group (the 'default' group).
  |
  | The $active_record variables lets you determine whether or not to load
  | the active record class
 */

$active_group = 'default';
$active_record = TRUE;

$host = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.1.205)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = MPEPROD)))';

$db['default']['hostname'] = $host;
$db['default']['username'] = 'CNAB';
$db['default']['password'] = 'cnab';
$db['default']['database'] = '';
$db['default']['dbdriver'] = 'oci8';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;


$host2 = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 187.94.60.7)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = ORAINST3)))';

$db['rm']['hostname'] = $host2;
$db['rm']['username'] = 'USR_PRODUCAO_KKJNQQ';
$db['rm']['password'] = 'F3n8#21C';
$db['rm']['database'] = '';
$db['rm']['dbdriver'] = 'oci8';
$db['rm']['dbprefix'] = '';
$db['rm']['pconnect'] = TRUE;
$db['rm']['db_debug'] = TRUE;
$db['rm']['cache_on'] = FALSE;
$db['rm']['cachedir'] = '';
$db['rm']['char_set'] = 'utf8';
$db['rm']['dbcollat'] = 'utf8_general_ci';
$db['rm']['swap_pre'] = '';
$db['rm']['autoinit'] = TRUE;
$db['rm']['stricton'] = FALSE;

$host3 = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 187.94.60.7)(PORT = 1521))
    (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = ORAINST1)))';

$db['protheus']['hostname'] = $host3;
$db['protheus']['username'] = 'USR_PRODUCAO_9ZGXI5';
$db['protheus']['password'] = 'DbAr3m0t312';
$db['protheus']['database'] = '';
$db['protheus']['dbdriver'] = 'oci8';
$db['protheus']['dbprefix'] = '';
$db['protheus']['pconnect'] = TRUE;
$db['protheus']['db_debug'] = TRUE;
$db['protheus']['cache_on'] = FALSE;
$db['protheus']['cachedir'] = '';
$db['protheus']['char_set'] = 'utf8';
$db['protheus']['dbcollat'] = 'utf8_general_ci';
$db['protheus']['swap_pre'] = '';
$db['protheus']['autoinit'] = TRUE;
$db['protheus']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */