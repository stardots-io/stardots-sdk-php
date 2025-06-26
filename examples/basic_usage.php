<?php

/**
 * Basic usage example for StarDots PHP SDK
 * 
 * This example demonstrates how to use the StarDots SDK
 * to interact with the StarDots platform APIs.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use StarDots\StarDots;
use StarDots\StarDotsException;

// Your StarDots credentials
$clientKey = "Your client key";
$clientSecret = "Your client secret";

// Initialize the SDK
$stardots = new StarDots($clientKey, $clientSecret);

echo "=== StarDots PHP SDK Basic Usage Example ===\n\n";

try {
    // Example 1: Get space list
    echo "1. Getting space list...\n";
    $spaceListParams = new SpaceListReq();
    $spaceListParams->page = 1;
    $spaceListParams->pageSize = 10;
    $spaceListResponse = $stardots->getSpaceList($spaceListParams);
    echo "   Response: " . json_encode($spaceListResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    // Example 2: Create a new space
    echo "2. Creating a new space...\n";
    $createSpaceParams = [
        'space' => 'demo-' . time(), // Use timestamp to make it unique
        'public' => true
    ];
    $createSpaceResponse = $stardots->createSpace($createSpaceParams);
    echo "   Response: " . json_encode($createSpaceResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    $spaceName = $createSpaceParams['space'];
    
    // Example 3: Get files in the space
    echo "3. Getting files in space '{$spaceName}'...\n";
    $fileListParams = [
        'page' => 1,
        'pageSize' => 10,
        'space' => $spaceName
    ];
    $fileListResponse = $stardots->getSpaceFileList($fileListParams);
    echo "   Response: " . json_encode($fileListResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    // Example 4: Toggle space accessibility
    echo "4. Toggling space accessibility...\n";
    $toggleParams = [
        'space' => $spaceName,
        'public' => false
    ];
    $toggleResponse = $stardots->toggleSpaceAccessibility($toggleParams);
    echo "   Response: " . json_encode($toggleResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    // Example 5: Delete the space (cleanup)
    echo "5. Deleting the space (cleanup)...\n";
    $deleteSpaceParams = [
        'space' => $spaceName
    ];
    $deleteSpaceResponse = $stardots->deleteSpace($deleteSpaceParams);
    echo "   Response: " . json_encode($deleteSpaceResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    echo "=== Example completed successfully! ===\n";
    
} catch (StarDotsException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} catch (Exception $e) {
    echo "Unexpected error: " . $e->getMessage() . "\n";
} 