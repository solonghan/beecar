<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Car extends CI_Controller {

	public function index($input)
	{
		$this->load->view('car/'.$input);
	}
}
