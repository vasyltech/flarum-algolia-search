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
        <label>{app.translator.trans('flarum-algolia-search.admin.algolia_settings.application_id_label')}</label>
        <input className="FormControl" bidi={this.setting('algolia-search.application_id')} />
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('flarum-algolia-search.admin.algolia_settings.search_api_key_label')}</label>
        <input className="FormControl" bidi={this.setting('algolia-search.search_api_key')} />
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('flarum-algolia-search.admin.algolia_settings.api_key_label')}</label>
        <input className="FormControl" bidi={this.setting('algolia-search.api_key')} />
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('flarum-algolia-search.admin.algolia_settings.index_label')}</label>
        <input className="FormControl" bidi={this.setting('algolia-search.index')} />
      </div>
    ];
  }
}
