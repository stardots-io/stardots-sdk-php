<?php

namespace StarDots;

/**
 * StarDots PHP SDK
 *
 * This SDK provides easy access to the StarDots platform APIs.
 * Compatible with PHP 5.5+
 */
class StarDots
{
    /**
     * SDK Version
     */
    const SDK_VERSION = '1.0.0';

    /**
     * Default API endpoint
     */
    const ENDPOINT = 'https://api.stardots.io';

    /**
     * Default request timeout in seconds
     */
    const DEFAULT_TIMEOUT = 30;

    /**
     * @var string API endpoint
     */
    private $endpoint;

    /**
     * @var string Client key
     */
    private $clientKey;

    /**
     * @var string Client secret
     */
    private $clientSecret;

    /**
     * Constructor
     *
     * @param string $clientKey Your client key
     * @param string $clientSecret Your client secret
     * @param string|null $endpoint Optional custom endpoint
     */
    public function __construct($clientKey, $clientSecret, $endpoint = null)
    {
        $this->clientKey = $clientKey;
        $this->clientSecret = $clientSecret;
        $this->endpoint = $endpoint ?: self::ENDPOINT;
    }

    /**
     * Create a new StarDots instance
     *
     * @param string $clientKey Your client key
     * @param string $clientSecret Your client secret
     * @param string|null $endpoint Optional custom endpoint
     * @return static
     */
    public static function create($clientKey, $clientSecret, $endpoint = null)
    {
        return new static($clientKey, $clientSecret, $endpoint);
    }

    /**
     * Get space list data
     *
     * @param SpaceListReq $params Request parameters
     * @return SpaceListResp Response data
     * @throws StarDotsException
     */
    public function getSpaceList(SpaceListReq $params)
    {
        $query = http_build_query([
            'page' => $params->page,
            'pageSize' => $params->pageSize
        ]);
        $url = $this->endpoint . '/openapi/space/list?' . $query;
        $respArr = $this->sendRequest('GET', $url);
        return $this->mapToType($respArr, SpaceListResp::class);
    }

    /**
     * Create a new space
     *
     * @param CreateSpaceReq $params Request parameters
     * @return CreateSpaceResp Response data
     * @throws StarDotsException
     */
    public function createSpace(CreateSpaceReq $params)
    {
        $url = $this->endpoint . '/openapi/space/create';
        $respArr = $this->sendRequest('PUT', $url, [
            'space' => $params->space,
            'public' => $params->public
        ]);
        return $this->mapToType($respArr, CreateSpaceResp::class);
    }

    /**
     * Delete an existing space
     *
     * @param DeleteSpaceReq $params Request parameters
     * @return DeleteSpaceResp Response data
     * @throws StarDotsException
     */
    public function deleteSpace(DeleteSpaceReq $params)
    {
        $url = $this->endpoint . '/openapi/space/delete';
        $respArr = $this->sendRequest('DELETE', $url, [
            'space' => $params->space
        ]);
        return $this->mapToType($respArr, DeleteSpaceResp::class);
    }

    /**
     * Toggle the accessibility of a space
     *
     * @param ToggleSpaceAccessibilityReq $params Request parameters
     * @return ToggleSpaceAccessibilityResp Response data
     * @throws StarDotsException
     */
    public function toggleSpaceAccessibility(ToggleSpaceAccessibilityReq $params)
    {
        $url = $this->endpoint . '/openapi/space/accessibility/toggle';
        $respArr = $this->sendRequest('POST', $url, [
            'space' => $params->space,
            'public' => $params->public
        ]);
        return $this->mapToType($respArr, ToggleSpaceAccessibilityResp::class);
    }

    /**
     * Get the list of files in the space
     *
     * @param SpaceFileListReq $params Request parameters
     * @return SpaceFileListResp Response data
     * @throws StarDotsException
     */
    public function getSpaceFileList(SpaceFileListReq $params)
    {
        $query = http_build_query([
            'page' => $params->page,
            'pageSize' => $params->pageSize,
            'space' => $params->space
        ]);
        $url = $this->endpoint . '/openapi/file/list?' . $query;
        $respArr = $this->sendRequest('GET', $url);
        return $this->mapToType($respArr, SpaceFileListResp::class);
    }

    /**
     * Get the access ticket for the file
     *
     * @param FileAccessTicketReq $params Request parameters
     * @return FileAccessTicketResp Response data
     * @throws StarDotsException
     */
    public function fileAccessTicket(FileAccessTicketReq $params)
    {
        $url = $this->endpoint . '/openapi/file/ticket';
        $respArr = $this->sendRequest('POST', $url, [
            'space' => $params->space,
            'filename' => $params->filename
        ]);
        return $this->mapToType($respArr, FileAccessTicketResp::class);
    }

