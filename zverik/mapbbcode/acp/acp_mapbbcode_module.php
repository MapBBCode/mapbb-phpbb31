<?php
/**
*
* @package acp_mapbbcode
* @version $Id$
* @copyright (c) 2013 Ilya Zverev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
namespace zverik\mapbbcode\acp;

/**
* @package acp
*/
class acp_mapbbcode_module
{
  var $u_action;

  function main($id, $mode)
  {
    global $db, $user, $auth, $template, $request, $phpbb_log;
    global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

    $action  = $request->variable('action', '');
    $submit = (isset($_POST['submit'])) ? true : false;

    if ($mode != 'settings')
    {
      return;
    }

    //$user->add_lang_ext('zverik/mapbbcode', 'mapbbcode');
    $this->tpl_name = 'acp_mapbbcode';
    $this->page_title = 'MAPBB_CONFIG';

    $maps_enable       = $request->variable('maps_enable',       (bool) $config['allow_maps']);
    $enable_external   = $request->variable('enable_external',   (bool) $config['mapbb_enable_external']);
    $layers            = $request->variable('layers',          (string) $config['mapbb_layers']);
    $default_zoom      = $request->variable('default_zoom',       (int) $config['mapbb_default_zoom']);
    $default_pos       = $request->variable('default_pos',     (string) $config['mapbb_default_pos']);
    $view_width        = $request->variable('view_width',         (int) $config['mapbb_view_width']);
    $view_height       = $request->variable('view_height',        (int) $config['mapbb_view_height']);
    $full_height       = $request->variable('full_height',        (int) $config['mapbb_full_height']);
    $editor_height     = $request->variable('editor_height',      (int) $config['mapbb_editor_height']);
    $window_width      = $request->variable('window_width',       (int) $config['mapbb_window_width']);
    $window_height     = $request->variable('window_height',      (int) $config['mapbb_window_height']);
    $always_full       = $request->variable('always_full',       (bool) $config['mapbb_always_full']);
    $editor_window     = $request->variable('editor_window',     (bool) $config['mapbb_editor_window']);
    $standard_switcher = $request->variable('standard_switcher', (bool) $config['mapbb_standard_switcher']);
    $outer_link        = $request->variable('outer_link',      (string) $config['mapbb_outer_link']);
    $allowed_tags      = $request->variable('allowed_tags',    (string) $config['mapbb_allowed_tags']);
    $share_server      = $request->variable('share_server',    (string) $config['mapbb_share_server']);

    $form_name = 'acp_mapbbcode';
    add_form_key($form_name);

    if ($submit)
    {
      if (!check_form_key($form_name))
      {
        trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);
      }

      $error = array();

      $config->set('allow_maps', $maps_enable);
      $config->set('mapbb_enable_external', $enable_external);
      $config->set('mapbb_layers', $layers);
      $config->set('mapbb_default_zoom', $default_zoom);
      $config->set('mapbb_default_pos', $default_pos);
      $config->set('mapbb_view_width', $view_width);
      $config->set('mapbb_view_height', $view_height);
      $config->set('mapbb_full_height', $full_height);
      $config->set('mapbb_editor_height', $editor_height);
      $config->set('mapbb_window_width', $window_width);
      $config->set('mapbb_window_height', $window_height);
      $config->set('mapbb_always_full', $always_full);
      $config->set('mapbb_editor_window', $editor_window);
      $config->set('mapbb_standard_switcher', $standard_switcher);
      $config->set('mapbb_outer_link', $outer_link);
      $config->set('mapbb_allowed_tags', $allowed_tags);
      $config->set('mapbb_share_server', $share_server);

      $phpbb_log->add('admin', $user->data['user_id'], $user->ip, 'LOG_CONFIG_MAPBBCODE', time(), array());
      trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
    }

    $template->assign_vars(array(
      'MAPBB_LANGUAGE_JS' => $user->lang['MAPBB_LANGUAGE_JS'],
      'U_ACTION'      => $this->u_action,
      'MAPS_ENABLE'   => $maps_enable,
      'ALLOW_MAPS'    => $maps_enable,
      'ENABLE_EXTERNAL' => $enable_external,
      'LAYERS'        => str_replace("'", "\\'", $layers),
      'DEFAULT_ZOOM'  => $default_zoom,
      'DEFAULT_POS'   => $default_pos,
      'VIEW_WIDTH'    => $view_width,
      'VIEW_HEIGHT'   => $view_height,
      'FULL_HEIGHT'   => $full_height,
      'EDITOR_HEIGHT' => $editor_height,
      'WINDOW_WIDTH'  => $window_width,
      'WINDOW_HEIGHT' => $window_height,
      'ALWAYS_FULL'   => $always_full,
      'EDITOR_WINDOW' => $editor_window,
      'STANDARD_SWITCHER' => $standard_switcher,
      'OUTER_LINK'    => $outer_link,
      'ALLOWED_TAGS'  => $allowed_tags,
      'SHARE_SERVER'  => $share_server,
    ));
  }
}

