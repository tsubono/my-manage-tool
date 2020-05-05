<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Options
    |--------------------------------------------------------------------------
    |
    | The allowed_methods and allowed_headers options are case-insensitive.
    |
    | You don't need to provide both allowed_origins and allowed_origins_patterns.
    | If one of the strings passed matches, it is considered a valid origin.
    |
    | If array('*') is provided to allowed_methods, allowed_origins or allowed_headers
    | all methods / origins / headers are allowed.
    |
    */

    /*
     * You can enable CORS for 1 or multiple paths.
     * Example: ['api/*']
     */
    'paths' => ['api/*'],

    /*
    * Matches the request method. `[*]` allows all methods.
    */
    'allowedMethods' => ['*'],

    /*
     * Matches the request origin. `[*]` allows all origins.
     */
    'allowedOrigins' => ['*'],

    /*
     * Matches the request origin with, similar to `Request::is()`
     */
    'allowedOriginsPatterns' => [],

    /*
     * Sets the Access-Control-Allow-Headers response header. `[*]` allows all headers.
     */
    'allowedHeaders' => ['*'],

    /*
     * Sets the Access-Control-Expose-Headers response header with these headers.
     */
    'exposedHeaders' => [],

    /*
     * Sets the Access-Control-Max-Age response header when > 0.
     */
    'maxAge' => 0,

    /*
     * Sets the Access-Control-Allow-Credentials header.
     */
    'supportsCredentials' => false,
];
