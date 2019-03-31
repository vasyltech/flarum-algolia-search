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

use Flarum\Frontend\Document;
use Flarum\Settings\SettingsRepositoryInterface;
use VasylTech\AlgoliaSearch\Common\SettingsAwareInterface;

class ExtendFrontendPayloadListener implements SettingsAwareInterface
{

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
     * Undocumented function
     *
     * @param Document $document
     * @return void
     */
    public function __invoke(Document $document)
    {
        $document->payload['algolia'] = array(
            'applicationId' => $this->settings->get(self::APPLICATION_ID),
            'apiKey' => $this->settings->get(self::SEARCH_API_KEY),
            'searchIndex' => $this->settings->get(self::SEARCH_INDEX),
        );
    }

}
