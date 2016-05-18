<?php namespace zverik\mapbbcode\includes;

/**
 * @package mapbbcode
 * @copyright (c) 2016 Ilya Zverev
 * @license GNU GPL 2.0 <https://www.gnu.org/licenses/gpl-2.0.txt>
 */

class mapbbcode {
	use singletontrait;
	use bbcodestrait;
	
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	
	/** @var string */
	protected $table_prefix;
	
	protected function init() {
		global $db, $table_prefix;
		
		$this->db = $db;
		$this->table_prefix = $table_prefix;
	}
	
	/**
	 * BBCodes
	 * @return	array
	 */
	public function get_bbcodes() {
		return [
			'map'	=> [
        'bbcode_tag'			=> 'map',
        'bbcode_helpline'		=> 'BBCODE_MAP_HELP',
        'display_on_posting'	=> 0,
        'bbcode_match'			=> '[map]{TEXT}[/map]',
        'bbcode_tpl'			=> '<div id="map{DIVID}">[map]{TEXT}[/map]</div><script language="javascript">showMapBBCode(\'map{DIVID}\');</script>',
        'first_pass_match'		=> '!\[map(=[0-9,.]+)?\](.*?)\[/map\]!ies',
        'first_pass_replace'	=> '\'[map:$uid${1}]\'.str_replace(array("\\r\\n", \'\\"\', \'\\\'\', \'(\', \')\'), array("\n", \'"\', \'&#39;\', \'&#40;\', \'&#41;\'), trim(\'${2}\')).\'[/map:$uid]\'',
        'second_pass_match'		=> '!\[map:($uid)(=[0-9,.]+)?\](.*?)\[/map:$uid\]!se',
        'second_pass_replace'	=> '\'<div id="map${1}\'.md5(\'${2}${3}\').\'">[map${2}]${3}[/map]</div><script language="javascript">showMapBBcode(\\\'map${1}\'.md5(\'${2}${3}\').\'\\\');</script>\'',
			],
			'mapid'	=> [
        'bbcode_tag'			=> 'mapid',
        'bbcode_helpline'		=> '',
        'display_on_posting'	=> 0,
        'bbcode_match'			=> '[mapid]{TEXT}[/mapid]',
        'bbcode_tpl'			=> '<div id="map{DIVID}"></div><script language="javascript">showMapBBCode(\'map{DIVID}\', \'{MAPID}\');</script>',
        'first_pass_match'		=> '!\[mapid\]([a-z]+)\[/mapid\]!ie',
        'first_pass_replace'	=> '\'[mapid:$uid]${1}[/mapid:$uid]\'',
        'second_pass_match'		=> '!\[mapid:($uid)\]([a-z]+)\[/mapid:$uid\]!e',
        'second_pass_replace'	=> '\'<div id="map${1}${2}"></div><script language="javascript">showMapBBCode(\\\'map${1}${2}\\\', \\\'${2}\\\');</script>\'',
			]
		];
	}
}
