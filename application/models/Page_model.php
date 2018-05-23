<?php
    class Page_model extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        /**
         * Retrieve all pages from the database
         */
        public function get_all_pages()
        {
            $this->db->order_by('Position', 'ASC');
            $query = $this->db->get('Pages');

            return $query->result_array();
        }

        /**
         * Retrieves a single page
         * @param: $id
         * @return: Will return the page with the given ID or the first one
         */
        public function get_single_page($id = 0)
        {
            $this->db->order_by('Position', 'ASC');
            $this->db->limit(1);

            if ($id !== 0)
            {
                $this->db->where('IdPage', $id);
            }

            $query = $this->db->get('Pages');

            return $query->row_array();
        }

        /**
         * Creates one page.
         */
        public function create_page($page_data)
        {
            return $this->db->insert('Pages', $page_data);
        }

        /**
         * Updates the info of a page
         */
        public function update_page($id, $page_data)
        {
            $this->db->where('IdPage', $id);

            return $this->db->update('Pages', $page_data);
        }

        /**
         * Deletes some page
         * @param: id
         */
        public function delete_page($id)
        {
            $this->db->where('IdPage', $id);

            return $this->db->delete('Pages');
        }
    }