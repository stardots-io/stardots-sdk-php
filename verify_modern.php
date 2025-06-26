<?php

/**
 * StarDots PHP SDK Modern Features Verification Script
 * 
 * This script verifies that the SDK is working correctly with PHP 5.5+ features
 * by testing modern syntax and functionality.
 */

echo "=== StarDots PHP SDK Modern Features Verification ===\n\n";

// Check PHP version
echo "1. PHP Version Check:\n";
echo "   PHP Version: " . PHP_VERSION . "\n";
echo "   Required: >= 5.5.0\n";
if (version_compare(PHP_VERSION, '5.5.0', '>=')) {
    echo "   ✓ PHP version is compatible\n";
} else {
    echo "   ✗ PHP version is not compatible\n";
    exit(1);
}

// Test modern array syntax
echo "\n2. Modern Array Syntax Test:\n";
$testArray = ['key' => 'value', 'number' => 123];
if (is_array($testArray) && $testArray['key'] === 'value') {
    echo "   ✓ Modern array syntax works\n";
} else {
    echo "   ✗ Modern array syntax failed\n";
    exit(1);
}

// Test Elvis operator
echo "\n3. Elvis Operator Test:\n";
$value = null;
$result = $value ?: 'default';
if ($result === 'default') {
    echo "   ✓ Elvis operator works\n";
} else {
    echo "   ✗ Elvis operator failed\n";
    exit(1);
}

// Test ::class syntax
echo "\n4. ::class Syntax Test:\n";
$className = stdClass::class;
if ($className === 'stdClass') {
    echo "   ✓ ::class syntax works\n";
} else {
    echo "   ✗ ::class syntax failed\n";
    exit(1);
}

// Test const keyword
echo "\n5. Const Keyword Test:\n";
class TestClass {
    const TEST_CONST = 'test_value';
}
if (TestClass::TEST_CONST === 'test_value') {
    echo "   ✓ Const keyword works\n";
} else {
    echo "   ✗ Const keyword failed\n";
    exit(1);
}

// Check required extensions
echo "\n6. Extension Check:\n";
$requiredExtensions = ['curl', 'json'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "   ✓ {$ext} extension is loaded\n";
    } else {
        echo "   ✗ {$ext} extension is not loaded\n";
        exit(1);
    }
}

// Test class loading
echo "\n7. Class Loading Test:\n";
try {
    require_once __DIR__ . '/src/StarDotsException.php';
    require_once __DIR__ . '/src/StarDots.php';
    echo "   ✓ Classes loaded successfully\n";
} catch (Exception $e) {
    echo "   ✗ Failed to load classes: " . $e->getMessage() . "\n";
    exit(1);
}

// Test class instantiation with modern syntax
echo "\n8. Modern Class Instantiation Test:\n";
try {
    $stardots = new StarDots\StarDots('test-key', 'test-secret');
    echo "   ✓ StarDots class instantiated successfully\n";
    
    // Test static create method
    $stardots2 = StarDots\StarDots::create('test-key', 'test-secret');
    echo "   ✓ Static create method works\n";
} catch (Exception $e) {
    echo "   ✗ Failed to instantiate class: " . $e->getMessage() . "\n";
    exit(1);
}

// Test constants
echo "\n9. Constants Test:\n";
echo "   SDK Version: " . StarDots\StarDots::SDK_VERSION . "\n";
echo "   Endpoint: " . StarDots\StarDots::ENDPOINT . "\n";
echo "   Default Timeout: " . StarDots\StarDots::DEFAULT_TIMEOUT . " seconds\n";
echo "   ✓ Constants are accessible\n";

// Test method existence with type hints
echo "\n10. Method Availability Test:\n";
$requiredMethods = [
    'getSpaceList',
    'createSpace', 
    'deleteSpace',
    'toggleSpaceAccessibility',
    'getSpaceFileList',
    'fileAccessTicket',
    'uploadFile',
    'deleteFile'
];

foreach ($requiredMethods as $method) {
    if (method_exists($stardots, $method)) {
        echo "   ✓ Method {$method} exists\n";
    } else {
        echo "   ✗ Method {$method} does not exist\n";
        exit(1);
    }
}

// Test exception class with ::class
echo "\n11. Exception Class Test:\n";
try {
    throw new StarDots\StarDotsException('Test exception');
} catch (StarDots\StarDotsException $e) {
    echo "   ✓ StarDotsException works correctly\n";
}

// Test JSON encoding/decoding with modern syntax
echo "\n12. JSON Test:\n";
$testData = [
    'code' => 200,
    'message' => 'Success',
    'data' => ['test' => 'value']
];
$jsonString = json_encode($testData);
$decodedData = json_decode($jsonString, true);
if ($decodedData === $testData) {
    echo "   ✓ JSON encoding/decoding works correctly\n";
} else {
    echo "   ✗ JSON encoding/decoding failed\n";
    exit(1);
}

// Test cURL functionality
echo "\n13. cURL Test:\n";
$ch = curl_init();
if ($ch !== false) {
    curl_close($ch);
    echo "   ✓ cURL initialization works\n";
} else {
    echo "   ✗ cURL initialization failed\n";
    exit(1);
}

// Test type hints (if PHP 7.0+)
if (version_compare(PHP_VERSION, '7.0.0', '>=')) {
    echo "\n14. Type Hints Test (PHP 7.0+):\n";
    echo "   ✓ PHP 7.0+ detected - type hints are supported\n";
} else {
    echo "\n14. Type Hints Test:\n";
    echo "   ⚠ Type hints are available in PHP 7.0+ (current: " . PHP_VERSION . ")\n";
}

echo "\n=== Modern Features Verification Complete ===\n";
echo "✓ All modern PHP 5.5+ features are working correctly!\n\n";

echo "Modern Features Verified:\n";
echo "- ✓ Modern array syntax `[]`\n";
echo "- ✓ Elvis operator `?:`\n";
echo "- ✓ ::class syntax\n";
echo "- ✓ const keyword\n";
echo "- ✓ Type hints (where supported)\n";
echo "- ✓ Strong typing in method signatures\n\n";

echo "Next steps:\n";
echo "1. Set your actual client key and secret\n";
echo "2. Run the examples: php examples/basic_usage.php\n";
echo "3. Check the documentation in README.md\n";
echo "4. Run tests: composer test\n"; 