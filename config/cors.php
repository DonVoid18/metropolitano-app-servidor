<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
    // 'api/*', 'sanctum/csrf-cookie', 'get-csrf-token','api/pacientes/agregarpaciente','doctor/buscarespecialidad'
    // ,'doctor/agregardoctor','doctor/agregarhorario','doctor/buscardoctor','doctor/eliminardoctor/*'
    // ,'doctor/actualizardoctor/*','doctor/buscarhorarios','doctor/agregarhorario'
    // ,'doctor/actualizarhorario/*','doctor/eliminarhorario/*','doctor/agregarhorario_doctor'
    
    'paths' => ['*'], // Agrega tu punto final aquí
    'allowed_origins' => ['*'],
    'allowed_headers' => ['*'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,

];
