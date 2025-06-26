<?php

namespace StarDots;

/**
 * CommonResponse
 * All interface responses maintain a unified data structure
 */
class CommonResponse
{
    /** @var int Service response code. */
    public int $code;
    /** @var string Message prompt of the operation result. */
    public string $message;
    /** @var string A unique number for the request, which can be used for troubleshooting. */
    public string $requestId;
    /** @var bool Indicates whether the business operation is successful. */
    public bool $success;
    /** @var int Server millisecond timestamp. */
    public int $timestamp;
    /** @var mixed Business data field. This field can be of any data type. For specific data types, please refer to the corresponding interface. */
    public $data;
}

/**
 * Paginator request parameters
 */
class PaginationReq
{
    /** @var int Page number, default value is 1. */
    public int $page = 1;
    /** @var int The number of entries per page ranges from 1 to 100, and the default value is 20. */
    public int $pageSize = 20;
}

/**
 * Paginator response data structure
 */
class PaginationResp
{
    /** @var int Page number, default value is 1. */
    public int $page;
    /** @var int The number of entries per page ranges from 1 to 100, and the default value is 20. */
    public int $pageSize;
    /** @var int The total number of entries. */
    public int $totalCount;
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
    public string $name;
    /** @var bool Whether the accessibility of the space is false. */
    public bool $public;
    /** @var int The system timestamp in seconds when the space was created. The time zone is UTC+8. */
    public int $createdAt;
    /** @var int The number of files in this space. */
    public int $fileCount;
}

/**
 * Get space list response data structure
 */
class SpaceListResp extends CommonResponse
{
    /** @var SpaceInfo[] */
    public array $data = [];
}

/**
 * Create space request parameters
 */
class CreateSpaceReq
{
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public string $space;
    /** @var bool Specifies whether the space is publicly accessible. The default value is false. */
    public bool $public = false;
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
    public string $space;
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
    public string $space;
    /** @var bool Specifies whether the space is publicly accessible. The default value is false. */
    public bool $public;
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
    public string $space;
}

/**
 * File information data structure
 */
class FileInfo
{
    /** @var string The name of the file. */
    public string $name;
    /** @var int The size of the file in bytes. */
    public int $byteSize;
    /** @var string File size, formatted for readability. */
    public string $size;
    /** @var int The timestamp of the file upload in seconds. The time zone is UTC+8. */
    public int $uploadedAt;
    /** @var string The access address of the file. Note that if the accessibility of the space is private, this field value will carry the access ticket, which is valid for 20 seconds. */
    public string $url;
}

/**
 * Get space file list response data structure
 */
class SpaceFileListResp extends CommonResponse
{
    /** @var array{list: FileInfo[]} */
    public array $data = ['list' => []];
}

/**
 * Get file access ticket request parameters
 */
class FileAccessTicketReq
{
    /** @var string The name of the file. */
    public string $filename;
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public string $space;
}

/**
 * Get file access ticket response data structure
 */
class FileAccessTicketResp extends CommonResponse
{
    /** @var array{ticket: string} */
    public array $data = ['ticket' => ''];
}

/**
 * Upload file request parameters
 */
class UploadFileReq
{
    /** @var string The name of the file. */
    public string $filename;
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public string $space;
    /** @var string|resource The file bytes content */
    public $fileContent;
}

/**
 * Upload file response data structure
 */
class UploadFileResp extends CommonResponse
{
    /** @var array{space: string, filename: string, url: string} */
    public array $data = [
        'space' => '',
        'filename' => '',
        'url' => ''
    ];
}

/**
 * Delete file request parameters
 */
class DeleteFileReq
{
    /** @var string[] The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public array $filenameList = [];
    /** @var string The name of the space. It can only be a combination of letters or numbers, and the length is 4 to 15 characters. */
    public string $space;
}

/**
 * Delete file response data structure
 */
class DeleteFileResp extends CommonResponse {} 