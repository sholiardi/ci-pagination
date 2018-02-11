<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DjabesUsers extends CI_Model
{
    private $dbo;

    function __construct()
    {
      parent::__construct();
      $this->dbo = $this->load->database('djabes', true);
    }

    public function get_current_page_records($limit, $start)
    {
        $sql = "
            select * from (
                select
                    row_number() over (order by user_name asc) as number, *
                from
                    user_app
            ) t where t.number between " . ($start + 1) . " and " . ($start + $limit) . "
        ";

        $query = $this->dbo->query($sql);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $data[] = $row;
            }

            return $data;
        }

        return false;
    }

    public function get_total()
    {
        $sql = "select count(*) total from user_app";
        $query = $this->dbo->query($sql);
        $row = $query->row_array();
        return $row['total'];
    }

}
