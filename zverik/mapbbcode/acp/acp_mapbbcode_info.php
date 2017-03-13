<?php
/**
*
* @package acp
* @version $Id$
* @copyright (c) 2013 Ilya Zverev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 2
*
*/
namespace zverik\mapbbcode\acp;

/**
* @package module_install
*/
class acp_mapbbcode_info
{
  function module()
  {
    return array(
      'filename' => '\zverik\mapbbcode\acp\acp_mapbbcode_module',
      'title'    => 'ACP_MAPBBCODE_SETTINGS',
      'modes'    => array(
        'settings' => array(
          'title' => 'ACP_MAPBBCODE_SETTINGS',
          'auth'  => 'acl_a_bbcode',
          'cat'   => array('ACP_MESSAGES')
        ),
      ),
    );
  }
}
?>
