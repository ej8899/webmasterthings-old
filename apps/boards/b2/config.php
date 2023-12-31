<?

/******************************************************************************\
 * Copyright (C) 2002 B Squared (b^2) by Josh Sherman <josh@cleancode.org>    *
 *                                                                            *
 * This script is generated by b^2 upon installing the sofware.  It is        *
 * recommended that you don't edit the file, but if you must, you must.  If   *
 * you wish to perform a clean install, either delete this file, or set the   *
 * global variable 'INSTALLED' to equal 'no'.                                 *
 *                                                                            *
 *                                 Last modified : September 25th, 2002 (JJS) *
\******************************************************************************/

/* Installation status */
define("INSTALLED", "yes");

if (INSTALLED == "yes")
  {
    /* Variables used by MySQL */
    define("DB_USER", $wtdb_user);
    define("DB_PASS", $wtdb_pass);
    define("DB_NAME", $wtdatabase);
    define("DB_HOST", $wtserver);

    /* Prefix for the tables in the database */
    define("TABLE_PREFIX", "wt_b2_");

    /* Toggle dummy error messages */
    define("ADMIN_ERRORS", "no");

    /* Notify admin on error? */
    define("NOTIFY_ADMIN", "yes");

    /* Administrator's email addy */
    define("ADMIN_EMAIL", "owner@webmasterthings.com");

    /* Define the language pack to use */
    define("LANGUAGE", "English");
  }

?>