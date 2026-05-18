<?php

return [

    'supportedLocales' => [
        'ru' => ['name' => 'Russian',              'script' => 'Cyrl', 'native' => 'Русский',  'regional' => 'ru_RU'],
        'en' => ['name' => 'English',              'script' => 'Latn', 'native' => 'English',   'regional' => 'en_GB'],
        'ar' => ['name' => 'Arabic',               'script' => 'Arab', 'native' => 'العربية',   'regional' => 'ar_AE'],
        'fa' => ['name' => 'Persian',              'script' => 'Arab', 'native' => 'فارسی',     'regional' => 'fa_IR'],
        'tr' => ['name' => 'Turkish',              'script' => 'Latn', 'native' => 'Türkçe',    'regional' => 'tr_TR'],
        'pt' => ['name' => 'Portuguese',           'script' => 'Latn', 'native' => 'Português', 'regional' => 'pt_PT'],
        'es' => ['name' => 'Spanish',               'script' => 'Latn', 'native' => 'Español',   'regional' => 'es_ES'],
    ],

    // Don't redirect browser to detected language on first visit — we handle this explicitly
    'useAcceptLanguageHeader' => false,

    // ru is default — no prefix in URL (/blog instead of /ru/blog)
    'hideDefaultLocaleInURL' => true,

    'localesOrder' => ['ru', 'en', 'ar', 'fa', 'tr', 'pt', 'es'],

    'localesMapping' => [],

    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.UTF-8'),

    // Ignore admin panel and API routes
    'urlsIgnored' => ['/admin', '/admin/*', '/api/*'],

    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
