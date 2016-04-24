<?php
/**
* @package mapbbcode
* @copyright (c) 2016 Ilya Zverev
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*/

namespace zverik\mapbbcode\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\template\template;
use phpbb\user;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
  protected $template;
  protected $user;

	public function __construct(template $template, user $user)
	{
    $this->template = $template;
    $this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
      'core.user_setup' => 'load_language_on_setup',
      'core.modify_text_for_display_after' => 'check_map_bbcode',
      'core.modify_format_display_text_after' => 'check_map_bbcode',
      'core.message_parser_check_message' => 'check_signature',
      'core.page_header_after' => 'set_map_variables',
      'core.posting_modify_template_vars' => 'enable_map_bbcode',
      'core.ucp_pm_compose_modify_data' => 'enable_map_bbcode',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'zverik/mapbbcode',
			'lang_set' => 'mapbbcode',
		);
		$event['lang_set_ext'] = $lang_set_ext;
  }

  public function check_map_bbcode($event)
  {
    if (!defined('MAPBBCODE') && preg_match('/showMapBBCode\(/', $event['text']))
    {
      define('MAPBBCODE', 1);
    }
    //$this->set_map_variables($event);
  }

  public function enable_map_bbcode($event)
  {
    if (!defined('MAPBBCODE'))
    {
      define('MAPBBCODE', 1);
    }
  }

  public function check_signature($event)
  {
    if ($event['mode'] == 'sig' && strpos($event['message'], '[map') !== false)
    {
      // Since we can't disable [map] in signatures specifically, let's disable everything.
      $event['allow_bbcode'] = false;
    }
  }

  public function set_map_variables($event)
  {
    global $config;
		$vars = array(
			"S_MAPBBCODE" => defined('MAPBBCODE'),
      'MAPBB_LANGUAGE_JS' => $this->user->lang['MAPBB_LANGUAGE_JS'],
			"LAYERS" => str_replace("'", "\\'", $config['mapbb_layers']),
			"DEFAULT_ZOOM" => $config['mapbb_default_zoom'],
			"DEFAULT_POS" => $config['mapbb_default_pos'],
			"VIEW_WIDTH" => $config['mapbb_view_width'],
			"VIEW_HEIGHT" => $config['mapbb_view_height'],
			"FULL_HEIGHT" => $config['mapbb_full_height'],
      "EDITOR_HEIGHT" => $config['mapbb_editor_height'],
      "WINDOW_WIDTH" => $config['mapbb_window_width'],
      "WINDOW_HEIGHT" => $config['mapbb_window_height'],
			"OUTER_LINK" => $config['mapbb_outer_link'],
			"SHARE_SERVER" => $config['mapbb_share_server'],
			"S_ENABLE_EXTERNAL" => $config['mapbb_enable_external'],
			"ENABLE_EXTERNAL" => $config['mapbb_enable_external'] ? 'true' : 'false',
			"ALWAYS_FULL" => $config['mapbb_always_full'] ? 'true' : 'false',
			"STANDARD_SWITCHER" => $config['mapbb_standard_switcher'] ? 'true' : 'false',
      "EDITOR_WINDOW" => $config['mapbb_editor_window'] ? 'true' : 'false',
			"ALLOWED_TAGS" => $config['mapbb_allowed_tags']
		);
    $this->template->assign_vars($vars);
  }
}
