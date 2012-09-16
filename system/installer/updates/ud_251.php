<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2012, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.5
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * ExpressionEngine Update Class
 *
 * @package		ExpressionEngine
 * @subpackage	Core
 * @category	Core
 * @author		EllisLab Dev Team
 * @link		http://expressionengine.com
 */
class Updater {
	
	var $version_suffix = '';
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Do Update
	 *
	 * @return TRUE
	 */
	public function do_update()
	{
		$steps = array(
			'_update_ip_address_length',
			);

		$current_step	= 1;
		$total_steps	= count($steps);

		foreach ($steps as $k => $v)
		{
			$this->EE->progress->step($current_step, $total_steps);
			$this->$v();
			$current_step++;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	private function _update_ip_address_length()
	{
		$this->EE->load->dbforge();

		$tables = array('sessions', 'throttle', 'online_users', 
			'security_hashes', 'captcha', 'password_lockout', 
			'email_console_cache', 'members', 'channel_titles', 
			'channel_entries_autosave', 'cp_log', 'member_search', 
			'remember_me');

		foreach ($tables as $table)
		{
			$column_settings = array(
				'ip_address' => array(
					'name' 			=> 'ip_address',
					'type' 			=> 'varchar',
					'constraint' 	=> 45,
					'default'		=> '0',
					'null'			=> FALSE
				)
			);
			
			if ($table == 'remember_me')
			{
				unset($column_settings['ip_address']['null']);
			}

			$this->EE->migrate->modify_column($table, $column_settings);
		}
	}
}	
/* END CLASS */

/* End of file ud_251.php */
/* Location: ./system/expressionengine/installer/updates/ud_251.php */