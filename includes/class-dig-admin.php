<?php
/**
 * Admin functionality
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class DIG_Admin {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('admin_menu', array($this, 'add_menu'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_dig_generate_icon', array($this, 'ajax_generate_icon'));
        add_action('wp_ajax_dig_download_all', array($this, 'ajax_download_all'));
    }
    
    public function add_menu() {
        add_menu_page(
            __('Dietary Icons', 'dietary-icon-generator'),
            __('Dietary Icons', 'dietary-icon-generator'),
            'manage_options',
            'dietary-icon-generator',
            array($this, 'render_admin_page'),
            'dashicons-food',
            30
        );
    }
    
    public function register_settings() {
        register_setting('dig_settings', 'dig_settings', array($this, 'sanitize_settings'));
    }
    
    public function sanitize_settings($input) {
        $output = array();
        $size = isset($input['default_size']) ? absint($input['default_size']) : 256;
        // Validate size is one of the allowed values
        $allowed_sizes = array(32, 64, 128, 256, 512, 1024);
        $output['default_size'] = in_array($size, $allowed_sizes) ? $size : 256;
        $output['default_style'] = isset($input['default_style']) ? sanitize_text_field($input['default_style']) : 'subtle';
        $output['enable_shortcodes'] = isset($input['enable_shortcodes']) ? (bool)$input['enable_shortcodes'] : true;
        $output['cache_icons'] = isset($input['cache_icons']) ? (bool)$input['cache_icons'] : true;
        return $output;
    }
    
    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_dietary-icon-generator' !== $hook) {
            return;
        }
        
        wp_enqueue_style('dig-admin', DIG_PLUGIN_URL . 'assets/css/admin.css', array(), DIG_VERSION);
        wp_enqueue_script('dig-admin', DIG_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), DIG_VERSION, true);
        
        wp_localize_script('dig-admin', 'digAdmin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dig_nonce')
        ));
    }
    
    public function ajax_generate_icon() {
        check_ajax_referer('dig_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Permission denied'));
        }
        
        $icon_type = isset($_POST['icon_type']) ? sanitize_text_field($_POST['icon_type']) : '';
        $style = isset($_POST['style']) ? sanitize_text_field($_POST['style']) : 'subtle';
        $size = isset($_POST['size']) ? absint($_POST['size']) : 256;
        
        $generator = new DIG_Generator();
        $result = $generator->generate_icon($icon_type, $style, $size);
        
        if ($result) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error(array('message' => 'Failed to generate icon'));
        }
    }
    
    public function ajax_download_all() {
        check_ajax_referer('dig_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Permission denied'));
        }
        
        // This will be handled by JavaScript on the frontend
        wp_send_json_success();
    }
    
    public function render_admin_page() {
        $settings = get_option('dig_settings', array(
            'default_size' => 256,
            'default_style' => 'subtle',
            'enable_shortcodes' => true,
            'cache_icons' => true
        ));
        
        include DIG_PLUGIN_DIR . 'views/admin-page.php';
    }
}
