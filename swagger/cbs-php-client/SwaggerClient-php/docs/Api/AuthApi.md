# Swagger\Client\AuthApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**loginPhpPost**](AuthApi.md#loginphppost) | **POST** /login.php | Login
[**registerPhpPost**](AuthApi.md#registerphppost) | **POST** /register.php | Register user
[**verifyPhpPost**](AuthApi.md#verifyphppost) | **POST** /verify.php | Verify registration

# **loginPhpPost**
> string loginPhpPost($username, $password)

Login

Authenticates user

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: cookieAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('user_id', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('user_id', 'Bearer');

$apiInstance = new Swagger\Client\Api\AuthApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$username = "username_example"; // string | 
$password = "password_example"; // string | 

try {
    $result = $apiInstance->loginPhpPost($username, $password);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthApi->loginPhpPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **username** | **string**|  | [optional]
 **password** | **string**|  | [optional]

### Return type

**string**

### Authorization

[cookieAuth](../../README.md#cookieAuth)

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: text/plain

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **registerPhpPost**
> string registerPhpPost($username, $password, $telegram)

Register user

Registers a new user

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: cookieAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('user_id', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('user_id', 'Bearer');

$apiInstance = new Swagger\Client\Api\AuthApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$username = "username_example"; // string | 
$password = "password_example"; // string | 
$telegram = "telegram_example"; // string | 

try {
    $result = $apiInstance->registerPhpPost($username, $password, $telegram);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthApi->registerPhpPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **username** | **string**|  | [optional]
 **password** | **string**|  | [optional]
 **telegram** | **string**|  | [optional]

### Return type

**string**

### Authorization

[cookieAuth](../../README.md#cookieAuth)

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: text/plain

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **verifyPhpPost**
> string verifyPhpPost($code)

Verify registration

Verifies registration code

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: cookieAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('user_id', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('user_id', 'Bearer');

$apiInstance = new Swagger\Client\Api\AuthApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$code = "code_example"; // string | 

try {
    $result = $apiInstance->verifyPhpPost($code);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthApi->verifyPhpPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **code** | **string**|  | [optional]

### Return type

**string**

### Authorization

[cookieAuth](../../README.md#cookieAuth)

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: text/plain

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

