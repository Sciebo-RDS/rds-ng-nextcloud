<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: University of Muenster <info@uni-muenster.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

return [
    'routes' => [
        // LaunchController
        [
            "name" => "launch#launch",
            "url" => "/",
            "verb" => "GET",
        ],
        [
            "name" => 'launch#app',
            "url" => '/app',
            "verb" => 'GET',
        ],

        // ApiV1Controller
        [
            "name" => 'api_v1#publickey',
            "url" => '/api/v1/public-key',
            "verb" => 'GET',
        ],
        [
            "name" => 'api_v1#authorization',
            "url" => '/api/v1/authorization',
            "verb" => 'GET',
        ],
        [
            "name" => 'api_v1#resources',
            "url" => '/api/v1/resources',
            "verb" => 'GET',
        ],
    ]
];
