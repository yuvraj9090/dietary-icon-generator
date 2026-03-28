# Hi, I'm Adonix! 👋

![Profile Views](https://komarev.com/ghpvc/?username=adonix26&color=1b7ab1&style=flat)

> Full-stack developer crafting WordPress plugins, AI-powered tools & web optimization solutions. Building digital experiences that matter.

🔭 Currently building: **Dietary Icon Generator** (this repo!)  
🌱 Exploring: **AI Agents** × **Web Performance**  
💬 Ask me about: **PHP**, **JavaScript**, **WordPress**, **Web Optimization**  
🌍 Location: Remote | Available Worldwide  
⚡ Fun fact: I turn coffee into code... efficiently!

---

## 🎨 What You're Looking At

**Dietary Icon Generator** — A WordPress plugin for creating beautiful dietary restriction badges. Perfect for restaurants, food blogs, and recipe sites!

---

## 🛠️ My Tech Stack

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![Node.js](https://img.shields.io/badge/Node.js-339933?style=for-the-badge&logo=nodedotjs&logoColor=white)
![Python](https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)

---

## 📊 GitHub Stats

<div align="center">
  <img src="https://github-readme-stats.vercel.app/api?username=adonix26&show_icons=true&theme=radical&hide_border=true" alt="GitHub Stats" />
  <img src="https://github-readme-stats.vercel.app/api/top-langs/?username=adonix26&layout=compact&theme=radical&hide_border=true" alt="Top Languages" />
</div>

---

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
- GitHub: https://github.com/adonix26/dietary-icon-generator
- Issues: https://github.com/adonix26/dietary-icon-generator/issues

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

Created by **Adonix**

---

## 🤝 Connect With Me

<div align="center">

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/adonix26)

</div>

<p align="center">⭐ Star this repo if you find it useful!</p>
