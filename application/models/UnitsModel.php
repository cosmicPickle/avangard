<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnitsModel extends CI_Model {


	public function load() {
		return $this->db->get('units')->result();
	}
}