    /**
     * Upload file to the space
     *
     * @param UploadFileReq $params Request parameters
     * @return UploadFileResp Response data
     * @throws StarDotsException
     */
    public function uploadFile(UploadFileReq $params)
    {
        $url = $this->endpoint . '/openapi/file/upload';
        $respArr = $this->sendMultipartRequest('PUT', $url, [
            'space' => $params->space,
            'filename' => $params->filename,
            'fileContent' => $params->fileContent
        ]);
        return $this->mapToType($respArr, UploadFileResp::class);
    }

    /**
     * Delete files in the space
     *
     * @param DeleteFileReq $params Request parameters
     * @return DeleteFileResp Response data
     * @throws StarDotsException
     */
    public function deleteFile(DeleteFileReq $params)
    {
        $url = $this->endpoint . '/openapi/file/delete';
        $respArr = $this->sendRequest('DELETE', $url, [
            'space' => $params->space,
            'filenameList' => $params->filenameList
        ]);
        return $this->mapToType($respArr, DeleteFileResp::class);
    }

    /**
     * Send HTTP request
     *
     * @param string $method HTTP method
     * @param string $url Request URL
     * @param array|null $data Request data
     * @return array Response data
     * @throws StarDotsException
     */
    private function sendRequest($method, $url, $data = null)
    {
        $headers = $this->makeHeaders();

        if ($data !== null) {
            $headers['Content-Type'] = 'application/json; charset=utf-8';
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::DEFAULT_TIMEOUT);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($headers));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new StarDotsException('cURL error: ' . $error);
        }

        $responseData = json_decode($response, true);
        if ($responseData === null) {
            throw new StarDotsException('Invalid JSON response: ' . $response);
        }

        return $responseData;
    }

    /**
     * Send multipart form request for file upload
     *
     * @param string $method HTTP method
     * @param string $url Request URL
     * @param array $params Request parameters
     * @return array Response data
     * @throws StarDotsException
     */
    private function sendMultipartRequest($method, $url, array $params)
    {
        $headers = $this->makeHeaders();

        $boundary = '----WebKitFormBoundary' . uniqid();
        $headers['Content-Type'] = 'multipart/form-data; boundary=' . $boundary;

        $postData = '';

        // Add file
        if (isset($params['fileContent']) && isset($params['filename'])) {
            $postData .= "--{$boundary}\r\n";
            $postData .= "Content-Disposition: form-data; name=\"file\"; filename=\"{$params['filename']}\"\r\n";
            $postData .= "Content-Type: application/octet-stream\r\n\r\n";
            $postData .= $params['fileContent'] . "\r\n";
        }

        // Add space parameter
        if (isset($params['space'])) {
            $postData .= "--{$boundary}\r\n";
            $postData .= "Content-Disposition: form-data; name=\"space\"\r\n\r\n";
            $postData .= $params['space'] . "\r\n";
        }

        $postData .= "--{$boundary}--\r\n";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::DEFAULT_TIMEOUT);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($headers));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new StarDotsException('cURL error: ' . $error);
        }

        $responseData = json_decode($response, true);
        if ($responseData === null) {
            throw new StarDotsException('Invalid JSON response: ' . $response);
        }

        return $responseData;
    }

    /**
     * Generate authentication headers
     *
     * @return array Headers array
     */
    private function makeHeaders()
    {
        $timestamp = time();
        $nonce = $timestamp * 1000 + rand(10000, 19999);
        $needSignStr = $timestamp . '|' . $this->clientSecret . '|' . $nonce;
        $sign = strtoupper(md5($needSignStr));

        $extra = json_encode([
            'sdk' => 'true',
            'language' => 'php',
            'version' => self::SDK_VERSION,
            'os' => PHP_OS,
            'arch' => php_uname('m')
        ]);

        return [
            'x-stardots-timestamp' => (string)$timestamp,
            'x-stardots-nonce' => (string)$nonce,
            'x-stardots-key' => $this->clientKey,
            'x-stardots-sign' => $sign,
            'x-stardots-extra' => $extra
        ];
    }

    /**
     * Format headers for cURL
     *
     * @param array $headers Headers array
     * @return array Formatted headers
     */
    private function formatHeaders(array $headers)
    {
        $formatted = [];
        foreach ($headers as $key => $value) {
            $formatted[] = $key . ': ' . $value;
        }
        return $formatted;
    }

    /**
     * Convert array to type object
     */
    private function mapToType(array $data, $type)
    {
        $obj = new $type();
        foreach ($data as $k => $v) {
            if (property_exists($obj, $k)) {
                $obj->$k = $v;
            }
        }
        return $obj;
    }
}
