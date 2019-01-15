<?php
    /**
     * Student Calendar
     */
    class Calendar extends TH_Controller
    {
        /**
         * Current month view
         */
        public function month($month_offset = NULL)
        {
            $this->check_user_session();
            $this->load_header_and_menu();

            $user_id = $this->session->userdata('IdUser');

            $month_number = date('m', time());
            $month = $this->calendar_model->get_month($month_number, $user_id);
            $month_number++;
            $next_month = $this->calendar_model->get_month($month_number, $user_id);

            $data['MONTH'] = $month;
            $data['NEXT_MONTH'] = $next_month;

            $this->load->view('student_calendar/view_month', $data);

            $this->load_footer();
        }

        public function day($day = NULL)
        {
            $this->check_user_session();
            $this->load_header_and_menu();

            $day_data = $this->calendar_model->get_day_data_by_date($day);

            $day_date = new DateTime($day_data['DayDate']);
            $day_number = $day_date->format('d');
            $day_month = $day_date->format('m');
            
            $today = new DateTime();
            
            $data['DAY'] = $day_data;
            $data['ID_USER'] = $this->session->userdata('IdUser');

            $locked = false;

            if ($day_data['Locked'])
            {
                $locked = true;
            }

            if (!$locked && $day_month < $today->format('m'))
            {
                $locked = true;
            }

            if (!$locked && $day_month == $today->format('m'))
            {
                if ($day_number <= $today->format('d'))
                {
                    $locked = true;
                }
            }

            if ($locked)
            {
                $this->show_notification('Día bloqueado', 'error');
                redirect('student/calendar/month');
            }
            else
            {
                if ($this->input->post('remove-me') != NULL)
                {
                    $id_user = $data['ID_USER'];
                    $id_day = $day_data['IdDay'];
                    $id_hour = $this->input->post('id-hour');

                    $this->calendar_model->remove_user_from_schedule($id_day, $id_user);
                    $this->show_notification('Reserva eliminada');
                }

                if ($this->input->post('id-hour') != NULL)
                {
                    $id_user = $data['ID_USER'];
                    $id_day = $day_data['IdDay'];
                    $id_hour = $this->input->post('id-hour');

                    if ($this->calendar_model->add_user_to_schedule($id_day, $id_user, $id_hour))
                    {
                        $this->show_notification('Hora reservada');
                    }
                    else
                    {
                        $this->show_notification('La hora ya se encuentra reservada', 'error');
                    }

                }

                $hours = $this->calendar_model->get_day_schedule($day_data);
                $data['HOURS'] = $hours;
                $this->load->view('student_calendar/view_day', $data);
            }

            $this->load_footer();
        }
    }