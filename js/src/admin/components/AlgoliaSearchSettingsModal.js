/**
 * Extension for the Flarum.
 *
 * (C) Vasyl Martyniuk <vasyl@vasyltech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import SettingsModal from 'flarum/components/SettingsModal';

export default class AlgoliaSearchSettingsModal extends SettingsModal {
  className() {
    return 'AlgoliaSearchSettingsModal Modal--small';
  }

  title() {
    return 'Algolia Search Settings';
  }

  form() {
    return [
      <div className="Form-group">
        <label>Application ID</label>
        <input className="FormControl" bidi={this.setting('algolia-search.application_id')} />
      </div>,

      <div className="Form-group">
        <label>Search-Only API Key</label>
        <input className="FormControl" bidi={this.setting('algolia-search.search_api_key')} />
      </div>,

      <div className="Form-group">
        <label>Admin API Key</label>
        <input className="FormControl" bidi={this.setting('algolia-search.api_key')} />
      </div>,

      <div className="Form-group">
        <label>Search Index</label>
        <input className="FormControl" bidi={this.setting('algolia-search.index')} />
      </div>
    ];
  }
}
