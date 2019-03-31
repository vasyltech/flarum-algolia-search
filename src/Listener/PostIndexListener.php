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

use Algolia\AlgoliaSearch\SearchClient;
use Flarum\Post\CommentPost;
use Flarum\Post\Event\Saving;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\AssertPermissionTrait;
use Illuminate\Contracts\Events\Dispatcher;
use VasylTech\AlgoliaSearch\Common\SettingsAwareInterface;

class PostIndexListener implements SettingsAwareInterface
{
    use AssertPermissionTrait;

    /**
     * 
     */
    const OBJECT_ID = 'F%d';

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Saving::class, [$this, 'togglePostIndex']);
    }

    /**
     * @param Saving $event
     */
    public function togglePostIndex(Saving $event)
    {
        $attributes = $event->data['attributes'];
        $post = $event->post;

        // Step #1. Let's make sure that current user is allowed to index a post
        $this->assertCan($event->actor, 'index', $post);

        // Step #2. Determine correct action based on provided flag
        if (!empty($attributes['isIndexed'])) {
            $this->indexPost($post);
        } else {
            $this->unindexPost($post);
        }
    }

    /**
     * Undocumented function
     *
     * @param CommentPost $post
     * @return void
     */
    protected function indexPost(CommentPost $post)
    {
        $post->is_indexed = true;

        $this->prepareIndex()->saveObject($this->preparePayload($post));
    }

    /**
     * Undocumented function
     *
     * @param CommentPost $post
     * @return void
     */
    protected function unindexPost(CommentPost $post)
    {
        $post->is_indexed = false;
        $this->prepareIndex()->deleteObject(sprintf(self::OBJECT_ID, $post->id));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function prepareIndex()
    {
        $client = SearchClient::create(
            $this->settings->get(self::APPLICATION_ID),
            $this->settings->get(self::API_KEY)
        );

        return $client->initIndex($this->settings->get(self::SEARCH_INDEX));
    }

    /**
     *
     * @param type $post
     */
    private function preparePayload(CommentPost $post)
    {
        // prepare the list of tags
        $tags = array();
        foreach ($post->discussion->tags as $tag) {
            $tags[] = $tag->slug;
        }

        return array(
            'objectID' => sprintf(self::OBJECT_ID, $post->id),
            'discussionId' => $post->discussion->id,
            'postId' => $post->id,
            'title' => $post->discussion->title,
            'content' => $this->normalizeContent($post->content),
            '__tags' => implode(',', $tags),
            '__type' => 'forum',
            'uri' => sprintf(
                '/d/%d-%s/%d',
                $post->discussion->id,
                $post->discussion->slug,
                $post->id
            ),
        );
    }

    /**
     *
     * @param type $content
     * @return type
     */
    private function normalizeContent($content)
    {
        $noise = array(
            "'<!--(.*?)-->'is",
            "'<!\[CDATA\[(.*?)\]\]>'is",
            "'<\s*script[^>]*[^/]>(.*?)<\s*/\s*script\s*>'is",
            "'<\s*script\s*>(.*?)<\s*/\s*script\s*>'is",
            "'<\s*style[^>]*[^/]>(.*?)<\s*/\s*style\s*>'is",
            "'<\s*style\s*>(.*?)<\s*/\s*style\s*>'is",
            "'<\s*(?:code)[^>]*>(.*?)<\s*/\s*(?:code)\s*>'is",
            "'<\s*pre[^>]*[^/]>(.*?)<\s*/\s*pre\s*>'is",
            "'<\s*pre\s*>(.*?)<\s*/\s*pre\s*>'is",
            "'<\s*img[^>]*[^/]>'is",
            "'<\s*iframe[^>]*[^/]>'is",
            "'\[aam.*?\]'is",
        );

        foreach ($noise as $pattern) {
            $content = preg_replace($pattern, '', $content);
        }

        // Replace new lines
        return html_entity_decode(
            strip_tags(str_replace(array("\n", "\r"), ' ', $content))
        );
    }
    
}
