/**
 * Extension for the Flarum.
 *
 * (C) Vasyl Martyniuk <vasyl@vasyltech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Search from 'flarum/components/Search';
import AlgoliaSearchSource from './AlgoliaSearchSource';

export default class AlgoliaSearch extends Search {

    sourceItems() {
        const items = super.sourceItems();

        // Replace the Discussions Search Source with Algolia Search Source
        items.replace('discussions', new AlgoliaSearchSource());

        return items;
    }
}