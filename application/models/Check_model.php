<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Check_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

    // Insert a new check into the database
    public function insert_check($data) {
        if ($this->db->insert('c19_checks', $data)) {
            return $this->db->insert_id(); // Return the ID of the new record
        } else {
            return false; // Return false if the insert failed
        }
    }

    
}
