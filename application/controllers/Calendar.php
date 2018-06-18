<?php
    class Calendar extends TH_Controller
    {
        /**
         * Current month view
         */
        public function month($month_number = 0)
        {
            $this->load_header_and_menu();

            $month = $this->calendar_model->get_month($month_number);

            $data['month'] = $month;

            $this->load->view('admin_calendar/view_month', $data);

            $this->load_footer();
        }
    }
?>