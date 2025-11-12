# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

PHP PIMACO is a PHP library for generating PIMACO label PDFs using the MPDF library. It provides a fluent API for creating formatted labels ready for printing on PIMACO label sheets.

## Requirements

- PHP >= 8.1
- Composer for dependency management

## Common Commands

### Install Dependencies
```bash
composer install
```

### Run Tests
```bash
# Run all tests
./vendor/bin/phpunit

# Run specific test file
./vendor/bin/phpunit tests/src/PimacoTest.php

# Run with colors (already configured in phpunit.xml)
./vendor/bin/phpunit --colors=always
```

### Code Quality

```bash
# Run PHP_CodeSniffer to check PSR-1 and PSR-2 compliance
./vendor/bin/phpcs

# Check specific file
./vendor/bin/phpcs src/Pimaco.php

# Auto-fix coding standards issues
./vendor/bin/phpcbf
```

The project follows PSR-1 and PSR-2 coding standards with a line length limit of 220 characters.

## Architecture

### Core Classes

**Pimaco** (`src/Pimaco.php`)
- Main class that manages PDF generation using MPDF
- Loads template configuration from JSON files in `templates/` directory
- Manages page layout (margins, columns, dimensions)
- Renders tags into multi-column layouts based on template specifications
- Usage: `new Pimaco($templateCode, $customPath, $tempDir)`

**Tag** (`src/Tag.php`)
- Represents a single label on the sheet
- Container for various tag elements (text, images, barcodes, QR codes)
- Fluent interface for adding content elements
- Automatically loads dimensions and styling from template config
- Methods: `p()`, `barcode()`, `qrcode()`, `img()` for adding content

**Tag Content Elements** (`src/Tags/`)
- `P.php`: Text paragraph element
- `Barcode.php`: Barcode generation (supports multiple barcode types)
- `QrCode.php`: QR code generation with optional labels
- `Img.php`: Image embedding

### Template System

Templates are JSON configuration files in `templates/` directory that define:
- **page**: Overall page settings (size, margins, columns, font-size, orientation)
- **tag**: Individual label dimensions (width, height, border, margin-left)

Each PIMACO product code (e.g., "6182", "A4248") has a corresponding JSON file with precise measurements in millimeters.

### Data Flow

1. Instantiate `Pimaco` with template code
2. Template JSON is loaded and parsed to configure MPDF
3. Create `Tag` objects and add content elements (text, barcodes, images)
4. Add tags to Pimaco instance with `addTag()`
5. Tags are arranged in multi-column layout based on template
6. Call `output()` to generate and stream PDF, or `render()` to get HTML

### Key Design Patterns

- **Fluent Interface**: Tag and content classes support method chaining
- **Template Configuration**: External JSON files separate layout from logic
- **Dependency Injection**: MPDF instance created with config in constructor
- **ArrayObject Collections**: Tags stored in ArrayObject for iteration

## Testing

Tests are located in `tests/` directory with namespace `Proner\PhpPimacoTest`.

Test templates are in `tests/templates/` for isolated testing without production templates.

When adding new features:
- Create test templates in `tests/templates/` if testing layout logic
- Test both rendering (HTML output) and PDF generation
- Verify multi-column layouts work correctly

## Adding New Templates

1. Create JSON file in `templates/` with PIMACO product code as filename
2. Define `page` object with PDF page settings
3. Define `tag` object with individual label dimensions
4. Ensure measurements match official PIMACO specifications
5. Test with sample data to verify alignment

## Dependencies

- **mpdf/mpdf**: PDF generation engine
- **endroid/qr-code**: QR code generation
- **picqer/php-barcode-generator**: Barcode generation (supports CODE_128, EAN13, etc.)
