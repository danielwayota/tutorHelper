<?php
    class TH_Controller extends CI_Controller
    {
        public $pages;

        public function __construct() 
        {
            parent::__construct();
        }
        /**
         * Loads the header and footer templates. It's just to write less code.
         * 
         * @args: $config - This is an array containing some basic config.
         * Eg: {
         *      'title': Optional parameter for the page title, it gets added to de page title
         *      'selected_page_id':
         * }
         */

        public function load_header_and_menu($config = array())
        {
            $this->pages = $this->page_model->get_all_pages();

            $data['config'] = $config;

            $this->load->view('templates/header.php', $data);

            $data['pages'] = $this->pages;
            $this->load->view('templates/menu.php', $data);
        }

        /**
         * Just load the footer template
         */
        public function load_footer()
        {
            $this->load->view('templates/footer.php');
        }

        /**
         * Check user session.
         *   If there is none, redirect to login page.
         */
        public function check_user_session()
        {
            $valid = true;

            // Check session data.
            if (!$this->session->userdata('logged_in'))
            {
                $valid = false;
            }

            // Check if the user is activated.
            if ($valid)
            {
                $user_id = $this->session->userdata('IdUser');
                $user_data = $this->user_model->get_user($user_id);

                if (!$user_data['Enabled'])
                {
                    $valid = false;
                }
            }

            if (!$valid)
            {
                $this->session->set_flashdata('notification', 'No tienes permisos para acceder o tu usuario ha sido desactivadoPáginas.');
                redirect('index.php/users/login');
            }
        }
    }