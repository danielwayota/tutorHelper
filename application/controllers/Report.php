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

        public function month($date)
        {
            $this->check_superadmin_session();
            $this->load_header_and_menu();

            $date_data = explode('-', $date);

            $month = $date_data[0];
            $year = $date_data[1];

            $data['MONTH_REPORT'] = $this->calendar_model->get_month_report($month, $year);
            $data['CONFIG'] = $this->config_model->get_config();
            $data['DATE_DATA'] = $date_data;

            $this->load->view('report/view_month.php', $data);

            $this->load_footer();
        }
    }