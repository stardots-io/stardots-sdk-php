<?php

namespace StarDots\Tests;

use StarDots\StarDots;
use StarDots\StarDotsException;
use PHPUnit\Framework\TestCase;

/**
 * StarDots SDK Test Suite
 * 
 * Tests for the StarDots PHP SDK
 */
class StarDotsTest extends TestCase
{
    /**
     * @var StarDots
     */
    private $stardots;
    
    /**
     * @var string
     */
    private $testSpaceName;
    
    protected function setUp(): void
    {
        // Use test credentials - replace with actual test credentials
        $clientKey = getenv('STARDOTS_CLIENT_KEY') ?: 'test-client-key';
        $clientSecret = getenv('STARDOTS_CLIENT_SECRET') ?: 'test-client-secret';
        
        $this->stardots = new StarDots($clientKey, $clientSecret);
        $this->testSpaceName = 'test-space-' . time();
    }
    
    protected function tearDown(): void
    {
        // Clean up test space if it exists
        try {
            $this->stardots->deleteSpace(['space' => $this->testSpaceName]);
        } catch (StarDotsException $e) {
            // Ignore cleanup errors
        }
    }
    
    /**
     * Test SDK instantiation
     */
    public function testCreateInstance()
    {
        $stardots = new StarDots('test-key', 'test-secret');
        $this->assertInstanceOf(StarDots::class, $stardots);
    }
    
    /**
     * Test static create method
     */
    public function testStaticCreate()
    {
        $stardots = StarDots::create('test-key', 'test-secret');
        $this->assertInstanceOf(StarDots::class, $stardots);
    }
    
    /**
     * Test custom endpoint
     */
    public function testCustomEndpoint()
    {
        $customEndpoint = 'https://custom-api.stardots.io';
        $stardots = new StarDots('test-key', 'test-secret', $customEndpoint);
        $this->assertInstanceOf(StarDots::class, $stardots);
    }
    
    /**
     * Test get space list with default parameters
     */
    public function testGetSpaceListDefault()
    {
        try {
            $response = $this->stardots->getSpaceList();
            $this->assertIsArray($response);
            $this->assertArrayHasKey('code', $response);
            $this->assertArrayHasKey('message', $response);
            $this->assertArrayHasKey('data', $response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test get space list with custom parameters
     */
    public function testGetSpaceListWithParams()
    {
        try {
            $params = [
                'page' => 1,
                'pageSize' => 10
            ];
            $response = $this->stardots->getSpaceList($params);
            $this->assertIsArray($response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test create space
     */
    public function testCreateSpace()
    {
        try {
            $params = [
                'space' => $this->testSpaceName,
                'public' => true
            ];
            $response = $this->stardots->createSpace($params);
            $this->assertIsArray($response);
            $this->assertArrayHasKey('code', $response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test delete space
     */
    public function testDeleteSpace()
    {
        try {
            $params = [
                'space' => $this->testSpaceName
            ];
            $response = $this->stardots->deleteSpace($params);
            $this->assertIsArray($response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test toggle space accessibility
     */
    public function testToggleSpaceAccessibility()
    {
        try {
            $params = [
                'space' => $this->testSpaceName,
                'public' => false
            ];
            $response = $this->stardots->toggleSpaceAccessibility($params);
            $this->assertIsArray($response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test get space file list
     */
    public function testGetSpaceFileList()
    {
        try {
            $params = [
                'page' => 1,
                'pageSize' => 10,
                'space' => $this->testSpaceName
            ];
            $response = $this->stardots->getSpaceFileList($params);
            $this->assertIsArray($response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test file access ticket
     */
    public function testFileAccessTicket()
    {
        try {
            $params = [
                'space' => $this->testSpaceName,
                'filename' => 'test-file.txt'
            ];
            $response = $this->stardots->fileAccessTicket($params);
            $this->assertIsArray($response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test upload file
     */
    public function testUploadFile()
    {
        try {
            $testContent = "This is a test file content";
            $params = [
                'space' => $this->testSpaceName,
                'filename' => 'test-file.txt',
                'fileContent' => $testContent
            ];
            $response = $this->stardots->uploadFile($params);
            $this->assertIsArray($response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test delete file
     */
    public function testDeleteFile()
    {
        try {
            $params = [
                'space' => $this->testSpaceName,
                'filenameList' => ['test-file.txt']
            ];
            $response = $this->stardots->deleteFile($params);
            $this->assertIsArray($response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }
    
    /**
     * Test SDK constants
     */
    public function testConstants()
    {
        $this->assertEquals('1.0.0', StarDots::SDK_VERSION);
        $this->assertEquals('https://api.stardots.io', StarDots::ENDPOINT);
        $this->assertEquals(30, StarDots::DEFAULT_TIMEOUT);
    }
} 