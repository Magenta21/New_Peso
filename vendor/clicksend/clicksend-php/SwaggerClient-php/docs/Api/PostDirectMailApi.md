# Swagger\Client\PostDirectMailApi

All URIs are relative to *https://rest.clicksend.com/v3*

Method | HTTP request | Description
------------- | ------------- | -------------
[**postDirectMailCampaignsGet**](PostDirectMailApi.md#postDirectMailCampaignsGet) | **GET** /post/direct-mail/campaigns | Get direct mail campaigns
[**postDirectMailCampaignsPricePost**](PostDirectMailApi.md#postDirectMailCampaignsPricePost) | **POST** /post/direct-mail/campaigns/price | Calculate direct mail campaign price
[**postDirectMailCampaignsSendPost**](PostDirectMailApi.md#postDirectMailCampaignsSendPost) | **POST** /post/direct-mail/campaigns/send | Send direct mail campaign
[**postDirectMailLocationsSearchByCountryGet**](PostDirectMailApi.md#postDirectMailLocationsSearchByCountryGet) | **GET** /post/direct-mail/locations/search/{country} | Search for a location


# **postDirectMailCampaignsGet**
> string postDirectMailCampaignsGet($page, $limit)

Get direct mail campaigns

Get direct mail campaigns

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\PostDirectMailApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$page = 1; // int | Page number
$limit = 10; // int | Number of records per page

try {
    $result = $apiInstance->postDirectMailCampaignsGet($page, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PostDirectMailApi->postDirectMailCampaignsGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
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

# **postDirectMailCampaignsPricePost**
> string postDirectMailCampaignsPricePost($post_direct_mail)

Calculate direct mail campaign price

Calculate direct mail campaign price

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\PostDirectMailApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$post_direct_mail = new \Swagger\Client\Model\PostDirectMail(); // \Swagger\Client\Model\PostDirectMail | PostDirectMail model

try {
    $result = $apiInstance->postDirectMailCampaignsPricePost($post_direct_mail);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PostDirectMailApi->postDirectMailCampaignsPricePost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **post_direct_mail** | [**\Swagger\Client\Model\PostDirectMail**](../Model/PostDirectMail.md)| PostDirectMail model |

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postDirectMailCampaignsSendPost**
> string postDirectMailCampaignsSendPost($post_direct_mail)

Send direct mail campaign

Send direct mail campaign

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\PostDirectMailApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$post_direct_mail = new \Swagger\Client\Model\PostDirectMail(); // \Swagger\Client\Model\PostDirectMail | PostDirectMail model

try {
    $result = $apiInstance->postDirectMailCampaignsSendPost($post_direct_mail);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PostDirectMailApi->postDirectMailCampaignsSendPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **post_direct_mail** | [**\Swagger\Client\Model\PostDirectMail**](../Model/PostDirectMail.md)| PostDirectMail model |

### Return type

**string**

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postDirectMailLocationsSearchByCountryGet**
> string postDirectMailLocationsSearchByCountryGet($country, $q, $page, $limit)

Search for a location

Search for a location

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure HTTP basic authorization: BasicAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Swagger\Client\Api\PostDirectMailApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$country = "country_example"; // string | Country Code to search
$q = "q_example"; // string | Search term (e.g. post code, city name)
$page = 1; // int | Page number
$limit = 10; // int | Number of records per page

try {
    $result = $apiInstance->postDirectMailLocationsSearchByCountryGet($country, $q, $page, $limit);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PostDirectMailApi->postDirectMailLocationsSearchByCountryGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **country** | **string**| Country Code to search |
 **q** | **string**| Search term (e.g. post code, city name) |
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

