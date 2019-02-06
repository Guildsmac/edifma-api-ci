<?php
/**
 * Copyright (c) 2019.
 * Developed by Gabriel Sousa
 * @author Gabriel Sousa <gabrielssc.ti@gmail.com>
 * Last modified 09/11/18 08:15.
 *
 */

/**
 * Created by PhpStorm.
 * User: luisclaudio
 * Date: 06/11/2018
 * Time: 08:49
 */

class Migrate extends CI_Controller
{

    public function index(){
        $this->load->library('migration');
        if($this->migration->version('20181106120516') === FALSE){
            show_error($this->migration->error_string());

        }
        if($this->migration->version('20181106121245') === FALSE){
            show_error($this->migration->error_string());

        }
        if($this->migration->version('20181106121643') === FALSE){
            show_error($this->migration->error_string());

        }
        if($this->migration->version('20190206154946') === FALSE){
            show_error($this->migration->error_string());

        }
    }

}