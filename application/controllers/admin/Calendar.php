<?php
    /**
     * Administrator Calendar
     */
    class Calendar extends TH_Controller
    {
        /**
         * Current month view
         */
        public function month($month_number = 0)
        {
            $this->check_superadmin_session();
            $this->load_header_and_menu();

            $month = $this->calendar_model->get_month($month_number);

            $data['month'] = $month;

            $this->load->view('admin_calendar/view_month', $data);

            $this->load_footer();
        }

        /**
         * Random day view
         */
        public function day($day = 0)
        {
            $this->check_superadmin_session();

            $day_data = $this->calendar_model->get_day($day);
            
            if ($this->input->post('action'))
            {
                if ($this->input->post('action') == 'day-config')
                {
                    // Generate the config to be saved
                    $day_config = array(
                        'Locked' => $this->input->post('locked') ? 1 : 0
                    );

                    // Do the update
                    $this->calendar_model->modify_day($day_data['IdDay'], $day_config);

                    // Reload the day data
                    $day_data = $this->calendar_model->get_day($day);

                    $this->show_notification('Día modificado.');
                }
            }
            
            $this->load_header_and_menu();
            if ($day === 0)
            {
                $this->show_notification('No hay día especificado.', 'error');
            }
            else
            {
                $data['day'] = $day_data;
    
                $this->load->view('admin_calendar/view_day', $data);
            }

            $this->load_footer();
        }
    }
?>