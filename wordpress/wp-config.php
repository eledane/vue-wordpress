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
define('DB_NAME', 'vue_wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'a');

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
define('AUTH_KEY',         '%cqJ)L#8o^w(|[^/[8H+VcGUI#t/r(ILoEUbC[M` ,R<M<yu6uPXSMXC-4NLc=nd');
define('SECURE_AUTH_KEY',  '=U8 mLYp+|JM#S*,eXp(.F51akg.xKSyO4@YB[&(-Ag,@M+sMQ*Yo*+Vt0Eifa+n');
define('LOGGED_IN_KEY',    'r/D#XW^g&5|!?U*)!WV~)z##rWE QecVw;(?zxQl]3nfVEGq?SJMz1NiLcR7e Y$');
define('NONCE_KEY',        'r$hc{%JAD`w|5&?}Qx$f!E8JWy33ZU44MBib/%P=mYy CPN&TC+A1=V1<KoFVIDS');
define('AUTH_SALT',        '.T9&WH, pkKI-ifD[3EH?bJ!LFvt7v)ln3Z]RC$!.uDa{JB]gSdPL<=r.Ct~Uw|k');
define('SECURE_AUTH_SALT', 'BC/Y9O25L%u?pO/r#(h5FFncy`.R([%DFi!KS OC8k[[]<n##iIaf>#{--c3p$Gg');
define('LOGGED_IN_SALT',   'G3e;.@?XE+0lQ_d]}xl|2d=1>GB.)e?eh):Et W;]W17]cRIv^i{D_d8V2531+QT');
define('NONCE_SALT',       'o+@!1NZg]<-%zzafhD<$chayC$K=c88i0FLeJB@N.Md0Jc/[Hh<_BWecUMI:J-9N');

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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
