# UPGRADE FROM 8.0 to 9.0

Since 9.0, lib no longer use buzz 0.7+, instead it has an HTTPlug abstraction layer.

## `Gitlab\Client` changes

* The constructor no longer allow to specify base url. Use `setUrl` or `Client::create` instead.
* The default url is set to `https://gitlab.com`.
* The `$options` constructor argument have been removed, the `getOption` and `setOption` methods have been removed.
See [documentation](doc/customize.md) to know how to customize the client timeout and how to use a custom user agent.
* The `setBaseUrl` and `getBaseUrl` methods have been removed. Use `setUrl` instead.
* The `clearHeaders` and `setHeaders` methods have been removed. See [documentation](doc/customize.md) to know how use custom headers.
* The `setHttpClient` method have been removed. Use a `Gitlab\HttpClient\Builder` instead. 
* The `getHttpClient` method return type is changed to `Http\Client\Common\HttpMethodsClient`.
