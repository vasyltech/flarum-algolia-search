<?php

/**
 * Extension for the Flarum.
 *
 * (C) Vasyl Martyniuk <vasyl@vasyltech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VasylTech\AlgoliaSearch\Listener;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\PostSerializer;
use Illuminate\Contracts\Events\Dispatcher;

class ExtendApiAttributesListener
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Serializing::class, [$this, 'prepareApiAttributes']);
    }

    /**
     * @param Serializing $event
     */
    public function prepareApiAttributes(Serializing $event)
    {
        if ($event->isSerializer(PostSerializer::class)) {
            $event->attributes['canIndex'] = (bool) $event->actor->can(
                'index', $event->model
            );
            $event->attributes['isIndexed'] = (bool) $event->model->is_indexed;
        }
    }

}
