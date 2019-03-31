# flarum-algolia-search
Replaces the default Flarum forum search with Algolia search

## What is included

- Backend settings modal to setup application id, search api key, admin api key and Algolia index;
- Backend permissions setting;
- Frontend search box is replaced with Algolia search source. Visually there is no difference
- Frontend post indexing/unindexing. Each post has to be indexed manually to avoid bunch of useless posts in the index (e.g. "Thank you ...", "It works/does not work ..." etc). This way you control what exactly should be indexed to keep your search results ever-green.

## Installation

Current just checkout the source and follow the [Flarum Documentation](https://flarum.org/docs/extend/start.html). When I'll find that more people are interested in this functionality I'll make easier to install.