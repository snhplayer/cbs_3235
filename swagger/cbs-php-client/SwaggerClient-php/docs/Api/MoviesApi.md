# Swagger\Client\MoviesApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addMoviePhpPost**](MoviesApi.md#addmoviephppost) | **POST** /add_movie.php | Add movie
[**getMoviesPhpGet**](MoviesApi.md#getmoviesphpget) | **GET** /get_movies.php | Get movies
[**movielistPhpGet**](MoviesApi.md#movielistphpget) | **GET** /movielist.php | List movies

# **addMoviePhpPost**
> \Swagger\Client\Model\InlineResponse200 addMoviePhpPost($movie_title, $description, $movie_image)

Add movie

Adds a new movie

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: cookieAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('user_id', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('user_id', 'Bearer');

$apiInstance = new Swagger\Client\Api\MoviesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$movie_title = "movie_title_example"; // string | 
$description = "description_example"; // string | 
$movie_image = "movie_image_example"; // string | 

try {
    $result = $apiInstance->addMoviePhpPost($movie_title, $description, $movie_image);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MoviesApi->addMoviePhpPost: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **movie_title** | **string**|  | [optional]
 **description** | **string**|  | [optional]
 **movie_image** | **string****string**|  | [optional]

### Return type

[**\Swagger\Client\Model\InlineResponse200**](../Model/InlineResponse200.md)

### Authorization

[cookieAuth](../../README.md#cookieAuth)

### HTTP request headers

 - **Content-Type**: multipart/form-data
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getMoviesPhpGet**
> \Swagger\Client\Model\InlineResponse2002[] getMoviesPhpGet()

Get movies

Retrieves list of movies

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: cookieAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('user_id', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('user_id', 'Bearer');

$apiInstance = new Swagger\Client\Api\MoviesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->getMoviesPhpGet();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MoviesApi->getMoviesPhpGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Swagger\Client\Model\InlineResponse2002[]**](../Model/InlineResponse2002.md)

### Authorization

[cookieAuth](../../README.md#cookieAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **movielistPhpGet**
> string movielistPhpGet()

List movies

Retrieves list of movies

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
// Configure API key authorization: cookieAuth
$config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('user_id', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('user_id', 'Bearer');

$apiInstance = new Swagger\Client\Api\MoviesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->movielistPhpGet();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MoviesApi->movielistPhpGet: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

**string**

### Authorization

[cookieAuth](../../README.md#cookieAuth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: text/html

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

