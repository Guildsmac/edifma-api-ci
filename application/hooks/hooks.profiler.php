<?php
/**
 * Copyright (c) 2019.
 * Developed by Gabriel Sousa
 * @author Gabriel Sousa <gabrielssc.ti@gmail.com>
 * Last modified 09/11/18 08:15.
 *
 */

/*
 * Class for enabling profiler through out the application
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Zeeshan M
 */
class ProfilerEnabler
{
	// enable or disable profiling based on config values
	function enableProfiler(){		
		$CI = &get_instance();
		$CI->output->enable_profiler( config_item('enable_profiling') );		
	}
}
?>
