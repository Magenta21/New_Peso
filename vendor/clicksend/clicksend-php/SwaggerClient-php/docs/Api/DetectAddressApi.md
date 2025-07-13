# Swagger\Client\DetectAddressApi

All URIs are relative to *https://rest.clicksend.com/v3*

Method | HTTP request | Description
------------- | ------------- | -------------
[**detectAddressPost**](DetectAddressApi.md#detectAddressPost) | **POST** /post/letters/detect-address | Detects address in uploaded file.


# **detectAddressPost**
> string detectAddressPost($content)

Detects address in uploaded file.

Detects address in uploaded file.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\DetectAddressApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$content = "content_example"; // string | Base64-encoded file contents

try {
    $result = $apiInstance->detectAddressPost($content);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DetectAddressApi->detectAddressPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **content** | **string**| Base64-encoded file contents |

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

