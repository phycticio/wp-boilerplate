# WordPress Boilerplate Modern Stack

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://mit-license.org/)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-8892BF.svg)](https://php.net/)
[![WordPress](https://img.shields.io/badge/WordPress-6.4%2B-0073aa.svg)](https://wordpress.org/)

Plantilla moderna para desarrollo WordPress con arquitectura escalable y stack tecnológico actualizado.

## Características Clave

- 🚀 **Stack Moderno**: PHP 8.1+, Node 18+, Composer 2+, pnpm
- 🧩 **Gestión de Dependencias**: 
    - Plugins manejados via Composer
    - Assets con Webpack 5 y ES6+
- 🧱 **Block Theme**:
    - Bloques nativos con React
    - Full Site Editing (FSE)
    - Integración frontend/backend total
- 📐 **Arquitectura Limpia**:
    - Patrón MVC con Twig templating
    - Configuración por ambientes
    - Separación clara de responsabilidades
- ⚙️ **Flujo Profesional**:
    - GitHub Actions integrado
    - PHP Code Standards (Pint)
    - Webpack multi-entorno

## Requisitos Previos

- PHP 8.1+
- Node.js 18+
- Composer 2.2+
- pnpm 8+

## Instalación Rápida

```bash
composer create-project phycticio/wp-boilerplate project-name
cd project-name
cp sample.env .env
pnpm install
pnpm run build
```

## Configuración

### Entornos

1. Edita `.env` con tus variables
2. Configura ambientes en `config/environments/`
    - `development.php`: Config local
    - `production.php`: Config producción

### Archivos Principales

- `config/application.php`: Configuración compartida
- `web/wp-config.php`: Bootstrap WordPress
- `app/App.php`: Inicializador del tema

## Estructura de Directorios

```text
wp-boilerplate/
├── .github/            # GitHub Actions workflows
├── app/                # Lógica de aplicación
│   ├── Features/       # Traits y funcionalidades
│   ├── Hooks/          # WordPress hooks
│   ├── Services/       # Servicios y DB interactions
│   └── App.php         # Inicializador principal
├── config/             # Configuraciones
│   ├── environments/   # Variables por entorno
│   ├── application.php # Config base
│   └── webpack.*.js    # Configuraciones Webpack
├── resources/          # Assets y templates
│   ├── blocks/         # Bloques personalizados
│   ├── scripts/        # JS entry points
│   ├── scss/           # Estilos globales
│   └── views/          # Plantillas Twig
├── web/                # Web root
│   ├── content/        # WP content directory
│   └── wp/             # Core WordPress
└── [config files]      # Configuraciones globales
```

## Desarrollo

### Comandos Principales

```bash
# Instalar dependencias
pnpm install

# Desarrollo con hot-reload
pnpm run dev

# Build producción
pnpm run build

# Lint PHP
pnpm run lint

# Formatear código
pnpm run format
```

### Creación de Bloques

1. Añade nuevo bloque en `resources/blocks/`
2. Usa `registerBlockType` de WordPress
3. Importa estilos/scripts en Webpack config

### Templates Twig

```php
// Ejemplo de uso en WordPress
View::render('template-name', ['data' => $values]);
```

## Workflow GitHub Actions

- **Lint**: Verificación de código PHP/JS
- **Build**: Compilación de assets
- **Deploy**: Configurable para distintos ambientes

## Coding Standards

- PHP: PHP-CS-Fixer (config en `pint.json`)
- JS: ESLint con config estándar
- Estilos: SCSS con estructura SMACSS

## Contribución

1. Haz fork del proyecto
2. Crea feature branch (`feat/my-feature`)
3. Envía Pull Request

## Licencia

GPL-3.0. Ver [LICENSE](LICENSE) para detalles.

## Changelog

Ver [CHANGELOG.md](CHANGELOG.md) para historial de versiones.
