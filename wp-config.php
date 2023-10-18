<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kovin' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Ce2,i[g]mQ.8w~aQX{UgVf3AXI%{Djg9:GU~%}B3j^:~y1EBY;67kO7@0;-C1xAS' );
define( 'SECURE_AUTH_KEY',  '{ZLK}MLD(a&:cG^l]R%RGSk?hEt)ItP~E sy{=j$2+}@UMU=c^*<y&y7d~;PId/I' );
define( 'LOGGED_IN_KEY',    'hxhwbYw09|6?JpJ(WJ2OdrauATW[AnAsw|/dX4qeyoI;rW5Y)@us3o(BD#4-Fpzh' );
define( 'NONCE_KEY',        ':f^/py #,L@&94;;Nu)J+ZE$e1ToZEcV9pLFR:=NB+309:gk=!#Kw`[{ mKmamDP' );
define( 'AUTH_SALT',        'zaYFN@b:A?A7lW6!=}=:%b<rK[_h3^_fYGG=]6i=_Yrj;#BkxoOMN9&iX`H?$#3M' );
define( 'SECURE_AUTH_SALT', 'CgFseq>*SBnPPaIMTm^tHrw|vX{P*;}*2/Pz>Ep2 HKBO|~{DSW~9eAy^QTvVE%=' );
define( 'LOGGED_IN_SALT',   'eoZ%dH3=zz?,2,8yrY5BY|E.ziY_g1bvF,m-(b6|9sCH5M&|<wN&szV4&!BjT=l<' );
define( 'NONCE_SALT',       '[l%PLHYdI26T=Kzjw@Fn51g0/+vY,F$-+<f$qJ~H&5-QaA)qOE?X]sKr#)jJ).tO' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
