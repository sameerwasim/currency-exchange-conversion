<?php

/* APP SESSION STARTED */
session_start();

/* App Enviorment -
  Choose development if app is under development
  Choose deployed if app is under deployed
*/
define('ENVIORMENT', 'development');
// App Details
define('appName', 'ConversionAPI');
define('appVersion', '0.0.1');

/* App ENVIORMENT depended constants -
  Put development variable in the if condition
  put deployed variable in the else condition
*/
if (ENVIORMENT == 'development') {
  define('appURL', 'http://localhost/conversion-api/'); # App Domain
  define('appAdminURL', ''); # App Domain
  // Database Details
  define('dbHOST', 'localhost');
  define('dbUSERNAME', 'root');
  define('dbPASSWORD', '');
  define('database', 'conversion');
} else {
  define('appURL', ''); # App Domain
  define('appAdminURL', ''); # App Domain
  // Database Details
  define('dbHOST', 'localhost');
  define('dbUSERNAME', '');
  define('dbPASSWORD', '');
  define('database', 'conversion');
}

/* Email Details -
  Enter here the email and its password
  which you want to be used through out
  the entire Web App.
*/
define('Email', '');
define('EmailPass', '');

/* App Functions -
  App functions gonna be used in the project.
*/
// Used to add files to project with website links
function baseUrl($path='', $admin=false) {
  if ($admin == true)
    echo strtolower(str_replace(' ', '-', appAdminURL.$path));
  else
  echo strtolower(str_replace(' ', '-', appURL.$path));
}