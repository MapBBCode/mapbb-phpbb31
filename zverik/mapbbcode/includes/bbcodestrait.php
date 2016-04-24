<?php namespace zverik\mapbbcode\includes;

/**
 * @package Simple Spoiler - phpBB Extension
 * @author Alfredo Ramos <alfredo.ramos@yandex.com>
 * @copyright (c) 2015 Alfredo Ramos
 * @license GNU GPL 2.0 <https://www.gnu.org/licenses/gpl-2.0.txt>
 */

/**
 * @ignore
 */
if (!defined('IN_PHPBB')) {
	exit;
}

trait bbcodestrait {
	/**
	 * Check if BBCode exists
	 * @param	string	$bbcode	BBCode tag
	 * @return	-1 if not exists, bbcode_id otherwise.
	 */
	public function bbcode_exists($bbcode = '') {

    $row = array();
		if (!empty($bbcode)) {
			$sql = 'SELECT bbcode_id
					FROM ' . BBCODES_TABLE . '
					WHERE bbcode_tag = "' . $this->db->sql_escape($bbcode) . '"';
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
		}
		
		return empty($row) ? -1 : $row['bbcode_id'];
	}
	
	/**
	 * Insert BBCode
	 * @param	array	$bbcode	BBCode data
	 */
	public function bbcode_insert($bbcode = []) {
		
		if (is_array($bbcode) && !empty($bbcode)) {
			$sql = 'INSERT INTO ' . BBCODES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $bbcode);
			$this->db->sql_query($sql);
		}
		
	}
	
	/**
	 * Update BBCode
	 * @param	array	$bbcode	BBCode data
	 */
	public function bbcode_update($bbcode = []) {
		
		if (is_array($bbcode) && !empty($bbcode)) {
			$sql = 'UPDATE ' . BBCODES_TABLE . '
					SET ' . $this->db->sql_build_array('UPDATE', $bbcode) . '
					WHERE bbcode_id = ' . (int) $bbcode['bbcode_id'];
			$this->db->sql_query($sql);
		}
		
	}
	
	/**
	 * Delete BBCode
	 * @param	string	$bbcode	BBCode tag
	 */
	public function bbcode_delete($bbcode = '') {
		
		if (!empty($bbcode)) {
			$sql = 'DELETE FROM ' . BBCODES_TABLE . '
					WHERE bbcode_tag = "' . $this->db->sql_escape($bbcode) . '"';
			$this->db->sql_query($sql);
		}
		
	}
	
	/**
	 * Calculate last BBCode ID
	 * @return	integer
	 */
	public function get_last_bbcode_id() {
		
		$id = NUM_CORE_BBCODES + 1;
		
		$sql = 'SELECT MAX(bbcode_id) AS last_bbcode_id
				FROM ' . BBCODES_TABLE;
		$result = $this->db->sql_query($sql);
		$last_id = (int) $this->db->sql_fetchfield('last_bbcode_id');
		$this->db->sql_freeresult($result);
		
		if ($last_id) {
			$id = $last_id + 1;
			
			if ($id <= NUM_CORE_BBCODES) {
				$id = NUM_CORE_BBCODES + 1;
			}
			
		}
		
		return $id;
	}
}
