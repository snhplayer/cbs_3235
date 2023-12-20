# Swagger\Client\SessionsApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addSessionPhpPost**](SessionsApi.md#addsessionphppost) | **POST** /add_session.php | Add session

# **addSessionPhpPost**
> \Swagger\Client\Model\InlineResponse2001 addSessionPhpPost($session_movie, $session_time)

Add session

Adds a new movie screening session

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: cookieAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('user_id', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('user_id', 'Bearer');

$apiInstance = new Swagger\Client\Api\SessionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$session_movie = 56; // int | 
$session_time = new \DateTime("2013-10-20T19:20:30+01:00"); // \DateTime | 

try {
    $result = $apiInstance->addSessionPhpPost($session_movie, $session_time);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SessionsApi->addSessionPhpPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **session_movie** | **int**|  | [optional]
 **session_time** | **\DateTime**|  | [optional]

### Return type

[**\Swagger\Client\Model\InlineResponse2001**](../Model/InlineResponse2001.md)

### Authorization

[cookieAuth](../../README.md#cookieAuth)

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

