<?php
/**
 * @package mapbbcode
 * @copyright (c) 2016 Ilya Zverev
 * @license GPL v2
 */

namespace zverik\mapbbcode\migrations;

class m1_install_bbcode extends \phpbb\db\migration\migration
{
  public function effectively_installed()
  {
    return isset($this->config['mapbb_default_zoom']);
  }

  public function update_data()
  {
    return array(
      array('config.add', array('allow_maps', '1')),
      array('config.add', array('mapbb_default_zoom', '2')),
      array('config.add', array('mapbb_default_pos', '22,11')),
      array('config.add', array('mapbb_view_width', '600')),
      array('config.add', array('mapbb_view_height', '300')),
      array('config.add', array('mapbb_full_height', '600')),
      array('config.add', array('mapbb_always_full', '')),
      array('config.add', array('mapbb_editor_height', '400')),
      array('config.add', array('mapbb_window_width', '800')),
      array('config.add', array('mapbb_window_height', '500')),
      array('config.add', array('mapbb_editor_window', '1')),
      array('config.add', array('mapbb_outer_link', '')),
      array('config.add', array('mapbb_allowed_tags', '[auib]|span|br|em|strong|tt')),
      array('config.add', array('mapbb_standard_switcher', '1')),
      array('config.add', array('mapbb_enable_external', '0')),
      array('config.add', array('mapbb_share_server', 'http://share.mapbbcode.org/')),
      array('config.add', array('mapbb_layers', 'OpenStreetMap')),

      array('module.add', array(
        'acp', 'ACP_MESSAGES', array(
            'module_basename' => '\zverik\mapbbcode\acp\acp_mapbbcode_module',
            'modes' => array('settings'),
        ),
      )),

      array('custom', array(array($this, 'install_map_bbcode'))),
    );
  }

  public function revert_data()
  {
    return array(
      array('custom', array(array($this, 'remove_map_bbcode'))),
    );
  }

  public function install_map_bbcode()
  {
    $mapbbcode = \zverik\mapbbcode\includes\mapbbcode::instance();
    foreach ($mapbbcode->get_bbcodes() as $key => $bbcode)
    {
      $id = $mapbbcode->bbcode_exists($bbcode['bbcode_tag']);
      if ($id >= 0)
      {
        $bbcode['bbcode_id'] = $id;
        $mapbbcode->bbcode_update($bbcode);
      }
      else
      {
        $bbcode['bbcode_id'] = $mapbbcode->get_last_bbcode_id();
        if ($bbcode['bbcode_id'] <= BBCODE_LIMIT)
          $mapbbcode->bbcode_insert($bbcode);
      }
    }
  }

  public function remove_map_bbcode()
  {
    $mapbbcode = \zverik\mapbbcode\includes\mapbbcode::instance();
    foreach ($mapbbcode->get_bbcodes() as $key => $bbcode)
    {
      if ($mapbbcode->bbcode_exists($bbcode['bbcode_tag']))
        $mapbbcode->bbcode_delete($bbcode);
    }
  }
}
