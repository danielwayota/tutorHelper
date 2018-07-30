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

            $month_number = date('m', time());
            if ($month_offset) :
                if ($month_offset == 'next') :
                    $month_number++;
                else:
                    redirect('student/calendar/month');
                endif;
            endif;
            
            $this->load_header_and_menu();

            $month = $this->calendar_model->get_month($month_number);

            $data['MONTH'] = $month;

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

            $today = new DateTime();

            $data['DAY'] = $day_data;
            $data['ID_USER'] = $this->session->userdata('IdUser');

            if ($day_data['Locked'] || $day_number <= $today->format('d'))
            {
                $this->show_notification('Día bloqueado', 'error');
                redirect('student/calendar/month');
            }
            else
            {
                if ($this->input->post('remove-me') != NULL)
                {
                    $id_user = $data['IdUser'];
                    $id_day = $day_data['IdDay'];
                    $id_hour = $this->input->post('id-hour');

                    $this->calendar_model->remove_user_from_schedule($id_day, $id_user);
                    $this->show_notification('Borrado.');
                }

                if ($this->input->post('id-hour') != NULL)
                {
                    $id_user = $data['ID_USER'];
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
                $data['HOURS'] = $hours;
                $this->load->view('student_calendar/view_day', $data);
            }

            $this->load_footer();
        }
    }