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
        /**
        * Retrieves a user from the database with it's data
        * @return: User data
        */
       public function get_user_with_data($user_id)
       {
           $this->db->select('Users.IdUser, Email, Name, Enabled, IsSuperAdmin, Comments, PriceOverride');
           $this->db->from('Users');
           $this->db->where('Users.IdUser', $user_id);
           $this->db->join('UsersData', 'Users.IdUser = UsersData.IdUser');
           $query = $this->db->get();

           return $query->row_array();
       }

        /**
         * Retrieves just regular users from the database, not the superuser
         * @return: Users list
         */
        public function get_regular_users()
        {   
            $this->db->select('Users.IdUser, Email, Name, Enabled, IsSuperAdmin, Comments, PriceOverride');
            $this->db->from('Users');
            $this->db->where('IsSuperAdmin', 0);
            $this->db->join('UsersData', 'Users.IdUser = UsersData.IdUser');
            $query = $this->db->get();

            return $query->result_array();
        }

        /**
         * 
         */
        public function check_email_exists($email)
        {
            $this->db->where('Email', $email);
            $query = $this->db->get('Users');

            return empty($query->row_array());
        }

        /**
         * Creates a regular user. No SuperAdmin.
         */
        public function create_regular_user($user, $extra)
        {
            $this->db->insert('Users', $user);

            // Loads the id from the new user and adds the data for it
            $this->db->where('Email', $user['Email']);
            $query = $this->db->get('Users');
            $new_one = $query->row_array();
            $extra['IdUser'] = $new_one['IdUser'];
            $this->db->insert('UsersData', $extra);
        }

        /**
         * Updates a regular user and it's data
         */
        public function update_regular_user($id, $user, $extra)
        {
            $this->db->where('IdUser', $id);
            $this->db->update('Users', $user);

            $this->db->where('IdUser', $id);
            $this->db->update('UsersData', $extra);
        }

        /**
         * Deletes a single user
         */
        public function delete_regular_user($id)
        {
            $this->db->where('IdUser', $id);
            $d1 = $this->db->delete('Users');

            // Deletes the extra data for the user
            $this->db->where('IdUser', $id);
            $this->db->delete('UsersData');

            return $d1;
        }
    }