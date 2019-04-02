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
import Button from 'flarum/components/Button';
import CommentPost from 'flarum/components/CommentPost';

export default class AlgoliaConnectButton {

    /**
     * 
     */
    constructor() {
        extend(CommentPost.prototype, 'actionItems', function (items) {
            const post = this.props.post;

            if (!post.isHidden() && post.canIndex()) {
                let isIndexed = post.isIndexed();

                items.add('connect',
                    Button.component({
                        children: app.translator.trans(
                            `flarum-algolia-search.forum.connect-btn.${isIndexed ? 'unindex_label' : 'index_label'}`
                        ),
                        className: 'Button Button--link',
                        onclick: () => {
                            isIndexed = !isIndexed;
                            post.save({ isIndexed });
                        }
                    })
                );
            }
        });
    }
}