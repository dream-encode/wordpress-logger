<?php
namespace DE_WordPress;

/**
 * Basic logger for WordPress
 *
 * @link       https://dream-encode.com
 * @since      1.0.0
 *
 * @package    DE_WordPress\Logger
 * @author     David B <david@dream-encode.com>
 */

class Logger {
    /**
     * Current log file
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $file    Current log file
     */
    public $file;

    /**
     * Constructor
     *
     * @since    1.0.0
     */
    public function __construct() {
        $default_log_file = plugin_dir_path( __FILE__ ).'debug.log';

        if ( is_string( WP_DEBUG_LOG ) ) {
            $default_log_file = WP_DEBUG_LOG;
        }

        $this->set_file( apply_filters( 'de/wordpress-logger/log-file', $default_log_file ) );
    }

    /**
     * Set custom log file location.
     *
     * @param string $file Full file path of log file.
     *
     * @since    1.0.0
     */
    public function set_file( $file ) {
        $this->file = $file;
    }

    /**
     * Write to log file.
     *
     * @param mixed $value Data to be logged.
     *
     * @since    1.0.0
     */
    public static function write( $value ) {
        if ( WP_DEBUG ) {
            if ( is_array( $value ) || is_object( $value ) ) {
                error_log( print_r( $value, true ), 3, self::file );
            } else {
                error_log( $value, 3, self::file );
            }
        }
    }

    /**
     * Output log content at runtime
     *
     * @param mixed $value Data to be logged.
     * @param bool  $exit  Indicates whether current execution should be stooped after logging.
     *
     * @since    1.0.0
     */
    public static function output( $value, bool $exit = false ) {
        echo sprintf( '<pre %1$s>', is_admin() ? 'style="margin-left: 180px;"' : '' );

        if ( is_array( $value ) || is_object( $value ) ) {
            print_r( $value );
        } else {
            echo $value;
        }

        echo '</pre>';

        if ( $exit ) {
            wp_die();
        }
    }
}
