<?php

return [
    'mode' => env('D4SIGN_ENV', 'homologacao'),
    'token_api' => env('D4SIGN_TOKEN_API', 'token'),
    'crypt_key' => env('D4SIGN_CRYPT_KEY', 'crypt'),
    'template' => env('D4SIGN_TEMPLATE', 'crypt'),
    'cofre' => env('D4SIGN_COFRE', 'crypt'),
];