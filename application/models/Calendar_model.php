<?php

class Calendar_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Get the given month or the current if none is given.
     *   If the moth doesn't exists, creates a new one.
     */
    public function get_month($month_number = 0)
    {
        $now = time();
        $day = 1;
        $year = date('Y', $now);
        $month = date('m', $now);

        if ($month_number !== 0)
        {
            $month = $month_number;
        }

        // Try to get the month data.
        $this->db->where('MONTH(DayDate)', $month);
        $query = $this->db->get('Days');
        
        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            // Create the month data.
            $le_date = new DateTime($year . '-' . $month . '-' . $day);
    
            $days = cal_days_in_month(CAL_GREGORIAN, intval($month), intval($year));
    
            // Iterate the month's days.
            $days_data = array();
            for ($i = $day; $i <= $days; $i++)
            {
                $week_day = $le_date->format('N');

                $locked = 0;

                if ($week_day > 5)
                {
                    $locked = 1;
                }

                array_push($days_data, array(
                    'DayDate' => $le_date->format('Y-m-d'),
                    'Locked' => $locked
                ));
    
                $le_date->modify('+1 day');
            }
            $this->db->insert_batch('Days', $days_data);

            // Get the recent inserted month data.
            $this->db->where('MONTH(DayDate)', $month);
            $query = $this->db->get('Days');

            return $query->result_array();
        }
    }

    /**
     * Get the given day of the current month
     */
    public function get_day($day)
    {
        $now = time();
        $month = date('m', $now);

        $this->db->where('MONTH(DayDate)', $month);
        $this->db->where('DAY(DayDate)', $day);
        $query = $this->db->get('Days');

        return $query->row_array();
    }

    /**
     * Modify day configuration
     */
    public function modify_day($id_day, $config)
    {
        $this->db->where('IdDay', $id_day);

        return $this->db->update('Days', $config);
    }

    /**
     * Creates the schedule for a given day acording to the default config.
     */
    public function create_default_day_schedule($day_data)
    {
        $day_date = new DateTime($day_data['DayDate']);
        $week_day = $day_date->format('N');
        $id_day = $day_data['IdDay'];

        if ($week_day != 5)
        {
            // Not friday
            $this->db->where('IdConfigSchedule', 1);
        }
        else
        {
            // Friday
            $this->db->where('IdConfigSchedule', 2);
        }
        // $this->db->join('Hours', 'ConfigSchedulesHours.IdHour = Hours.IdHour');
        $query = $this->db->get('ConfigSchedulesHours');
        $hours_ids = $query->result_array();

        $data_to_insert = array();

        foreach ($hours_ids as $hour_id)
        {
            $tmp = array(
                'IdDay' => $id_day,
                'IdUser' => NULL,
                'IdHour' => $hour_id['IdHour']
            );

            array_push($data_to_insert, $tmp);
        }

        $this->db->insert_batch('DaysUsersHours', $data_to_insert);
    }

    /**
     * Get the Schedule of the day
     */
    public function get_day_schedule($day_data)
    {
        $id_day = $day_data['IdDay'];

        $this->db->where('IdDay', $id_day);
        $this->db->join('Hours', 'DaysUsersHours.IdHour = Hours.IdHour');
        $query = $this->db->get('DaysUsersHours');

        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            $this->create_default_day_schedule($day_data);

            $this->db->where('IdDay', $id_day);
            $this->db->join('Hours', 'DaysUsersHours.IdHour = Hours.IdHour');
            $query = $this->db->get('DaysUsersHours');

            return $query->result_array();
        }
    }

    /**
     * Get the Schedule for some day and the users associated
     */
    public function get_day_schedule_with_users($day_data)
    {
        $id_day = $day_data['IdDay'];

        $this->db->where('IdDay', $id_day);
        $this->db->join('Hours', 'DaysUsersHours.IdHour = Hours.IdHour');
        $this->db->join('Users', 'DaysUsersHours.IdUser = Users.IdUser', 'left');
        $this->db->order_by('Hours.IdHour');
        $query = $this->db->get('DaysUsersHours');

        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            $this->create_default_day_schedule($day_data);

            $this->db->where('IdDay', $id_day);
            $this->db->join('Hours', 'DaysUsersHours.IdHour = Hours.IdHour');
            $this->db->join('Users', 'DaysUsersHours.IdUser = Users.IdUser', 'left');
            $this->db->order_by('Hours.IdHour');
            $query = $this->db->get('DaysUsersHours');

            return $query->result_array();
        }
    }

    /**
     * Inserts the current user in some hour, some day.
     * If the user is already in that day, just move to the next hour.
     */
    public function add_user_to_schedule($id_day, $id_user, $id_hour)
    {
        $this->db->where('IdDay', $id_day);
        $this->db->where('IdHour', $id_hour);
        $query = $this->db->get('DaysUsersHours');
        $data = $query->row_array();

        // Check if there is already someone there
        if ($data['IdUser'] == NULL)
        {
            $this->db->set('IdUser', NULL);
            $this->db->where('IdDay', $id_day);
            $this->db->where('IdUser', $id_user);
            $this->db->update('DaysUsersHours');
    
            $this->db->set('IdUser', $id_user);
            $this->db->where('IdDay', $id_day);
            $this->db->where('IdHour', $id_hour);
            $this->db->update('DaysUsersHours');

            return TRUE;
        }

        return FALSE;
    }

    /**
     * Deletes a user form some hour, some day.
     */
    public function remove_user_from_schedule($id_day, $id_user)
    {
        $this->db->set('IdUser', NULL);
        $this->db->where('IdDay', $id_day);
        $this->db->where('IdUser', $id_user);
        $this->db->update('DaysUsersHours');
    }

    /**
     * Retrieves the list of users from some day
     */
    public function get_user_of_day($id_day)
    {
        
    }
}

?>