<?php
    class Config_model extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function get_config()
        {
            $query = $this->db->get('Config');

            return $query->row_array();
        }
    }