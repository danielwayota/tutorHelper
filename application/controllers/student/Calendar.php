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
            $data['IdUser'] = $this->session->userdata('IdUser');

            if ($day_data['Locked'] || $day_number <= $today->format('d'))
            {
                $this->show_notification('Día bloqueado', 'error');
                redirect('student/calendar/month');
            }
            else
            {
                if ($this->input->post('id-hour') != NULL)
                {
                    $id_user = $data['IdUser'];
                    $id_day = $day_data['IdDay'];
                    $id_hour = $this->input->post('id-hour');

                    if ($this->calendar_model->add_user_to_schedule($id_day, $id_user, $id_hour))
                    {
                        $this->show_notification('Registrado.');
                    }
                    else
                    {
                        $this->show_notification('La Hora está ya reservada.', 'error');
                    }

                }

                $hours = $this->calendar_model->get_day_schedule($day_data);
                $data['hours'] = $hours;
                $this->load->view('student_calendar/view_day', $data);
            }

            $this->load_footer();
        }
    }