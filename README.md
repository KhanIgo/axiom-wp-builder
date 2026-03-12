# Axiom WP Builder

> **Powerful WordPress Page Builder — All Features Included, No Pro Version**

Axiom WP Builder is a comprehensive drag-and-drop page builder for WordPress that provides professional website building capabilities out-of-the-box. Unlike other builders, there's no feature gating — everything is included from day one.

![WordPress Version](https://img.shields.io/badge/WordPress-5.8%2B-blue)
![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-purple)
![License](https://img.shields.io/badge/License-GPL%20v3-green)

---

## ✨ Features

### 🎨 Visual Editor
- **Real-time WYSIWYG editing** — See changes as you make them
- **Drag-and-drop interface** — Intuitive widget placement
- **Responsive preview** — Desktop, tablet, and mobile views
- **Inline text editing** — Click and type directly on canvas
- **History & undo/redo** — Never lose your work

### 🧩 50+ Widgets Included

| Category | Widgets |
|----------|---------|
| **Basic** | Heading, Text Editor, Image, Gallery, Button, Icon, Divider, Spacer |
| **Content** | Tabs, Accordion, Toggle, Progress Bar, Counter, Alert, Table, Code Block |
| **Media** | Video, Audio, Slideshow, Carousel, Lightbox, Google Maps, SoundCloud |
| **Forms** | Form Builder, Newsletter, Search, Login, Registration |
| **WooCommerce** | Product Grid, Single Product, Cart, Checkout, Categories, Price |
| **Advanced** | Posts, Portfolio, Team Member, Pricing Table, Countdown, Flip Box, Lottie |

### 🏗️ Theme Builder
Build every part of your site visually:
- Headers & Footers
- Single Post templates
- Archive pages
- 404 & Search results
- WooCommerce product pages

### 🎯 Popup Builder
Create engaging popups with advanced triggers:
- Exit intent
- Scroll percentage
- Time delay
- Click trigger
- Form submission
- Exit intent

### 🎭 Motion Effects
- Entrance animations (fade, slide, zoom, bounce)
- Scroll effects (parallax, sticky)
- Mouse tracking effects
- Hover transformations

### 🎨 Design System
- **Global colors** — 10 customizable color slots
- **Typography** — Font families, sizes, weights
- **Spacing presets** — Consistent padding/margins
- **Custom CSS/JS** — Add custom code globally or per element

### 📱 Responsive Design
- Per-device styling controls
- Custom breakpoints
- Element visibility per device
- Responsive typography scaling

### ⚡ Dynamic Content
- WordPress post data (title, content, featured image)
- Custom fields (ACF, Meta Box, Pods compatible)
- User information
- Site settings
- Date/time values

---

## 🚀 Quick Start

### Requirements
- WordPress 5.8 or higher
- PHP 7.4 or higher (8.1+ recommended)
- MySQL 5.6+ or MariaDB 10.3+

### Installation

#### Method 1: WordPress Admin
1. Download the plugin ZIP file
2. Go to **Plugins → Add New → Upload Plugin**
3. Choose the ZIP file and click **Install Now**
4. Click **Activate**

#### Method 2: Manual Installation
1. Upload the `axiom-wp-builder` folder to `/wp-content/plugins/`
2. Activate the plugin through **Plugins** in WordPress admin

#### Method 3: Composer
```bash
composer require axiom-wp-builder/axiom-wp-builder
```

### Usage

1. **Create a new page** or edit an existing one
2. Click **"Edit with Axiom Builder"** button
3. **Drag widgets** from the left panel to the canvas
4. **Customize** using the right panel controls
5. **Click Save** to publish your changes

---

## 📁 Project Structure

```
axiom-wp-builder/
├── assets/              # Compiled CSS & JavaScript
├── includes/            # PHP classes
├── modules/             # Feature modules (popup, theme builder, etc.)
├── src/                 # Source files (TypeScript, SCSS)
├── templates/           # PHP templates
├── languages/           # Translation files
├── axiom-wp-builder.php # Main plugin file
├── composer.json        # PHP dependencies
├── package.json         # JavaScript dependencies
└── README.md            # This file
```

---

## 🛠️ Development

### Prerequisites
- Node.js 18+
- PHP 7.4+
- Composer
- WordPress development environment

### Setup

```bash
# Clone the repository
git clone https://github.com/axiom-wp-builder/axiom-wp-builder.git
cd axiom-wp-builder

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build
```

### Available Scripts

| Command | Description |
|---------|-------------|
| `npm run dev` | Start development with hot reload |
| `npm run build` | Build for production |
| `npm run watch` | Watch for changes and rebuild |
| `npm run lint` | Check code style |
| `npm run test` | Run tests |
| `composer test` | Run PHP unit tests |

---

## 🔌 Extensibility

### Add Custom Widgets

```php
add_action('axiom/widgets/register', function($widgets_manager) {
    $widgets_manager->register(new My_Custom_Widget());
});
```

### Add Custom Controls

```javascript
AxiomEditor.addControl('my-control', MyControlComponent);
```

### Hooks & Filters

```php
// Modify widget settings
add_filter('axiom/widget/settings', function($settings, $widget) {
    // Modify settings
    return $settings;
}, 10, 2);

// After template save
add_action('axiom/template/after_save', function($template_id, $data) {
    // Custom logic
}, 10, 2);
```

---

## 🌍 Translations

The plugin is translation-ready. Translation files are located in `/languages/`.

**Supported languages:**
- 🇺🇸 English (default)
- 🇪🇸 Spanish
- 🇫🇷 French
- 🇩🇪 German
- 🇮🇹 Italian
- 🇵🇹 Portuguese
- 🇷🇺 Russian
- 🇯🇵 Japanese

[Contribute translations](https://translate.wordpress.org/projects/axiom-wp-builder/)

---

## 📖 Documentation

- [Getting Started Guide](docs/getting-started.md)
- [Widget Reference](docs/widgets.md)
- [Theme Builder Guide](docs/theme-builder.md)
- [Popup Builder Guide](docs/popup-builder.md)
- [Developer API](docs/developer-api.md)
- [FAQ](docs/faq.md)

---

## 🤝 Contributing

We welcome contributions from the community!

### How to Contribute
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- Write tests for new features
- Update documentation
- Use semantic commit messages

See [CONTRIBUTING.md](CONTRIBUTING.md) for detailed guidelines.

---

## 🐛 Reporting Issues

Found a bug? Please report it on our [GitHub Issues](https://github.com/axiom-wp-builder/axiom-wp-builder/issues) page.

**When reporting:**
- Describe the issue clearly
- Include steps to reproduce
- Mention WordPress, PHP, and browser versions
- Add screenshots if applicable

---

## 🔒 Security

Security is our top priority. If you discover a security vulnerability:

- **Do not** disclose it publicly
- Email: security@axiombuilder.com
- We respond within 48 hours

---

## 📄 License

Axiom WP Builder is licensed under **GPL v3.0**.

```
Copyright (C) 2026 Axiom Development Team

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

---

## 🙏 Credits

- **Developed by**: Axiom Development Team
- **Inspired by**: Elementor, Beaver Builder, Gutenberg
- **Built with**: React, TypeScript, PHP

---

## 📬 Stay Updated

- **Website**: [axiom web development](https://axiom-web.ru)
- **Author**: [@Khan Igor](https://khxn.ru/AxiomBuilder)


---

## 🗺️ Roadmap

### Version 1.0 (Q2 2026)
- [x] Core editor
- [x] Basic widgets
- [x] Template builder
- [ ] Popup builder
- [ ] WooCommerce integration

### Version 1.1 (Q3 2026)
- [ ] Motion effects
- [ ] Dynamic content
- [ ] Form builder
- [ ] Template library

### Version 2.0 (Q4 2026)
- [ ] AI-powered content suggestions
- [ ] Collaborative editing
- [ ] Advanced animations
- [ ] E-commerce extensions

---

<div align="center">

**Made with ❤️ for the WordPress community**

[Report Bug](https://github.com/axiom-wp-builder/axiom-wp-builder/issues) · [Request Feature](https://github.com/axiom-wp-builder/axiom-wp-builder/issues) · [Documentation](https://axiombuilder.com/docs)

</div>
