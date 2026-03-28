# Dietary Icon Generator

Create beautiful dietary badges with food-specific graphics - perfect for menus and food photography.

## Description

The Dietary Icon Generator plugin allows you to create and display professional dietary restriction icons/badges on your WordPress site. Perfect for restaurants, food blogs, recipe sites, and catering businesses.

## Features

- **6 Dietary Icon Types**: Vegan, Vegetarian, Gluten-Free, Dairy-Free, Egg-Free, and Halal
- **5 Visual Styles**: Flat, Subtle 3D, Glossy, Minimal Ring, and Illustrated (with food graphics)
- **Multiple Size Options**: Generate icons from 128px to 1024px
- **Easy Shortcodes**: Display icons anywhere with simple shortcodes
- **Customizable**: Configure default styles and sizes
- **Performance Optimized**: Optional icon caching for faster loading
- **Responsive**: Works perfectly on all devices

## Installation

1. Upload the `dietary-icon-generator` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Dietary Icons' in your admin menu to configure settings and generate icons

## Usage

### Shortcodes

#### Display a Single Icon
```
[dietary_icon type="vegan" style="subtle" size="64"]
```

**Parameters:**
- `type`: vegan, vegetarian, gluten-free, dairy-free, egg-free, halal
- `style`: flat, subtle, glossy, minimal, illustrated
- `size`: Icon size in pixels (default: 64)
- `class`: Additional CSS classes

#### Display a Badge with Label
```
[dietary_badge type="vegan" label="Vegan Friendly" style="subtle" size="32"]
```

**Parameters:**
- `type`: vegan, vegetarian, gluten-free, dairy-free, egg-free, halal
- `label`: Custom label text (optional, defaults to icon name)
- `style`: flat, subtle, glossy, minimal, illustrated
- `size`: Icon size in pixels (default: 32)

#### Display Multiple Icons
```
[dietary_icons types="vegan,gluten-free,dairy-free" style="subtle" size="36" labels="true"]
```

**Parameters:**
- `types`: Comma-separated list of icon types
- `style`: flat, subtle, glossy, minimal, illustrated
- `size`: Icon size in pixels (default: 36)
- `labels`: Show labels (true/false, default: false)

### Admin Interface

Navigate to **Dietary Icons** in your WordPress admin menu to:
- Generate and download icons in various styles and sizes
- View live examples
- Configure plugin settings
- See shortcode documentation

## Icon Types

- **Vegan (VG)**: Plant-based, no animal products
- **Vegetarian (V)**: No meat, may include dairy/eggs
- **Gluten-Free (GF)**: No wheat, barley, or rye
- **Dairy-Free (DF)**: No milk products
- **Egg-Free (EF)**: No eggs
- **Halal (H)**: Islamic dietary standards

## Icon Styles

- **Flat**: Simple solid color design
- **Subtle 3D**: Gentle gradient with soft shadow
- **Glossy**: Shiny appearance with highlights
- **Minimal Ring**: Clean outline style
- **Illustrated**: Includes relevant food graphics

## Settings

- **Default Icon Size**: Set the default size for generated icons
- **Default Icon Style**: Choose your preferred style
- **Enable Shortcodes**: Turn shortcodes on/off
- **Cache Icons**: Save generated icons for better performance

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher

## Support

For support, feature requests, or bug reports, please visit:
- GitHub: https://github.com/wikiwyrhead/dietary-icon-generator
- Issues: https://github.com/wikiwyrhead/dietary-icon-generator/issues

## Changelog

### 1.0.0
- Initial release
- 6 dietary icon types
- 5 visual styles
- Admin interface for icon generation
- Shortcode support
- Caching system
- Responsive design

## License

GPL v2 or later

## Credits

Created by Arnel Go
