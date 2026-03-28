<?php
/**
 * Icon generator class
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class DIG_Generator {
    
    private $icon_data = array(
        'vegan' => array('name' => 'Vegan', 'color' => '#2d6a24', 'text' => 'VG', 'fontSize' => 32),
        'vegetarian' => array('name' => 'Vegetarian', 'color' => '#7eb33d', 'text' => 'V', 'fontSize' => 38),
        'gluten-free' => array('name' => 'Gluten Free', 'color' => '#1b7ab1', 'text' => 'GF', 'fontSize' => 32),
        'dairy-free' => array('name' => 'Dairy Free', 'color' => '#19b2dd', 'text' => 'DF', 'fontSize' => 32),
        'egg-free' => array('name' => 'Egg Free', 'color' => '#f8962b', 'text' => 'EF', 'fontSize' => 32),
        'halal' => array('name' => 'Halal Friendly', 'color' => '#ffb366', 'text' => 'H', 'fontSize' => 38)
    );
    
    public function get_icon_types() {
        return array_keys($this->icon_data);
    }
    
    public function get_icon_data($type) {
        return isset($this->icon_data[$type]) ? $this->icon_data[$type] : null;
    }
    
    public function generate_svg($type, $style = 'subtle') {
        $data = $this->get_icon_data($type);
        if (!$data) {
            return false;
        }
        
        $svg = $this->create_svg($data, $type, $style);
        return $svg;
    }
    
    public function generate_icon($type, $style = 'subtle', $size = 256) {
        $svg = $this->generate_svg($type, $style);
        if (!$svg) {
            return false;
        }
        
        // Check if caching is enabled
        $settings = get_option('dig_settings', array());
        $cache_enabled = isset($settings['cache_icons']) ? $settings['cache_icons'] : true;
        
        if ($cache_enabled) {
            // Save to cache
            $upload_dir = wp_upload_dir();
            $icon_dir = $upload_dir['basedir'] . '/dietary-icons';
            $icon_url = $upload_dir['baseurl'] . '/dietary-icons';
            
            if (!file_exists($icon_dir)) {
                wp_mkdir_p($icon_dir);
            }
            
            $filename = "{$type}-{$style}-{$size}px.svg";
            $filepath = $icon_dir . '/' . $filename;
            $fileurl = $icon_url . '/' . $filename;
            
            file_put_contents($filepath, $svg);
            
            return array(
                'svg' => $svg,
                'url' => $fileurl,
                'path' => $filepath
            );
        }
        
        return array('svg' => $svg);
    }
    
    private function lighten_color($color, $percent) {
        $num = hexdec(str_replace('#', '', $color));
        $amt = round(2.55 * $percent);
        $R = min(255, ($num >> 16) + $amt);
        $G = min(255, (($num >> 8) & 0x00FF) + $amt);
        $B = min(255, ($num & 0x0000FF) + $amt);
        return '#' . str_pad(dechex(($R << 16) + ($G << 8) + $B), 6, '0', STR_PAD_LEFT);
    }
    
    private function darken_color($color, $percent) {
        $num = hexdec(str_replace('#', '', $color));
        $amt = round(2.55 * $percent);
        $R = max(0, ($num >> 16) - $amt);
        $G = max(0, (($num >> 8) & 0x00FF) - $amt);
        $B = max(0, ($num & 0x0000FF) - $amt);
        return '#' . str_pad(dechex(($R << 16) + ($G << 8) + $B), 6, '0', STR_PAD_LEFT);
    }
    
    private function get_food_graphic($icon_key, $color) {
        $light_color = $this->lighten_color($color, 30);
        
        $graphics = array(
            'vegan' => '<g transform="translate(70, 22)"><path d="M 0 0 Q 8 -4, 12 0 Q 8 4, 0 8 Q 3 4, 0 0" fill="' . $light_color . '" opacity="0.8"/><path d="M 1 0 L 11 0 M 2 2 L 10 2 M 3 4 L 9 4 M 4 6 L 8 6" stroke="white" stroke-width="0.8" opacity="0.6"/></g><g transform="translate(20, 75)"><path d="M 0 0 Q 6 -3, 9 0 Q 6 3, 0 6 Q 2 3, 0 0" fill="' . $light_color . '" opacity="0.6"/></g>',
            'vegetarian' => '<g transform="translate(70, 22)"><path d="M 0 0 Q 8 -4, 12 0 Q 8 4, 0 8 Q 3 4, 0 0" fill="' . $light_color . '" opacity="0.8"/><path d="M 1 0 L 11 0 M 2 2 L 10 2 M 3 4 L 9 4 M 4 6 L 8 6" stroke="white" stroke-width="0.8" opacity="0.6"/></g><g transform="translate(20, 75)"><path d="M 0 0 Q 6 -3, 9 0 Q 6 3, 0 6 Q 2 3, 0 0" fill="' . $light_color . '" opacity="0.6"/></g>',
            'gluten-free' => '<g transform="translate(72, 20)"><ellipse cx="4" cy="0" rx="2" ry="3" fill="' . $light_color . '" opacity="0.7"/><ellipse cx="0" cy="4" rx="2" ry="3" fill="' . $light_color . '" opacity="0.7"/><ellipse cx="8" cy="4" rx="2" ry="3" fill="' . $light_color . '" opacity="0.7"/><line x1="0" y1="0" x2="10" y2="8" stroke="white" stroke-width="2" opacity="0.8"/></g>',
            'dairy-free' => '<g transform="translate(70, 20)"><rect x="2" y="3" width="6" height="8" rx="1" fill="' . $light_color . '" opacity="0.7"/><rect x="3" y="1" width="4" height="3" rx="0.5" fill="' . $light_color . '" opacity="0.7"/><line x1="0" y1="0" x2="10" y2="12" stroke="white" stroke-width="2" opacity="0.8"/></g>',
            'egg-free' => '<g transform="translate(72, 22)"><ellipse cx="4" cy="4" rx="3.5" ry="5" fill="' . $light_color . '" opacity="0.7"/><line x1="0" y1="0" x2="8" y2="9" stroke="white" stroke-width="2" opacity="0.8"/></g>',
            'halal' => '<g transform="translate(72, 20)"><path d="M 0 6 Q 0 0, 6 0 Q 2 3, 2 6 Q 2 9, 6 12 Q 0 12, 0 6" fill="' . $light_color . '" opacity="0.7"/><circle cx="9" cy="3" r="1.5" fill="' . $light_color . '" opacity="0.7"/></g>'
        );
        
        return isset($graphics[$icon_key]) ? $graphics[$icon_key] : '';
    }
    
    private function create_svg($data, $icon_key, $style) {
        $base_color = $data['color'];
        $light_color = $this->lighten_color($base_color, 20);
        $dark_color = $this->darken_color($base_color, 15);
        $super_light = $this->lighten_color($base_color, 40);
        $text = esc_html($data['text']);
        $font_size = $data['fontSize'];
        
        $svg = '<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">';
        
        switch ($style) {
            case 'flat':
                $svg .= '<circle cx="50" cy="50" r="50" fill="' . $base_color . '"/>';
                $svg .= '<text x="50" y="50" text-anchor="middle" dominant-baseline="central" fill="white" font-size="' . $font_size . '" font-weight="700" font-family="Arial, sans-serif">' . $text . '</text>';
                break;
                
            case 'subtle':
                $svg .= '<defs><radialGradient id="grad-' . $icon_key . '" cx="35%" cy="35%"><stop offset="0%" style="stop-color:' . $light_color . ';stop-opacity:1" /><stop offset="100%" style="stop-color:' . $base_color . ';stop-opacity:1" /></radialGradient><filter id="shadow-' . $icon_key . '"><feDropShadow dx="0" dy="3" stdDeviation="4" flood-opacity="0.3"/></filter></defs>';
                $svg .= '<circle cx="50" cy="50" r="50" fill="url(#grad-' . $icon_key . ')" filter="url(#shadow-' . $icon_key . ')"/>';
                $svg .= '<text x="50" y="49" text-anchor="middle" dominant-baseline="central" fill="white" font-size="' . $font_size . '" font-weight="700" font-family="Arial, sans-serif" style="filter: drop-shadow(0px 1px 1px rgba(0,0,0,0.2));">' . $text . '</text>';
                break;
                
            case 'glossy':
                $svg .= '<defs><radialGradient id="grad-glossy-' . $icon_key . '" cx="40%" cy="30%"><stop offset="0%" style="stop-color:' . $super_light . ';stop-opacity:1" /><stop offset="50%" style="stop-color:' . $base_color . ';stop-opacity:1" /><stop offset="100%" style="stop-color:' . $dark_color . ';stop-opacity:1" /></radialGradient><linearGradient id="shine-' . $icon_key . '" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" style="stop-color:white;stop-opacity:0.6" /><stop offset="50%" style="stop-color:white;stop-opacity:0" /></linearGradient><filter id="shadow-glossy-' . $icon_key . '"><feDropShadow dx="0" dy="4" stdDeviation="5" flood-opacity="0.35"/></filter></defs>';
                $svg .= '<circle cx="50" cy="50" r="50" fill="url(#grad-glossy-' . $icon_key . ')" filter="url(#shadow-glossy-' . $icon_key . ')"/>';
                $svg .= '<ellipse cx="50" cy="30" rx="35" ry="20" fill="url(#shine-' . $icon_key . ')"/>';
                $svg .= '<text x="50" y="50" text-anchor="middle" dominant-baseline="central" fill="white" font-size="' . $font_size . '" font-weight="700" font-family="Arial, sans-serif" style="filter: drop-shadow(0px 2px 2px rgba(0,0,0,0.4));">' . $text . '</text>';
                break;
                
            case 'minimal':
                $svg .= '<defs><filter id="shadow-minimal-' . $icon_key . '"><feDropShadow dx="0" dy="2" stdDeviation="3" flood-opacity="0.2"/></filter></defs>';
                $svg .= '<circle cx="50" cy="50" r="50" fill="white" filter="url(#shadow-minimal-' . $icon_key . ')"/>';
                $svg .= '<circle cx="50" cy="50" r="45" fill="none" stroke="' . $base_color . '" stroke-width="6"/>';
                $svg .= '<text x="50" y="50" text-anchor="middle" dominant-baseline="central" fill="' . $base_color . '" font-size="' . $font_size . '" font-weight="700" font-family="Arial, sans-serif">' . $text . '</text>';
                break;
                
            case 'illustrated':
                $svg .= '<defs><radialGradient id="grad-' . $icon_key . '" cx="35%" cy="35%"><stop offset="0%" style="stop-color:' . $light_color . ';stop-opacity:1" /><stop offset="100%" style="stop-color:' . $base_color . ';stop-opacity:1" /></radialGradient><filter id="shadow-' . $icon_key . '"><feDropShadow dx="0" dy="3" stdDeviation="4" flood-opacity="0.3"/></filter></defs>';
                $svg .= '<circle cx="50" cy="50" r="50" fill="url(#grad-' . $icon_key . ')" filter="url(#shadow-' . $icon_key . ')"/>';
                $svg .= $this->get_food_graphic($icon_key, $base_color);
                $svg .= '<text x="50" y="50" text-anchor="middle" dominant-baseline="central" fill="white" font-size="' . $font_size . '" font-weight="700" font-family="Arial, sans-serif" style="filter: drop-shadow(0px 1px 2px rgba(0,0,0,0.3));">' . $text . '</text>';
                break;
                
            default:
                $svg .= '<circle cx="50" cy="50" r="50" fill="' . $base_color . '"/>';
                $svg .= '<text x="50" y="50" text-anchor="middle" dominant-baseline="central" fill="white" font-size="' . $font_size . '" font-weight="700" font-family="Arial, sans-serif">' . $text . '</text>';
        }
        
        $svg .= '</svg>';
        
        return $svg;
    }
}
