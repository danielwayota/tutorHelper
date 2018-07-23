<?php
    /**
     * Student Calendar
     */
    class Calendar extends TH_Controller
    {
        /**
         * Current month view
         */
        public function month($month_number = 0)
        {
            $this->check_user_session();
            $this->load_header_and_menu();

            $month = $this->calendar_model->get_month($month_number);

            $data['month'] = $month;

            $this->load->view('student_calendar/view_month', $data);

            $this->load_footer();
        }

        public function day($day = 0)
        {
            $this->check_user_session();
            $this->load_header_and_menu();

            $day_data = $this->calendar_model->get_day($day);

            $day_date = new DateTime($day_data['DayDate']);
            $day_number = $day_date->format('d');

            $today = new DateTime();

            $data['day'] = $day_data;

            if ($day_data['Locked'] || $day_number <= $today->format('d'))
            {
                $this->session->set_flashdata('notification', 'Día bloqueado');
                $this->session->set_flashdata('notification_color', 'deep-orange lighten-1');
                redirect('student/calendar/month');
            }
            else
            {
                $this->load->view('student_calendar/view_day', $data);
            }

            $this->load_footer();
        }
    }