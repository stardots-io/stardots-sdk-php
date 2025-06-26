# StarDots PHP SDK Installation Guide

## Prerequisites

- PHP 5.5.0 or higher
- cURL extension
- JSON extension
- Composer (recommended for dependency management)

## Installation Methods

### Method 1: Using Composer (Recommended)

1. **Install Composer** (if not already installed):
   ```bash
   curl -sS https://getcomposer.org/installer | php
   mv composer.phar /usr/local/bin/composer
   ```

2. **Install the SDK**:
   ```bash
   composer require stardots-io/stardots-sdk-php
   ```

3. **Use in your project**:
   ```php
   <?php
   require_once 'vendor/autoload.php';
   
   use StarDots\StarDots;
   
   $stardots = new StarDots('your-client-key', 'your-client-secret');
   ```

### Method 2: Manual Installation

1. **Download the source code**:
   ```bash
   git clone https://github.com/stardots-io/stardots-sdk-php.git
   cd stardots-sdk-php
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Include in your project**:
   ```php
   <?php
   require_once 'path/to/stardots-sdk-php/vendor/autoload.php';
   
   use StarDots\StarDots;
   
   $stardots = new StarDots('your-client-key', 'your-client-secret');
   ```

### Method 3: Direct File Inclusion (PHP 5.5+)

If you don't want to use Composer, you can include the files directly:

```php
<?php
require_once 'src/StarDotsException.php';
require_once 'src/StarDots.php';

use StarDots\StarDots;

$stardots = new StarDots('your-client-key', 'your-client-secret');
```

## Verification

To verify the installation, run the basic example:

```bash
php examples/basic_usage.php
```

## Testing

To run the test suite:

```bash
composer test
```

Or manually:

```bash
./vendor/bin/phpunit
```

## Troubleshooting

### Common Issues

1. **cURL extension not found**:
   ```bash
   # Ubuntu/Debian
   sudo apt-get install php-curl
   
   # CentOS/RHEL
   sudo yum install php-curl
   
   # macOS with Homebrew
   brew install php
   ```

2. **JSON extension not found**:
   ```bash
   # Ubuntu/Debian
   sudo apt-get install php-json
   
   # CentOS/RHEL
   sudo yum install php-json
   ```

3. **Composer not found**:
   - Download from https://getcomposer.org/
   - Or use your system's package manager

### PHP Version Compatibility

The SDK is compatible with PHP 5.5.0 and higher. If you encounter issues:

- Check your PHP version: `php -v`
- Ensure all required extensions are loaded: `php -m | grep -E "(curl|json)"`

## Getting Help

- Documentation: https://stardots.io/en/documentation/openapi
- Issues: https://github.com/stardots-io/stardots-sdk-php/issues
- Support: support@stardots.io 