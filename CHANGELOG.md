# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2025-11-12

### Changed
- **BREAKING**: Updated minimum PHP version from 8.1 to 8.2
- Added explicit type declarations to all class properties for PHP 8.2+ compatibility
- Converted all nullable parameters to use explicit nullable syntax (`?type`)
- Added explicit type casting for JSON values to ensure type safety

### Added
- Type hints for all private properties across all classes
- Return type declarations for methods (`void`, `self`)
- Explicit float/int casting when loading configuration from JSON templates
- Default values for typed properties where appropriate

### Fixed
- PHP 8.2 deprecation warnings for implicitly nullable parameters
- PHP 8.2 deprecation warnings for dynamic properties
- Type mismatch errors when assigning string values from JSON to typed float/int properties
- Missing return statement in `Img::rotate()` method

### Removed
- Unused import `phpDocumentor\Reflection\Types\Void_` from Barcode class
- Unused imports from QrCode class (7 unused Endroid\QrCode imports)
- Redundant property initializations in constructors (moved to property declarations)
- Unnecessary return statement in Barcode and QrCode constructors

### Code Quality
- All code now complies with PSR-1 and PSR-2 standards
- Fixed whitespace issues (trailing spaces, missing newlines at end of files)
- Improved code consistency across all classes

### Testing
- All 17 existing tests pass successfully
- No deprecation warnings in test suite
- Code verified with PHP_CodeSniffer (0 errors, 0 warnings)

## [1.x] - Previous versions

For changes in version 1.x, please refer to the git history.

---

## Migration Guide from 1.x to 2.0

### PHP Version Requirement
**Before**: PHP >= 8.1
**After**: PHP >= 8.2

### Action Required
Update your `composer.json` to require PHP 8.2 or higher:
```json
{
    "require": {
        "php": ">=8.2"
    }
}
```

### API Compatibility
All public APIs remain **100% backward compatible**. No changes required to your existing code.

### What Changed Internally
- Properties now have explicit type declarations
- Better type safety prevents potential runtime errors
- Stricter type checking catches issues earlier in development

### Benefits of Upgrading
1. **Type Safety**: Explicit types catch errors at development time
2. **Performance**: Typed properties can be optimized by PHP's engine
3. **Future Proof**: Ready for PHP 8.3+ features
4. **No Warnings**: Zero deprecation notices
5. **Better IDE Support**: Improved autocomplete and static analysis
