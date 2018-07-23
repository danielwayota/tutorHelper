<?php
    class NotFound extends TH_Controller
    {
        public function index()
        {
            $this->load_header_and_menu();
            $this->load->view('errors/not_found.php');
            $this->load_footer();
        }
    }