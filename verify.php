<?php

/**
 * StarDots PHP SDK Verification Script
 * 
 * This script verifies that the SDK is working correctly
 * by testing basic functionality without making actual API calls.
 */

echo "=== StarDots PHP SDK Verification ===\n\n";

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

// Check required extensions
echo "\n2. Extension Check:\n";
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
echo "\n3. Class Loading Test:\n";
try {
    require_once __DIR__ . '/src/StarDotsException.php';
    require_once __DIR__ . '/src/StarDots.php';
    echo "   ✓ Classes loaded successfully\n";
} catch (Exception $e) {
    echo "   ✗ Failed to load classes: " . $e->getMessage() . "\n";
    exit(1);
}

// Test class instantiation
echo "\n4. Class Instantiation Test:\n";
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
echo "\n5. Constants Test:\n";
echo "   SDK Version: " . StarDots\StarDots::SDK_VERSION . "\n";
echo "   Endpoint: " . StarDots\StarDots::ENDPOINT . "\n";
echo "   Default Timeout: " . StarDots\StarDots::DEFAULT_TIMEOUT . " seconds\n";
echo "   ✓ Constants are accessible\n";

// Test method existence
echo "\n6. Method Availability Test:\n";
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

// Test exception class
echo "\n7. Exception Class Test:\n";
try {
    throw new StarDots\StarDotsException('Test exception');
} catch (StarDots\StarDotsException $e) {
    echo "   ✓ StarDotsException works correctly\n";
}

// Test JSON encoding/decoding
echo "\n8. JSON Test:\n";
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
echo "\n9. cURL Test:\n";
$ch = curl_init();
if ($ch !== false) {
    curl_close($ch);
    echo "   ✓ cURL initialization works\n";
} else {
    echo "   ✗ cURL initialization failed\n";
    exit(1);
}

echo "\n=== Verification Complete ===\n";
echo "✓ All tests passed! The SDK is ready to use.\n\n";

echo "Next steps:\n";
echo "1. Set your actual client key and secret\n";
echo "2. Run the examples: php examples/basic_usage.php\n";
echo "3. Check the documentation in README.md\n";
echo "4. Run tests: composer test\n"; 