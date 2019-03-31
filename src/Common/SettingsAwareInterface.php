<?php

/**
 * Extension for the Flarum.
 *
 * (C) Vasyl Martyniuk <vasyl@vasyltech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VasylTech\AlgoliaSearch\Common;

interface SettingsAwareInterface
{
    /**
     *
     */
    const APPLICATION_ID = 'algolia-search.application_id';

    /**
     *
     */
    const SEARCH_API_KEY = 'algolia-search.search_api_key';

    /**
     *
     */
    const API_KEY = 'algolia-search.api_key';

    /**
     *
     */
    const SEARCH_INDEX = 'algolia-search.index';

}
