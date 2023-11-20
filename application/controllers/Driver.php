<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends CI_Controller {

	public function index($input)
	{
		$this->load->view('driver/'.$input);
	}

}
