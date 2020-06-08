<?php
define('WP_CACHE', false); // Added by WP Rocket
define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
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
define( 'DB_NAME', 'titandizajn_lasta' );

/** MySQL database username */
define( 'DB_USER', 'lasta' );

/** MySQL database password */
define( 'DB_PASSWORD', '1hU0&8bt' );

/** MySQL hostname */
define( 'DB_HOST', 'db1.paukhost.com:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '`%MNJGKPe|xxXQ_0[?oY`OE]h22?-yrB)uTMd4>|D{fWz4h4L::zItxh@+U6WDUc' );
define( 'SECURE_AUTH_KEY',  'u#a*D =?v Iqcq=XECp`!{MK=2_sG]2;.Ye1hPoAibHr^4D,)&(&!9]a!OSSb6##' );
define( 'LOGGED_IN_KEY',    'Wu-UIikJNM|}Fp=Gy@#tf.#),;BO(]!qZp>A4MAb[ip&7($>+km`Q_QBFx.jE-j]' );
define( 'NONCE_KEY',        '>lgONXfUc|;7L>P#/,TmU4.n/rsMYNdMB2liXj^[[)0S^9gDQxxqmw,!^SnN(`zE' );
define( 'AUTH_SALT',        'yW)$zh;nV_khc1>M!,eF541[i}w.+Ls;x&l?ADc4sb*(C*jHZ JaN^VC|T)yi^W7' );
define( 'SECURE_AUTH_SALT', '/fhyDj0#p=Tn6 S6(t|F]p8s`?<]3DZ4lWtfgyj}/Sax^:DgQT`H5kQ]qeHN-qCN' );
define( 'LOGGED_IN_SALT',   'RD!>X_%H }.6x!NWxSFGpNME#:#k:TowC1{$QkfvgV;bicN(O2hJkwC6xp[m{VZ`' );
define( 'NONCE_SALT',       '{O{?_[;jNI]thp4 Ac*KW|-?%ZXOs*e3U41LyRB2WJ5`Lm |L:}}g<m(uC6L-FT=' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ib1706wp_';

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
define( 'WP_DEBUG', false ); 

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
