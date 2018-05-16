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
    }