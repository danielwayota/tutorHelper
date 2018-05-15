<?php
    class Pages extends CI_Controller
    {
        public function index()
        {
            $this->load->view('templates/header.php');
            $this->load->view('templates/menu.php');
            $this->load->view('pages/single_page.php');
            $this->load->view('templates/footer.php');
        }
    }