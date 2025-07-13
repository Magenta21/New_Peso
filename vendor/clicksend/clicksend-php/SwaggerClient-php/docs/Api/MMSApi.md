# Swagger\Client\MMSApi

All URIs are relative to *https://rest.clicksend.com/v3*

Method | HTTP request | Description
------------- | ------------- | -------------
[**mmsPricePost**](MMSApi.md#mmsPricePost) | **POST** /mms/price | Get Price for MMS sent
[**mmsSendPost**](MMSApi.md#mmsSendPost) | **POST** /mms/send | Send MMS


# **mmsPricePost**
> string mmsPricePost($mms_messages)

Get Price for MMS sent

Get Price for MMS sent

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\MMSApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$mms_messages = new \Swagger\Client\Model\MmsMessageCollection(); // \Swagger\Client\Model\MmsMessageCollection | MmsMessageCollection model

try {
    $result = $apiInstance->mmsPricePost($mms_messages);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MMSApi->mmsPricePost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **mms_messages** | [**\Swagger\Client\Model\MmsMessageCollection**](../Model/MmsMessageCollection.md)| MmsMessageCollection model |

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **mmsSendPost**
> string mmsSendPost($mms_messages)

Send MMS

Send MMS

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\MMSApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$mms_messages = new \Swagger\Client\Model\MmsMessageCollection(); // \Swagger\Client\Model\MmsMessageCollection | MmsMessageCollection model

try {
    $result = $apiInstance->mmsSendPost($mms_messages);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MMSApi->mmsSendPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **mms_messages** | [**\Swagger\Client\Model\MmsMessageCollection**](../Model/MmsMessageCollection.md)| MmsMessageCollection model |

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

