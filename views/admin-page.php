<?php
/**
 * Admin page template
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap dig-admin-wrap">
    <h1><?php _e('Dietary Icon Generator', 'dietary-icon-generator'); ?></h1>
    <p class="subtitle"><?php _e('Create beautiful dietary badges with food-specific graphics - perfect for menus and food photography', 'dietary-icon-generator'); ?></p>
    
    <div class="dig-admin-container">
        <!-- Generator Section -->
        <div class="dig-section dig-generator-section">
            <h2><?php _e('Icon Generator', 'dietary-icon-generator'); ?></h2>
            
            <div class="dig-controls">
                <div class="dig-control-group">
                    <label><?php _e('Icon Size:', 'dietary-icon-generator'); ?></label>
                    <div class="dig-size-options">
                    <button class="dig-size-btn" data-size="32">32px</button>
                    <button class="dig-size-btn" data-size="64">64px</button>
                        <button class="dig-size-btn" data-size="1024">1024px</button>
                    </div>
                </div>
                
                <div class="dig-control-group">
                    <label><?php _e('Icon Style:', 'dietary-icon-generator'); ?></label>
                    <div class="dig-style-options">
                        <button class="dig-style-btn" data-style="flat"><?php _e('Flat', 'dietary-icon-generator'); ?></button>
                        <button class="dig-style-btn active" data-style="subtle"><?php _e('Subtle 3D', 'dietary-icon-generator'); ?></button>
                        <button class="dig-style-btn" data-style="glossy"><?php _e('Glossy', 'dietary-icon-generator'); ?></button>
                        <button class="dig-style-btn" data-style="minimal"><?php _e('Minimal Ring', 'dietary-icon-generator'); ?></button>
                        <button class="dig-style-btn" data-style="illustrated"><?php _e('🎨 Illustrated', 'dietary-icon-generator'); ?></button>
                    </div>
                </div>
            </div>
            
            <div class="dig-info-box">
                <p><strong><?php _e('💡 Tip:', 'dietary-icon-generator'); ?></strong> <?php _e('"Illustrated" style adds relevant food graphics for a more descriptive look.', 'dietary-icon-generator'); ?></p>
            </div>
            
            <div id="digIconGrid" class="dig-icon-grid"></div>
            
            <button class="button button-primary button-large dig-download-all" id="digDownloadAll">
                <?php _e('⬇️ Download All Icons (Current Style)', 'dietary-icon-generator'); ?>
            </button>
        </div>
        
        <!-- Demo Section -->
        <div class="dig-section dig-demo-section">
            <h2><?php _e('📸 Usage Example: Menu Item', 'dietary-icon-generator'); ?></h2>
            <div class="dig-demo-card">
                <div class="dig-demo-badges" id="digDemoBadges"></div>
                <div class="dig-demo-name"><?php _e('Mediterranean Buddha Bowl', 'dietary-icon-generator'); ?></div>
                <div class="dig-demo-description"><?php _e('Quinoa, roasted vegetables, hummus, tahini drizzle, fresh herbs', 'dietary-icon-generator'); ?></div>
            </div>
        </div>
        
        <!-- Shortcodes Section -->
        <div class="dig-section dig-shortcodes-section">
            <h2><?php _e('📝 Shortcodes', 'dietary-icon-generator'); ?></h2>
            
            <div class="dig-shortcode-example">
                <h3><?php _e('Single Icon', 'dietary-icon-generator'); ?></h3>
                <code>[dietary_icon type="vegan" style="subtle" size="64"]</code>
                <p><?php _e('Display a single dietary icon.', 'dietary-icon-generator'); ?></p>
                <p><strong><?php _e('Parameters:', 'dietary-icon-generator'); ?></strong></p>
                <ul>
                    <li><code>type</code>: vegan, vegetarian, gluten-free, dairy-free, egg-free, halal</li>
                    <li><code>style</code>: flat, subtle, glossy, minimal, illustrated</li>
                    <li><code>size</code>: Icon size in pixels (default: 64)</li>
                    <li><code>class</code>: Additional CSS classes</li>
                </ul>
            </div>
            
            <div class="dig-shortcode-example">
                <h3><?php _e('Badge with Label', 'dietary-icon-generator'); ?></h3>
                <code>[dietary_badge type="vegan" label="Vegan Friendly" style="subtle" size="32"]</code>
                <p><?php _e('Display an icon with a text label.', 'dietary-icon-generator'); ?></p>
                <p><strong><?php _e('Parameters:', 'dietary-icon-generator'); ?></strong></p>
                <ul>
                    <li><code>type</code>: vegan, vegetarian, gluten-free, dairy-free, egg-free, halal</li>
                    <li><code>label</code>: Custom label text (optional, defaults to icon name)</li>
                    <li><code>style</code>: flat, subtle, glossy, minimal, illustrated</li>
                    <li><code>size</code>: Icon size in pixels (default: 32)</li>
                </ul>
            </div>
            
            <div class="dig-shortcode-example">
                <h3><?php _e('Multiple Icons', 'dietary-icon-generator'); ?></h3>
                <code>[dietary_icons types="vegan,gluten-free,dairy-free" style="subtle" size="36" labels="true"]</code>
                <p><?php _e('Display multiple icons together.', 'dietary-icon-generator'); ?></p>
                <p><strong><?php _e('Parameters:', 'dietary-icon-generator'); ?></strong></p>
                <ul>
                    <li><code>types</code>: Comma-separated list of icon types</li>
                    <li><code>style</code>: flat, subtle, glossy, minimal, illustrated</li>
                    <li><code>size</code>: Icon size in pixels (default: 36)</li>
                    <li><code>labels</code>: Show labels (true/false, default: false)</li>
                </ul>
            </div>
        </div>
        
        <!-- Settings Section -->
        <div class="dig-section dig-settings-section">
            <h2><?php _e('⚙️ Settings', 'dietary-icon-generator'); ?></h2>
            
            <form method="post" action="options.php">
                <?php settings_fields('dig_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="dig_default_size"><?php _e('Default Icon Size', 'dietary-icon-generator'); ?></label>
                        </th>
                        <td>
                            <select name="dig_settings[default_size]" id="dig_default_size" class="regular-text">
                                <option value="32" <?php selected($settings['default_size'], 32); ?>>32px</option>
                                <option value="64" <?php selected($settings['default_size'], 64); ?>>64px</option>
                                <option value="128" <?php selected($settings['default_size'], 128); ?>>128px</option>
                                <option value="256" <?php selected($settings['default_size'], 256); ?>>256px</option>
                                <option value="512" <?php selected($settings['default_size'], 512); ?>>512px</option>
                                <option value="1024" <?php selected($settings['default_size'], 1024); ?>>1024px</option>
                            </select>
                            <p class="description"><?php _e('Default size in pixels for generated icons.', 'dietary-icon-generator'); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="dig_default_style"><?php _e('Default Icon Style', 'dietary-icon-generator'); ?></label>
                        </th>
                        <td>
                            <select name="dig_settings[default_style]" id="dig_default_style">
                                <option value="flat" <?php selected($settings['default_style'], 'flat'); ?>><?php _e('Flat', 'dietary-icon-generator'); ?></option>
                                <option value="subtle" <?php selected($settings['default_style'], 'subtle'); ?>><?php _e('Subtle 3D', 'dietary-icon-generator'); ?></option>
                                <option value="glossy" <?php selected($settings['default_style'], 'glossy'); ?>><?php _e('Glossy', 'dietary-icon-generator'); ?></option>
                                <option value="minimal" <?php selected($settings['default_style'], 'minimal'); ?>><?php _e('Minimal Ring', 'dietary-icon-generator'); ?></option>
                                <option value="illustrated" <?php selected($settings['default_style'], 'illustrated'); ?>><?php _e('Illustrated', 'dietary-icon-generator'); ?></option>
                            </select>
                            <p class="description"><?php _e('Default style for shortcodes when not specified.', 'dietary-icon-generator'); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="dig_enable_shortcodes"><?php _e('Enable Shortcodes', 'dietary-icon-generator'); ?></label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="dig_settings[enable_shortcodes]" id="dig_enable_shortcodes" 
                                       value="1" <?php checked($settings['enable_shortcodes'], true); ?>>
                                <?php _e('Enable dietary icon shortcodes', 'dietary-icon-generator'); ?>
                            </label>
                            <p class="description"><?php _e('Allow the use of shortcodes in posts and pages.', 'dietary-icon-generator'); ?></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="dig_cache_icons"><?php _e('Cache Icons', 'dietary-icon-generator'); ?></label>
                        </th>
                        <td>
                            <label>
                                <input type="checkbox" name="dig_settings[cache_icons]" id="dig_cache_icons" 
                                       value="1" <?php checked($settings['cache_icons'], true); ?>>
                                <?php _e('Save generated icons to uploads folder', 'dietary-icon-generator'); ?>
                            </label>
                            <p class="description"><?php _e('Improves performance by caching generated icons.', 'dietary-icon-generator'); ?></p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
    </div>
</div>
