# Swagger\Client\FaxApi

All URIs are relative to *https://rest.clicksend.com/v3*

Method | HTTP request | Description
------------- | ------------- | -------------
[**faxHistoryGet**](FaxApi.md#faxHistoryGet) | **GET** /fax/history | Get a list of Fax History.
[**faxPricePost**](FaxApi.md#faxPricePost) | **POST** /fax/price | Calculate Total Price for Fax Messages sent
[**faxReceiptsByMessageIdGet**](FaxApi.md#faxReceiptsByMessageIdGet) | **GET** /fax/receipts/{message_id} | Get a single fax receipt based on message id.
[**faxReceiptsGet**](FaxApi.md#faxReceiptsGet) | **GET** /fax/receipts | Get List of Fax Receipts
[**faxSendPost**](FaxApi.md#faxSendPost) | **POST** /fax/send | Send a fax using supplied supported file-types.


# **faxHistoryGet**
> string faxHistoryGet($date_from, $date_to, $q, $order, $page, $limit)

Get a list of Fax History.

Get a list of Fax History.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\FaxApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$date_from = 56; // int | Customize result by setting from date (timestsamp) Example: 1457572619.
$date_to = 56; // int | Customize result by setting to date (timestamp) Example: 1457573000.
$q = "q_example"; // string | Custom query Example: status:Sent,status_code:201.
$order = "order_example"; // string | Order result by Example: date_added:desc,list_id:desc.
$page = 1; // int | Page number
$limit = 10; // int | Number of records per page

try {
    $result = $apiInstance->faxHistoryGet($date_from, $date_to, $q, $order, $page, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling FaxApi->faxHistoryGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **date_from** | **int**| Customize result by setting from date (timestsamp) Example: 1457572619. | [optional]
 **date_to** | **int**| Customize result by setting to date (timestamp) Example: 1457573000. | [optional]
 **q** | **string**| Custom query Example: status:Sent,status_code:201. | [optional]
 **order** | **string**| Order result by Example: date_added:desc,list_id:desc. | [optional]
 **page** | **int**| Page number | [optional] [default to 1]
 **limit** | **int**| Number of records per page | [optional] [default to 10]

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **faxPricePost**
> string faxPricePost($fax_message)

Calculate Total Price for Fax Messages sent

Calculate Total Price for Fax Messages sent

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\FaxApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$fax_message = new \Swagger\Client\Model\FaxMessageCollection(); // \Swagger\Client\Model\FaxMessageCollection | FaxMessageCollection model

try {
    $result = $apiInstance->faxPricePost($fax_message);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling FaxApi->faxPricePost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **fax_message** | [**\Swagger\Client\Model\FaxMessageCollection**](../Model/FaxMessageCollection.md)| FaxMessageCollection model |

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **faxReceiptsByMessageIdGet**
> string faxReceiptsByMessageIdGet($message_id)

Get a single fax receipt based on message id.

Get a single fax receipt based on message id.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\FaxApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$message_id = "message_id_example"; // string | ID of the message receipt to retrieve

try {
    $result = $apiInstance->faxReceiptsByMessageIdGet($message_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling FaxApi->faxReceiptsByMessageIdGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **message_id** | **string**| ID of the message receipt to retrieve |

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **faxReceiptsGet**
> string faxReceiptsGet()

Get List of Fax Receipts

Get List of Fax Receipts

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\FaxApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->faxReceiptsGet();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling FaxApi->faxReceiptsGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **faxSendPost**
> string faxSendPost($fax_message)

Send a fax using supplied supported file-types.

Send a fax using supplied supported file-types.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\FaxApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$fax_message = new \Swagger\Client\Model\FaxMessageCollection(); // \Swagger\Client\Model\FaxMessageCollection | FaxMessageCollection model

try {
    $result = $apiInstance->faxSendPost($fax_message);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling FaxApi->faxSendPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **fax_message** | [**\Swagger\Client\Model\FaxMessageCollection**](../Model/FaxMessageCollection.md)| FaxMessageCollection model |

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

