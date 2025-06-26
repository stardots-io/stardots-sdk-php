<?php

/**
 * File operations example for StarDots PHP SDK
 * 
 * This example demonstrates how to perform file operations
 * such as upload, download, and delete files.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use StarDots\StarDots;
use StarDots\StarDotsException;

// Your StarDots credentials
$clientKey = "Your client key";
$clientSecret = "Your client secret";

// Initialize the SDK
$stardots = new StarDots($clientKey, $clientSecret);

echo "=== StarDots PHP SDK File Operations Example ===\n\n";

try {
    $spaceName = 'demo-' . time(); // Use timestamp to make it unique
    
    // Step 1: Create a space for file operations
    echo "1. Creating space '{$spaceName}' for file operations...\n";
    $createSpaceParams = new CreateSpaceReq();
    $createSpaceParams->space = $spaceName;
    $createSpaceParams->public = true;
    $createSpaceResponse = $stardots->createSpace($createSpaceParams);
    echo "   Response: " . json_encode($createSpaceResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    // Step 2: Upload a file
    echo "2. Uploading a test file...\n";
    
    // Create a simple test file content
    $testContent = "This is a test file created at " . date('Y-m-d H:i:s') . "\n";
    $testContent .= "This file is uploaded using StarDots PHP SDK.\n";
    
    $uploadParams = [
        'space' => $spaceName,
        'filename' => 'test-file.txt',
        'fileContent' => $testContent
    ];
    $uploadResponse = $stardots->uploadFile($uploadParams);
    echo "   Response: " . json_encode($uploadResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    // Step 3: Get file list
    echo "3. Getting file list in space '{$spaceName}'...\n";
    $fileListParams = [
        'page' => 1,
        'pageSize' => 10,
        'space' => $spaceName
    ];
    $fileListResponse = $stardots->getSpaceFileList($fileListParams);
    echo "   Response: " . json_encode($fileListResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    // Step 4: Get file access ticket (for private spaces)
    echo "4. Getting file access ticket...\n";
    $ticketParams = [
        'space' => $spaceName,
        'filename' => 'test-file.txt'
    ];
    $ticketResponse = $stardots->fileAccessTicket($ticketParams);
    echo "   Response: " . json_encode($ticketResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    // Step 5: Upload another file
    echo "5. Uploading another test file...\n";
    $testContent2 = "This is another test file created at " . date('Y-m-d H:i:s') . "\n";
    
    $uploadParams2 = [
        'space' => $spaceName,
        'filename' => 'test-file-2.txt',
        'fileContent' => $testContent2
    ];
    $uploadResponse2 = $stardots->uploadFile($uploadParams2);
    echo "   Response: " . json_encode($uploadResponse2, JSON_PRETTY_PRINT) . "\n\n";
    
    // Step 6: Delete files
    echo "6. Deleting files...\n";
    $deleteParams = [
        'space' => $spaceName,
        'filenameList' => ['test-file.txt', 'test-file-2.txt']
    ];
    $deleteResponse = $stardots->deleteFile($deleteParams);
    echo "   Response: " . json_encode($deleteResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    // Step 7: Verify files are deleted
    echo "7. Verifying files are deleted...\n";
    $fileListResponse2 = $stardots->getSpaceFileList($fileListParams);
    echo "   Response: " . json_encode($fileListResponse2, JSON_PRETTY_PRINT) . "\n\n";
    
    // Step 8: Clean up - delete the space
    echo "8. Cleaning up - deleting the space...\n";
    $deleteSpaceParams = [
        'space' => $spaceName
    ];
    $deleteSpaceResponse = $stardots->deleteSpace($deleteSpaceParams);
    echo "   Response: " . json_encode($deleteSpaceResponse, JSON_PRETTY_PRINT) . "\n\n";
    
    echo "=== File operations example completed successfully! ===\n";
    
} catch (StarDotsException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} catch (Exception $e) {
    echo "Unexpected error: " . $e->getMessage() . "\n";
} 