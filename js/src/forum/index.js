/**
 * Extension for the Flarum.
 *
 * (C) Vasyl Martyniuk <vasyl@vasyltech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import Post from 'flarum/models/Post';
import Model from 'flarum/Model';
import AlgoliaSearch from './components/AlgoliaSearch';
import AlgoliaConnectButton from './components/AlgoliaConnectButton';

// Override the default Search functionality
app.search = new AlgoliaSearch();

app.initializers.add('algolia-index', () => {
    Post.prototype.canIndex = Model.attribute('canIndex');
    Post.prototype.isIndexed = Model.attribute('isIndexed');

    new AlgoliaConnectButton();
});