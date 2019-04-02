<?php

/**
 * Extension for the Flarum.
 *
 * (C) Vasyl Martyniuk <vasyl@vasyltech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Flarum\Extend;
use Illuminate\Contracts\Events\Dispatcher;
use VasylTech\AlgoliaSearch\Listener\ExtendApiAttributesListener;
use VasylTech\AlgoliaSearch\Listener\ExtendFrontendPayloadListener;
use VasylTech\AlgoliaSearch\Listener\PostIndexListener;

return [
    // Register frontend
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->content(ExtendFrontendPayloadListener::class),
    // Register backend
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
    // Register transactions
    new Extend\Locales(__DIR__ . '/locale'),
    // Hook into the core processes
    function (Dispatcher $events) {
        $events->subscribe(ExtendApiAttributesListener::class);
        $events->subscribe(PostIndexListener::class);
    },
];
