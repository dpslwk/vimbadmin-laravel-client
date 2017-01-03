<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API URL
    |--------------------------------------------------------------------------
    |
    | Url to your vimbadmin-api endpoint
    */
    'api_url' => env('VIMBADMIN_URL', 'http://vimbadmin-api.dev'),

    /*
    |--------------------------------------------------------------------------
    | Client ID and secret
    |--------------------------------------------------------------------------
    |
    | Your client id and secert are used to get osauth tokens
    */
    'client_id' => env('VIMBADMIN_ID'),
    'client_secret' => env('VIMBADMIN_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Token store provider
    |--------------------------------------------------------------------------
    |
    | This option controles which drive is used to store and retrive oAuth
    | tokens.
    |
    | Supported: "json", "eloquent", "doctorine"
    |
    */
    'driver' => env('VIMBADMIN_DRIVER', 'json'),

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This defines how the how the Tokens are actually retrieved out of your
    | database or other storage mechanisms used by this application to
    | persist your user's data.
    */
    'providers' => [
        'json' => [
            'file' => env('VIMBADMIN_FILE', 'tokens.json'),
        ],
        'eloquent' => [
            'model' => env('VIMBADMIN_MODEL'),
        ],
        'docrtine' => [
            'entity' => env('VIMBADMIN_ENITITY'),
        ],


    ],

];
