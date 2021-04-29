<?php

return [
    /*
    |---------------------------------------------------------------------------
    | Excluded Routes
    |---------------------------------------------------------------------------
    |
    | Place any full routes in here that you'd like to have ignored by the
    | route coverage checks. Routes provided in here must be the entire route
    | string in order to match.
    |
    */
    'exclude_routes' => [
        // E.g. ...
        // '/my/url',
        // 'Closure /my/url',
    ],

    /*
    |---------------------------------------------------------------------------
    | Excluded Route Groups
    |---------------------------------------------------------------------------
    |
    | Place any route group names in here to ignore all routes of a given group.
    | For example, in order to ignore all passport route names, as they are all
    | prefixed with 'passport.*', place 'passport' into this array.
    |
    */
    'exclude_route_groups' => [
        // E.g. ...
        // 'debugbar',
        // 'dusk',
        // 'passport',
    ],

    /*
    |---------------------------------------------------------------------------
    | Route Groups Seperator
    |---------------------------------------------------------------------------
    |
    | The seperator that is to be used when building route group names to be
    | excluded, this defaults to the Laravel default character, period.
    |
    */
    'route_groups_seperator' => '.',
];
