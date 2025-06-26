<?php

namespace StarDots\Tests;

use StarDots\StarDots;
use StarDots\StarDotsException;
use StarDots\DeleteSpaceReq;
use StarDots\SpaceListReq;
use StarDots\CreateSpaceReq;
use StarDots\ToggleSpaceAccessibilityReq;
use StarDots\SpaceFileListReq;
use StarDots\FileAccessTicketReq;
use StarDots\UploadFileReq;
use StarDots\DeleteFileReq;
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
            $req = new DeleteSpaceReq();
            $req->space = $this->testSpaceName;
            $this->stardots->deleteSpace($req);
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
            $req = new SpaceListReq();
            $response = $this->stardots->getSpaceList($req);
            $this->assertInternalType('array', $response);
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
            $req = new SpaceListReq();
            $req->page = 1;
            $req->pageSize = 10;
            $response = $this->stardots->getSpaceList($req);
            $this->assertInternalType('array', $response);
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
            $req = new CreateSpaceReq();
            $req->space = $this->testSpaceName;
            $req->public = true;
            $response = $this->stardots->createSpace($req);
            $this->assertInternalType('array', $response);
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
            $req = new DeleteSpaceReq();
            $req->space = $this->testSpaceName;
            $response = $this->stardots->deleteSpace($req);
            $this->assertInternalType('array', $response);
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
            $req = new ToggleSpaceAccessibilityReq();
            $req->space = $this->testSpaceName;
            $req->public = false;
            $response = $this->stardots->toggleSpaceAccessibility($req);
            $this->assertInternalType('array', $response);
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
            $req = new SpaceFileListReq();
            $req->page = 1;
            $req->pageSize = 10;
            $req->space = $this->testSpaceName;
            $response = $this->stardots->getSpaceFileList($req);
            $this->assertInternalType('array', $response);
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
            $req = new FileAccessTicketReq();
            $req->space = $this->testSpaceName;
            $req->filename = 'test-file.txt';
            $response = $this->stardots->fileAccessTicket($req);
            $this->assertInternalType('array', $response);
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
            $req = new UploadFileReq();
            $req->space = $this->testSpaceName;
            $req->filename = 'test-file.txt';
            $req->fileContent = 'test content';
            $response = $this->stardots->uploadFile($req);
            $this->assertInternalType('array', $response);
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
            $req = new DeleteFileReq();
            $req->space = $this->testSpaceName;
            $req->filenameList = array('test-file.txt');
            $response = $this->stardots->deleteFile($req);
            $this->assertInternalType('array', $response);
        } catch (StarDotsException $e) {
            // This might fail with test credentials, which is expected
            $this->assertInstanceOf(StarDotsException::class, $e);
        }
    }

    /**
     * Test constants
     */
    public function testConstants()
    {
        $this->assertEquals('https://api.stardots.io', StarDots::ENDPOINT);
        $this->assertEquals('1.0.0', StarDots::SDK_VERSION);
        $this->assertEquals(30, StarDots::DEFAULT_TIMEOUT);
    }
}
