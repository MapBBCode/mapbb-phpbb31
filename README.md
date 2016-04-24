# MapBBCode Extension for phpBB 3.1

This is a port / rewrite of a MapBBCode MOD for phpBB 3.1, which has a new extensions system. Well, they didn't change other files much.

## Installation

1. Extract `mapbbcode_ext.zip` to your phpBB 3.1 installation under `ext` directory. E.g. to `/var/www/sites/phpbb/ext/`.
2. Open the admin panel, "Customize" -> "Manage extensions" and enable the "MapBBCode" extension.
3. Check that [map] bbcode works, and there is a "MapBBCode" administration panel in "Posting" tab.

## Add-ons and proprietary Layers

If you want to use plugins or proprietary layers, like Google's, you'll have to modify two files inside `ext/zverik/mapbbcode`:

* `adm/style/acp_mapbbcode.html`
* `styles/all/template/mapbbcode_init.html`

After that you would have to clear all caches. For example, by cleaning the `cache` directory, or maybe clicking the "Purge the cache" button
in the "General" tab of the admin panel.

## License

GPLv2. Sorry.
