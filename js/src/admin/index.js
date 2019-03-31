/**
 * Extension for the Flarum.
 *
 * (C) Vasyl Martyniuk <vasyl@vasyltech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import { extend } from 'flarum/extend';
import app from 'flarum/app';
import PermissionGrid from 'flarum/components/PermissionGrid';

import AlgoliaSearchSettingsModal from './components/AlgoliaSearchSettingsModal';

app.initializers.add('vasyltech-algolia-search', () => {
  app.extensionSettings['vasyltech-algolia-search'] = () => app.modal.show(new AlgoliaSearchSettingsModal());
});

app.initializers.add('algolia-index', () => {
  extend(PermissionGrid.prototype, 'moderateItems', items => {
    items.add('indexPosts', {
      icon: 'fab fa-algolia',
      label: 'Algolia Indexing',
      permission: 'discussion.indexPosts'
    });
  });
});
