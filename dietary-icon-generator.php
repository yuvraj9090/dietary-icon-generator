<?php
/**
 * Plugin Name: Dietary Icon Generator
 * Plugin URI: https://github.com/wikiwyrhead/dietary-icon-generator
 * Description: Create beautiful dietary badges with food-specific graphics - perfect for menus and food photography. Generate vegan, vegetarian, gluten-free, dairy-free, egg-free, and halal icons with multiple styles.
 * Version: 1.0.0
 * Author: Arnel Go
 * Author URI: https://arnelbg.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Tested up to: 6.8
 * Requires PHP: 7.4
 * Text Domain: dietary-icon-generator
 * Domain Path: /languages
 * Network: false
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('DIG_VERSION', '1.0.0');
define('DIG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DIG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DIG_PLUGIN_FILE', __FILE__);
define('DIG_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main plugin class
 */
class Dietary_Icon_Generator {
    
    /**
     * Single instance of the class
     */
    private static $instance = null;
    
    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }
    
    /**
     * Load required files
     */
    private function load_dependencies() {
        require_once DIG_PLUGIN_DIR . 'includes/class-dig-admin.php';
        require_once DIG_PLUGIN_DIR . 'includes/class-dig-generator.php';
        require_once DIG_PLUGIN_DIR . 'includes/class-dig-shortcodes.php';
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));
        add_filter('plugin_action_links_' . DIG_PLUGIN_BASENAME, array($this, 'add_action_links'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Load text domain
        load_plugin_textdomain('dietary-icon-generator', false, dirname(DIG_PLUGIN_BASENAME) . '/languages');
        
        // Initialize admin
        if (is_admin()) {
            DIG_Admin::get_instance();
        }
        
        // Initialize shortcodes
        DIG_Shortcodes::get_instance();
    }
    
    /**
     * Enqueue public scripts and styles
     */
    public function enqueue_public_scripts() {
        wp_enqueue_style(
            'dietary-icon-generator',
            DIG_PLUGIN_URL . 'assets/css/public.css',
            array(),
            DIG_VERSION
        );
        
        wp_enqueue_script(
            'dietary-icon-generator',
            DIG_PLUGIN_URL . 'assets/js/public.js',
            array('jquery'),
            DIG_VERSION,
            true
        );
    }
    
    /**
     * Add action links
     */
    public function add_action_links($links) {
        $settings_link = sprintf(
            '<a href="%s">%s</a>',
            admin_url('admin.php?page=dietary-icon-generator'),
            __('Settings', 'dietary-icon-generator')
        );
        array_unshift($links, $settings_link);
        return $links;
    }
}

/**
 * Initialize plugin
 */
function DIG() {
    return Dietary_Icon_Generator::get_instance();
}

// Start the plugin
DIG();

/**
 * Activation hook
 */
register_activation_hook(__FILE__, 'dig_activate');
function dig_activate() {
    // Set default options
    if (!get_option('dig_settings')) {
        $defaults = array(
            'default_size' => 256,
            'default_style' => 'subtle',
            'enable_shortcodes' => true,
            'cache_icons' => true
        );
        add_option('dig_settings', $defaults);
    }
    
    // Create upload directory for cached icons
    $upload_dir = wp_upload_dir();
    $icon_dir = $upload_dir['basedir'] . '/dietary-icons';
    if (!file_exists($icon_dir)) {
        wp_mkdir_p($icon_dir);
    }
}

/**
 * Deactivation hook
 */
register_deactivation_hook(__FILE__, 'dig_deactivate');
function dig_deactivate() {
    // Clear scheduled events if any
}

/**
 * Uninstall hook
 */
register_uninstall_hook(__FILE__, 'dig_uninstall');
function dig_uninstall() {
    // Remove options
    delete_option('dig_settings');
    
    // Remove cached icons
    $upload_dir = wp_upload_dir();
    $icon_dir = $upload_dir['basedir'] . '/dietary-icons';
    if (file_exists($icon_dir)) {
        array_map('unlink', glob("$icon_dir/*.*"));
        rmdir($icon_dir);
    }
}
