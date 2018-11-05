<?php
namespace DE_WordPress;

/**
 * Basic logger for WordPress
 *
 * @link       https://dream-encode.com
 * @since      1.0.0
 *
 * @package    DE_WordPress_Logger
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

        $this->set_file( apply_filters( 'de/wordpress-logger/log-file', plugin_dir_path( __FILE__ ).'debug.log' ) );

    }

    /**
     * Set custom log file location.
     * 
     * @param string
     *
     * @since    1.0.0
     */
    public function set_file( $file ) {
        $this->file = $file;
    }

    /**
     * Write to log file.
     *
     * @param mixed
     *
     * @since    1.0.0
     */
    public static function write( $value ) {
        if ( WP_DEBUG ) {
            if (is_array($value) || is_object($value)) {
                error_log(print_r($value, true), 3, self::file);
            } else {
                error_log($value, 3, self::file);
            }
        }
    }

    /**
     * Write to log file.
     *
     * @param mixed
     *
     * @since    1.0.0
     */
    public static function output( $value, bool $exit = false ) {
        echo sprintf( '<pre %1$s>', is_admin() ? 'style="margin-left: 180px;"' : '' );

        if (is_array($value) || is_object($value)) {
            print_r($value);
        } else {
            echo $value;
        }

        echo "</pre>";

        if ($exit) {
            wp_die();
        }
    }
}
