/**
 * Extension for the Flarum.
 *
 * (C) Vasyl Martyniuk <vasyl@vasyltech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import algoliasearch from 'algoliasearch';
import highlight from 'flarum/helpers/highlight';
import LinkButton from 'flarum/components/LinkButton';

export default class AlgoliaSearchSource {

  /**
   * 
   */
  constructor() {
    this.client = algoliasearch(
      app.data.algolia.applicationId,
      app.data.algolia.apiKey
    );

    this.results = {};
  }

  /**
   * 
   * @param {*} query 
   */
  search(query) {
    query = query.toLowerCase();

    this.results[query] = [];

    var index = this.client.initIndex(
      app.data.algolia.searchIndex
    );

    // only query string
    return new Promise((resolve, reject) => {
      index.search({
        query
      },
        function searchDone(err, content) {
          if (err) throw err;

          resolve(content.hits);
        }
      )
    }).then(results => this.results[query] = results);
  }

  /**
   * 
   * @param {*} query 
   */
  view(query) {
    query = query.toLowerCase();

    const results = this.results[query] || [];

    return [
      <li className="Dropdown-header">{app.translator.trans('core.forum.search.discussions_heading')}</li>,
      <li>
        {LinkButton.component({
          icon: 'fas fa-search',
          children: app.translator.trans('core.forum.search.all_discussions_button', { query }),
          href: app.route('index', { q: query })
        })}
      </li>,
      results.map(item => {
        return (
          <li className="DiscussionSearchResult" data-index={'discussions' + item.discussionId}>
            <a href={item.uri} config={m.route}>
              <div className="DiscussionSearchResult-title">{highlight(item.title, query)}</div>
              <div className="DiscussionSearchResult-excerpt">{highlight(item.content, query, 100)}</div>
            </a>
          </li>
        );
      })
    ];
  }
}
