<?php
/**
 * Shortcodes functionality
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class DIG_Shortcodes {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $settings = get_option('dig_settings', array());
        $enable_shortcodes = isset($settings['enable_shortcodes']) ? $settings['enable_shortcodes'] : true;
        
        if ($enable_shortcodes) {
            add_shortcode('dietary_icon', array($this, 'dietary_icon_shortcode'));
            add_shortcode('dietary_badge', array($this, 'dietary_badge_shortcode'));
            add_shortcode('dietary_icons', array($this, 'dietary_icons_shortcode'));
        }
    }
    
    /**
     * Single icon shortcode
     * Usage: [dietary_icon type="vegan" style="subtle" size="64"]
     */
    public function dietary_icon_shortcode($atts) {
        $settings = get_option('dig_settings', array(
            'default_size' => 256,
            'default_style' => 'subtle'
        ));
        
        $atts = shortcode_atts(array(
            'type' => 'vegan',
            'style' => $settings['default_style'],
            'size' => 64,
            'class' => ''
        ), $atts);
        
        $generator = new DIG_Generator();
        $svg = $generator->generate_svg($atts['type'], $atts['style']);
        
        if (!$svg) {
            return '';
        }
        
        $class = 'dietary-icon dietary-icon-' . esc_attr($atts['type']);
        if (!empty($atts['class'])) {
            $class .= ' ' . esc_attr($atts['class']);
        }
        
        $style = 'width: ' . absint($atts['size']) . 'px; height: ' . absint($atts['size']) . 'px; display: inline-block;';
        
        return '<span class="' . $class . '" style="' . $style . '">' . $svg . '</span>';
    }
    
    /**
     * Badge shortcode with label
     * Usage: [dietary_badge type="vegan" label="Vegan Friendly" style="subtle" size="32"]
     */
    public function dietary_badge_shortcode($atts) {
        $settings = get_option('dig_settings', array(
            'default_size' => 256,
            'default_style' => 'subtle'
        ));
        
        $atts = shortcode_atts(array(
            'type' => 'vegan',
            'label' => '',
            'style' => $settings['default_style'],
            'size' => 32,
            'class' => ''
        ), $atts);
        
        $generator = new DIG_Generator();
        $svg = $generator->generate_svg($atts['type'], $atts['style']);
        $icon_data = $generator->get_icon_data($atts['type']);
        
        if (!$svg) {
            return '';
        }
        
        $label = !empty($atts['label']) ? esc_html($atts['label']) : $icon_data['name'];
        $class = 'dietary-badge dietary-badge-' . esc_attr($atts['type']);
        if (!empty($atts['class'])) {
            $class .= ' ' . esc_attr($atts['class']);
        }
        
        $icon_style = 'width: ' . absint($atts['size']) . 'px; height: ' . absint($atts['size']) . 'px;';
        
        $output = '<span class="' . $class . '">';
        $output .= '<span class="dietary-badge-icon" style="' . $icon_style . '">' . $svg . '</span>';
        $output .= '<span class="dietary-badge-label">' . $label . '</span>';
        $output .= '</span>';
        
        return $output;
    }
    
    /**
     * Multiple icons shortcode
     * Usage: [dietary_icons types="vegan,gluten-free,dairy-free" style="subtle" size="36"]
     */
    public function dietary_icons_shortcode($atts) {
        $settings = get_option('dig_settings', array(
            'default_size' => 256,
            'default_style' => 'subtle'
        ));
        
        $atts = shortcode_atts(array(
            'types' => 'vegan,vegetarian,gluten-free',
            'style' => $settings['default_style'],
            'size' => 36,
            'class' => '',
            'labels' => 'false'
        ), $atts);
        
        $types = array_map('trim', explode(',', $atts['types']));
        $show_labels = filter_var($atts['labels'], FILTER_VALIDATE_BOOLEAN);
        
        $class = 'dietary-icons-group';
        if (!empty($atts['class'])) {
            $class .= ' ' . esc_attr($atts['class']);
        }
        
        $output = '<div class="' . $class . '">';
        
        foreach ($types as $type) {
            if ($show_labels) {
                $output .= do_shortcode('[dietary_badge type="' . esc_attr($type) . '" style="' . esc_attr($atts['style']) . '" size="' . esc_attr($atts['size']) . '"]');
            } else {
                $output .= do_shortcode('[dietary_icon type="' . esc_attr($type) . '" style="' . esc_attr($atts['style']) . '" size="' . esc_attr($atts['size']) . '"]');
            }
        }
        
        $output .= '</div>';
        
        return $output;
    }
}
