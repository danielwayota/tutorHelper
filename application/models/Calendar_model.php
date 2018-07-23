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
}

?>