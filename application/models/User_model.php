<?php
    class User_model extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        /**
         * Login function.
         * @return: User data.
         */
        public function login($credentials)
        {
            $this->db->where('Email', $credentials['email']);
            $this->db->where('Password', $credentials['password']);

            $query = $this->db->get('Users');

            return $query->row_array();
        }

        /**
         * Retrieves a user from the database;
         * @return: User data
         */
        public function get_user($user_id)
        {
            $this->db->where('IdUser', $user_id);
            $query = $this->db->get('Users');

            return $query->row_array();
        }
    }