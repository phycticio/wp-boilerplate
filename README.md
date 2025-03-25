# WordPress Boilerplate Modern Stack

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://mit-license.org/)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-8892BF.svg)](https://php.net/)
[![WordPress](https://img.shields.io/badge/WordPress-6.4%2B-0073aa.svg)](https://wordpress.org/)

Modern template for WordPress development with scalable architecture and updated technology stack.

## Key Features

- 🚀 **Modern Stack**: PHP 8.1+, Node 18+, Composer 2+, pnpm
- 🧩 **Dependency Management**: 
    - Plugins managed via Composer
    - Assets with Webpack 5 and ES6+
- 🧱 **Block Theme**:
    - Native blocks with React
    - Full Site Editing (FSE)
    - Complete frontend/backend integration
- 📐 **Clean Architecture**:
    - MVC pattern with Twig templating
    - Environment-based configuration
    - Clear separation of responsibilities
- ⚙️ **Professional Workflow**:
    - Integrated GitHub Actions
    - PHP Code Standards (Pint)
    - Multi-environment Webpack

## Prerequisites

- PHP 8.1+
- Node.js 18+
- Composer 2.2+
- pnpm 8+

## Quick Installation

```shell
composer create-project phycticio/wp-boilerplate project-name
cd project-name
cp sample.env .env
pnpm install
pnpm run build
```

## Configuration

### Environments

1. Edit `.env` with your variables
2. Configure environments in `config/environments/`
    - `development.php`: Local config
    - `production.php`: Production config

### Main Files

- `config/application.php`: Shared configuration
- `web/wp-config.php`: WordPress Bootstrap
- `app/App.php`: Theme initializer

## Directory Structure

```text
wp-boilerplate/
├── .github/            # GitHub Actions workflows
├── app/                # Application logic
│   ├── Features/       # Traits and functionalities
│   ├── Hooks/          # WordPress hooks
│   ├── Services/       # Services and DB interactions
│   └── App.php         # Main initializer
├── config/             # Configurations
│   ├── environments/   # Environment variables
│   ├── application.php # Base config
│   └── webpack.*.js    # Webpack configurations
├── resources/          # Assets and templates
│   ├── blocks/         # Custom blocks
│   ├── scripts/        # JS entry points
│   ├── scss/           # Global styles
│   └── views/          # Twig templates
├── web/                # Web root
│   ├── content/        # WP content directory
│   └── wp/             # Core WordPress
└── [config files]      # Global configurations
```

## Development

### Main Commands

```shell
# Install dependencies
pnpm install

# Development with hot-reload
pnpm run dev

# Production build
pnpm run build

# Lint PHP
pnpm run lint

# Format code
pnpm run format
```

### Block Creation

1. Add new block in `resources/blocks/`
2. Use WordPress `registerBlockType`
3. Import styles/scripts in Webpack config

### Twig Templates

```php
// Example usage in WordPress
View::render('template-name', ['data' => $values]);
```

## GitHub Actions Workflow

- **Lint**: PHP/JS code verification
- **Build**: Asset compilation
- **Deploy**: Configurable for different environments

## Coding Standards

- PHP: PHP-CS-Fixer (config in `pint.json`)
- JS: ESLint with standard config
- Styles: SCSS with SMACSS structure

## Contribution

1. Fork the project
2. Create feature branch (`feat/my-feature`)
3. Submit Pull Request

## License

GPL-3.0. See [LICENSE](LICENSE) for details.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history.
