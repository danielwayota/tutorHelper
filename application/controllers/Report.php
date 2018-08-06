<?php
    class Report extends TH_Controller
    {
        public function index()
        {
            $this->check_superadmin_session();
            $this->load_header_and_menu();

            $data['MONTH_LIST'] = $this->calendar_model->get_month_list();

            $this->load->view('report/view_list.php', $data);

            $this->load_footer();
        }
    }