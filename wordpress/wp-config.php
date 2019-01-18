<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sellingsumo_main');

/** MySQL database username */
define('DB_USER', 'sellingsumo_main');

/** MySQL database password */
define('DB_PASSWORD', 'UxCCC(lFl]sn');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'l[Bm%pZUrJ}LG=^EFOOR#YhLL?$ Ct=w.M9?8H{#^)Gn-P]jWF%^O$>^(8K&b,V+');
define('SECURE_AUTH_KEY',  '_39fK2o~k;qIV|doaY->n}sO;paE+F@9WLHp(~Z0xakp3;%2l|B-#,KeEJG0sW*F');
define('LOGGED_IN_KEY',    'Dw,Iz)[zf9kK8_/gztY*3l96JB$FRg!eK~P0}cIe;wRigN[o=o y4rhKj+yo.Jb/');
define('NONCE_KEY',        'hNuPp(z:pn5IOc8@Q(/f-&i`oC;H?r[mL-VOrIs<`8u?UasZXf[PGAMj}4i%/O&%');
define('AUTH_SALT',        'tz~vLWW==A PK2^E~tff}hFCf-}ygGcb%2-hxoaC[IX~91|ANu%*hdtM}FQJG,o^');
define('SECURE_AUTH_SALT', 'rfG?b#8,}}RWS^)cS{4O&YkEPRTsSEuwTeQjLP3AR!*4=4H$MCB}87V]![F9bQy|');
define('LOGGED_IN_SALT',   'aQ@ %J%?fW.R$cF~csttrWqM+9XbrhqDe?|$^R@i4ERz&LH2(}DG!Q|rc(z#>Zgk');
define('NONCE_SALT',       'o%t[!uhIrA`7._-+%oC#.?QMEP{d}x>oL~f^BfBNV6JN=P^6Ccer2M/r[rdf*n<U');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
