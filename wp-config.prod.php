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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'epiz_27205060_preditcheck' );

/** MySQL database username */
define( 'DB_USER', 'epiz_27205060' );

/** MySQL database password */
define( 'DB_PASSWORD', '0k289wFjwp' );

/** MySQL hostname */
define( 'DB_HOST', 'sql209.epizy.com' );

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
define( 'AUTH_KEY',         'u7!GzdH%=2E,xFShEQ*$6TP*x|:Ep-sI@rg5^=wTt,;Z@]:&s5Z3bG^ATlG#$C%~' );
define( 'SECURE_AUTH_KEY',  'I_0jZ_?O|zN~)Vo@}M.?`:x9~l)h!?&t;5,=d2c.d(VJ;o??G}Hh;cN*0Qv6A~3b' );
define( 'LOGGED_IN_KEY',    'W]^g ;;*FxBpHJK5Z=i7_:.w!:Qz%TpV =81C C-$$9&6+(YoDn4o8=m|/fAh+U;' );
define( 'NONCE_KEY',        ',WI2oh,RfmyN.fBpJ|&qh:8=RNVlHY6;Bx3jku2Z;1>:+^G{m?d|6SQDYzNxDQ#a' );
define( 'AUTH_SALT',        '3/D.,JxT{HZ:f%st}g@]Inz;98f6*<m,RO55VPR@J:D1Y;Aq5w1=;@XA0{p{)-Mh' );
define( 'SECURE_AUTH_SALT', '01TQH9.Y|AEG?}I!$U!fTENV]OMS~FPdDd>qKYyeRt|4UNUf}PxtZ1edUkt=Ww< ' );
define( 'LOGGED_IN_SALT',   'HI40L%NU,Bi>Fa+aHU)HSY`owc/hh=O)nc!c|;F*kAk::paUy:9=#luU)MxoAX4p' );
define( 'NONCE_SALT',       '88eI.vThT=;{7g1-}(X)/[Q QgWm#VC.5Dsf*1zKG&U8k6=~4)`9e+c{(Sw:X^@g' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'preditcheck_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
