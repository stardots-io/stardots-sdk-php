<?php

namespace StarDots;

/**
 * CommonResponse
 * All interface responses maintain a unified data structure
 */
class CommonResponse
{
    /** @var int Service response code. */
    public $code;
    /** @var string Message prompt of the operation result. */
    public $message;
    /** @var string A unique number for the request, which can be used for troubleshooting. */
    public $requestId;
    /** @var bool Indicates whether the business operation is successful. */
    public $success;
    /** @var int Server millisecond timestamp. */
    public $timestamp;
    /** @var mixed Business data field. This field can be of any data type. For specific data types, please refer to the corresponding interface. */
    public $data;
}

/**
 * Paginator request parameters
 */
class PaginationReq
{
    /** @var int Page number, default value is 1. */
    public $page = 1;
    /** @var int The number of entries per page ranges from 1 to 100, and the default value is 20. */
    public $pageSize = 20;
}

/**
 * Paginator response data structure
 */
class PaginationResp
{
    /** @var int Page number, default value is 1. */
    public $page;
    /** @var int The number of entries per page ranges from 1 to 100, and the default value is 20. */
    public $pageSize;
    /** @var int The total number of entries. */
    public $totalCount;
}

/**
 * Get space list request parameters
 */
class SpaceListReq extends PaginationReq {}

/**
 * Space information data structure
 */
class SpaceInfo
{
    /** @var string The name of the space. */
    public $name;
    /** @var bool Whether the accessibility of the space is false. */
    public $public;
    /** @var int The system timestamp in seconds when the space was created. The time zone is UTC+8. */
    public $createdAt;
    /** @var int The number of files in this space. */
    public $fileCount;
}

/**
 * Get space list response data structure
 */
class SpaceListResp extends CommonResponse
{
    /** @var SpaceInfo[] */
    public $data = [];
}

/**
 * Create space request parameters
 */
class CreateSpaceReq
{
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public $space;
    /** @var bool Specifies whether the space is publicly accessible. The default value is false. */
    public $public = false;
}

/**
 * Create space response data structure
 */
class CreateSpaceResp extends CommonResponse {}

/**
 * Delete space request parameters
 */
class DeleteSpaceReq
{
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public $space;
}

/**
 * Delete space response data structure
 */
class DeleteSpaceResp extends CommonResponse {}

/**
 * ToggleSpaceAccessibility space request parameters
 */
class ToggleSpaceAccessibilityReq
{
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public $space;
    /** @var bool Specifies whether the space is publicly accessible. The default value is false. */
    public $public;
}

/**
 * ToggleSpaceAccessibility space response data structure
 */
class ToggleSpaceAccessibilityResp extends CommonResponse {}

/**
 * Get space file list request parameters
 */
class SpaceFileListReq extends PaginationReq
{
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public $space;
}

/**
 * File information data structure
 */
class FileInfo
{
    /** @var string The name of the file. */
    public $name;
    /** @var int The size of the file in bytes. */
    public $byteSize;
    /** @var string File size, formatted for readability. */
    public $size;
    /** @var int The timestamp of the file upload in seconds. The time zone is UTC+8. */
    public $uploadedAt;
    /** @var string The access address of the file. Note that if the accessibility of the space is private, this field value will carry the access ticket, which is valid for 20 seconds. */
    public $url;
}

/**
 * Get space file list response data structure
 */
class SpaceFileListResp extends CommonResponse
{
    /** @var array{list: FileInfo[]} */
    public $data = array('list' => array());
}

/**
 * Get file access ticket request parameters
 */
class FileAccessTicketReq
{
    /** @var string The name of the file. */
    public $filename;
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public $space;
}

/**
 * Get file access ticket response data structure
 */
class FileAccessTicketResp extends CommonResponse
{
    /** @var array{ticket: string} */
    public $data = array('ticket' => '');
}

/**
 * Upload file request parameters
 */
class UploadFileReq
{
    /** @var string The name of the file. */
    public $filename;
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public $space;
    /** @var string|resource The file bytes content */
    public $fileContent;
}

/**
 * Upload file response data structure
 */
class UploadFileResp extends CommonResponse
{
    /** @var array{space: string, filename: string, url: string} */
    public $data = array(
        'space' => '',
        'filename' => '',
        'url' => ''
    );
}

/**
 * Delete file request parameters
 */
class DeleteFileReq
{
    /** @var string[] The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public $filenameList = array();
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public $space;
}

/**
 * Delete file response data structure
 */
class DeleteFileResp extends CommonResponse {} 