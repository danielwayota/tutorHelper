<?php
    /**
     * Administrator Calendar
     */
    class Calendar extends TH_Controller
    {
        /**
         * Current month view
         */
        public function month()
        {
            $this->check_superadmin_session();
            $this->load_header_and_menu();
            
            $month_number = date('m', time());
            $month = $this->calendar_model->get_month($month_number);
            $month_number++;
            $next_month = $this->calendar_model->get_month($month_number);

            $data['MONTH'] = $month;
            $data['NEXT_MONTH'] = $next_month;

            $this->load->view('admin_calendar/view_month', $data);

            $this->load_footer();
        }

        /**
         * Random day view
         */
        public function day($day = NULL)
        {
            $this->check_superadmin_session();

            $day_data = $this->calendar_model->get_day_data_by_date($day);
            
            // Modification actions
            if ($this->input->post('edit-day'))
            {
                // Generate the config to be saved
                $day_config = array(
                    'Locked' => $this->input->post('locked') ? 1 : 0
                );

                // Do the update
                $this->calendar_model->modify_day($day_data['IdDay'], $day_config);

                // Reload the day data
                $day_data = $this->calendar_model->get_day_data_by_date($day);

                $this->show_notification('Día modificado.');
            }

            if ($this->input->post('remove-hour'))
            {
                $id_day = $day_data['IdDay'];
                $id_hour = $this->input->post('remove-hour');
                $this->calendar_model->remove_hour_from_schedule($id_day, $id_hour);
            }
            if ($this->input->post('remove-student'))
            {
                $id_day = $day_data['IdDay'];
                $id_user = $this->input->post('remove-student');
                $this->calendar_model->remove_user_from_schedule($id_day, $id_user);
            }

            if ($this->input->post('reset-schedule'))
            {
                $id_day = $day_data['IdDay'];
                $id_schedule = $this->input->post('schedule');
                $this->calendar_model->remove_day_schedule($id_day);
                $this->calendar_model->create_day_schedule($day_data, $id_schedule);
            }
        
            $this->load_header_and_menu();
            if ($day === 0)
            {
                $this->show_notification('No hay día especificado.', 'error');
            }
            else
            {
                $data['DAY'] = $day_data;

                $data['SCHEDULE'] = $this->calendar_model->get_day_schedule_with_users($day_data);
                $data['CONFIG_SCHEDULES'] = $this->calendar_model->get_config_schedules();
    
                $this->load->view('admin_calendar/view_day', $data);
            }

            $this->load_footer();
        }
    }
?>