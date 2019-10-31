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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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

define('SECURE_AUTH_KEY',  'YfH(lb*UN>Y9;f{K>F6, .(IY6<@q`:FW%+Z#+)8vpG[rI>nuy~ ;Ho+-k)7F9x7');
define('LOGGED_IN_KEY',    'V`X5Vsz0 ,Q_K0)Mj<*h6zP2_}S::(a(H$k1^#!Np6VdaS#fL.31.9<I*JST|cnS');
define('NONCE_KEY',        '])40?):8ToXyS@,=75xhaFA,:/GA4JV)0;tT|L7P$-FF~WXw|wjP9I>!$FRL`Z8[');
define('AUTH_SALT',        '|bKpBrJLg, 6QFlhG()QgSk:P|+t$_=@?-],TBNu`@*P+`HT!K1|0,$=|/=uuu+M');
define('SECURE_AUTH_SALT', 'nbUAp/+*>~,W:cF5*hf4@]r#2ms^;atE@@^gi5= UO+m|Jo*|M+c|dc@u$L.FG{>');
define('LOGGED_IN_SALT',   '|nf1k ,cokAUkf3+<d[]wg_n?+W-Mmiw#ewOSHj|PAjR{EIe%1|V6>r#Y0q]hJZu');
define('NONCE_SALT',       'JUZpK]pwfcoG;<=G||BMqN.(qzV@-xzr>gTmw8x1BP!E-%+=e).Yl:5fJk<V9X2R');

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

define('WP_HOME','https://oneheart.gq');
define('WP_SITEURL','https://oneheart.gq');
@ini_set('upload_max_size' , '256M' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
