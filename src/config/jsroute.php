<?php

return 
[
    // Determine where the output will be written
    'path' => resource_path('assets/js/routes.js'),

    // Define the groups you don't wish to publish
    'exclude_middleware' => ['api'],

    // Define the routes you don't wish to publish by name
    'exclude_by_name' => [],

    /* 
     * Sort options: priority, asc, desc 
     * priority: in order that the routes are written and will be checked 
     * uri: alphabetically by route uri
     * verb: alphabetically by http verb
     * name: alphabetically by route name
     */
    'sort_by' => 'priority',

    /*
     * Declare the sort order
     * asc: ascending (for example: start from a -> b -> etc)
     * desc: descending
     */
    'sort_order' => 'asc',

    /*
     * Determines what object the routes will be generated for.
     * It is recommended to assign the object to the window.
     * Example: window.Route = new LaravelJsRoutes();
     * In this example, the js_reference should be 'Route'.
     */
    'js_reference' => 'Route',
];
