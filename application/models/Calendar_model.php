<?php

class Calendar_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Gets the full list of stored months
     */
    public function get_month_list()
    {
        $query = $this->db->query('SELECT ANY_VALUE(DayDate) AS DayDate FROM `Days` GROUP By MONTH(DayDate), YEAR(DayDate)');

        return $query->result_array();
    }

    /**
     * Get the given month or the current if none is given.
     *   If the moth doesn't exists, creates a new one.
     */
    public function get_month($month_number = 0, $id_user = 0)
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
        if ($month > 12)
        {
            $month -= 12;
            $year++;
        }

        $query = $this->db->query(
            'SELECT *, 
            CASE
                WHEN ('.$id_user.' IN (
                    SELECT IdUser FROM DaysUsersHours WHERE IdDay = Days.IdDay)
                ) THEN 1
                ELSE 0
            END as "Registered",
            CASE
                WHEN (SELECT COUNT(*) FROM DaysUsersHours WHERE IdDay = Days.IdDay AND IdUser IS NOT NULL) = 0 THEN 0
                WHEN (SELECT COUNT(*) FROM DaysUsersHours WHERE IdDay = Days.IdDay AND IdUser IS NULL) != 0 THEN 0
                ELSE 1
            END as "Full",
            (SELECT COUNT(*) FROM DaysUsersHours WHERE IdDay = Days.IdDay AND IdUser IS NOT NULL) AS "People"
            FROM `Days` WHERE MONTH(Days.DayDate) = '.$month
        );
        
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
            $query = $this->db->query(
                'SELECT *, 
                CASE
                    WHEN ('.$id_user.' IN (
                        SELECT IdUser FROM DaysUsersHours WHERE IdDay = Days.IdDay)
                    ) THEN 1
                    ELSE 0
                END as "Registered",
                CASE
                    WHEN (SELECT COUNT(*) FROM DaysUsersHours WHERE IdDay = Days.IdDay AND IdUser IS NOT NULL) = 0 THEN 0
                    WHEN (SELECT COUNT(*) FROM DaysUsersHours WHERE IdDay = Days.IdDay AND IdUser IS NULL) != 0 THEN 0
                    ELSE 1
                END as "Full",
                (SELECT COUNT(*) FROM DaysUsersHours WHERE IdDay = Days.IdDay AND IdUser IS NOT NULL) AS "People"
                FROM `Days` WHERE MONTH(Days.DayDate) = '.$month
            );

            return $query->result_array();
        }
    }

    /**
     * Retrieves the avaiable schedules to configure some day
     */
    public function get_config_schedules()
    {
        $query = $this->db->get('ConfigSchedules');

        return $query->result_array();
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
     * Get the given day of some month
     */
    public function get_day_data_by_date($date_str)
    {
        $now = new DateTime();
        if ($date_str)
        {
            $now = new DateTime($date_str);
        }

        $month = $now->format('m');
        $day = $now->format('d');

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
     * Creates the schedule for a given day acording to some schedule id.
     * If the schedule is not given, just use the default config.
     */
    public function create_day_schedule($day_data, $schedule = 0)
    {
        $day_date = new DateTime($day_data['DayDate']);
        $week_day = $day_date->format('N');
        $id_day = $day_data['IdDay'];

        if ($schedule)
        {
            $this->db->where('IdConfigSchedule', $schedule);
        }
        else
        {
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
            $this->create_day_schedule($day_data);

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
            $this->create_day_schedule($day_data);

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
     * Removes all the hours/users of some day
     */
    public function remove_day_schedule($id_day)
    {
        $this->db->where('IdDay', $id_day);
        $this->db->delete('DaysUsersHours');
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
     * Deletes some hour of some schedule
     */
    public function remove_hour_from_schedule($id_day, $id_hour)
    {
        $this->db->where('IdDay', $id_day);
        $this->db->where('IdHour', $id_hour);

        $this->db->delete('DaysUsersHours');
    }
}

?>