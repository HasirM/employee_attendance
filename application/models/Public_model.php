<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Public_model extends CI_Model
{
  public function getAccount($username)
  {
    $account = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $account['employee_id'];
    $query = "SELECT  employee.id AS `id`,
                      employee.name AS `name`,
                      employee.gender AS `gender`,   
                      employee.shift_id AS `shift`,
                      employee.image AS `image`,
                      employee.birth_date AS `birth_date`,
                      employee.hire_date AS `hire_date`,
                      department.id AS `department_id`
                FROM  employee
          INNER JOIN  employee_department ON employee.id = employee_department.employee_id
          INNER JOIN  department ON employee_department.department_id = department.id
               WHERE `employee`.`id` = '$e_id'";
    return $this->db->query($query)->row_array();
  }

  // public function get_attendance($start, $end, $dept, $shift)
  // {
  //   if ($dept == 'ALL'){
  //   $query = "SELECT  attendance.in_time AS date,
  //                     attendance.shift_id AS shift,
  //                     employee.name AS name,
  //                     attendance.notes AS notes,
  //                     attendance.image AS image,
  //                     attendance.lack_of AS lack_of,
  //                     attendance.in_status AS in_status,
  //                     attendance.out_time AS out_time,
  //                     attendance.out_status AS out_status,
  //                     attendance.employee_id AS e_id,
  //                     attendance.department_id AS dept,
  //                     shift.start,
  //                     shift.end
  //               FROM  attendance
  //         INNER JOIN  employee_department
  //                 ON  attendance.employee_id = employee_department.employee_id
  //         INNER JOIN  employee
  //                 ON  attendance.employee_id = employee.id
  //         INNER JOIN  shift
  //                 ON  employee.shift_id = shift.id
  //               WHERE (DATE(FROM_UNIXTIME(in_time)) BETWEEN '$start' AND '$end')
  //           ORDER BY  `date` ASC";
  //   }else{
  //     $query = "SELECT  attendance.in_time AS date,
  //                     attendance.shift_id AS shift,
  //                     employee.name AS name,
  //                     attendance.notes AS notes,
  //                     attendance.image AS image,
  //                     attendance.lack_of AS lack_of,
  //                     attendance.in_status AS in_status,
  //                     attendance.out_time AS out_time,
  //                     attendance.out_status AS out_status,
  //                     attendance.employee_id AS e_id,
  //                     attendance.department_id AS dept,
  //                     shift.start,
  //                     shift.end
  //               FROM  attendance
  //               INNER JOIN  employee_department
  //                 ON  attendance.employee_id = employee_department.employee_id
  //               INNER JOIN  employee
  //                 ON  attendance.employee_id = employee.id
  //               INNER JOIN  shift
  //                 ON  employee.shift_id = shift.id
  //               WHERE  employee_department.department_id = '$dept'
  //                 AND  (DATE(FROM_UNIXTIME(in_time)) BETWEEN '$start' AND '$end')
  //               ORDER BY  `date` ASC";
  //   }

  //   return $this->db->query($query)->result_array();
  // }


  public function get_attendance($start, $end, $dept, $shift, $e_id)
{
    $where_conditions = array();
    if ($dept != 'ALL' && !empty($dept)) {
        $where_conditions[] = "employee_department.department_id = '$dept'";
    }
    if ( $shift != 'ALL' && !empty($e_id) ) {
        $where_conditions[] = "employee.shift_id IN ($shift)";
    }
    if ($e_id != 'ALL' && !empty($e_id)) {
        $where_conditions[] = "attendance.employee_id = '$e_id'";
    }
    
    $where_clause = "";
    if (!empty($where_conditions)) {
        $where_clause = "WHERE " . implode(" AND ", $where_conditions);
    }

    $query = "SELECT  attendance.in_time AS date,
                      attendance.shift_id AS shift,
                      employee.name AS name,
                      attendance.notes AS notes,
                      attendance.image AS image,
                      attendance.lack_of AS lack_of,
                      attendance.in_status AS in_status,
                      attendance.out_time AS out_time,
                      attendance.out_status AS out_status,
                      attendance.employee_id AS e_id,
                      attendance.department_id AS dept,
                      shift.start,
                      shift.end
                FROM  attendance
                INNER JOIN  employee_department
                  ON  attendance.employee_id = employee_department.employee_id
                INNER JOIN  employee
                  ON  attendance.employee_id = employee.id
                INNER JOIN  shift
                  ON  employee.shift_id = shift.id
                $where_clause
                AND (DATE(FROM_UNIXTIME(in_time)) BETWEEN '$start' AND '$end')
                ORDER BY `date` ASC";

    return $this->db->query($query)->result_array();
}


  public function get_emp_attendance($e_id, $start, $end)
{
    $query = "SELECT  attendance.in_time AS date,
                      attendance.shift_id AS shift,
                      employee.name AS name,
                      attendance.notes AS notes,
                      attendance.image AS image,
                      attendance.lack_of AS lack_of,
                      attendance.in_status AS in_status,
                      attendance.out_time AS out_time,
                      attendance.out_status AS out_status,
                      attendance.employee_id AS e_id,
                      shift.start,
                      shift.end
                FROM  attendance
          INNER JOIN  employee_department
                  ON  attendance.employee_id = employee_department.employee_id
          INNER JOIN  employee
                  ON  attendance.employee_id = employee.id
          INNER JOIN  shift
                  ON  employee.shift_id = shift.id
                WHERE  employee.id = '$e_id'";

    // Conditionally add date filter if start and end dates are provided
    if ($start !== null && $end !== null) {
        $query .= " AND (DATE(FROM_UNIXTIME(in_time)) BETWEEN '$start' AND '$end')";
    }
    
    $query .= " ORDER BY `date` ASC";

    return $this->db->query($query)->result_array();
}


  public function getAllEmployeeData($username)
  {
    // get employee id from users table
    $data = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $data['employee_id'];

    // Join Query
    $query = "SELECT  employee.id AS `id`,
                      employee.name AS `name`,
                      employee.gender AS `gender`,
                      employee.image AS `image`,
                      employee.birth_date AS `birth_date`,
                      employee.hire_date AS `hire_date`,
                      department.name AS `department`
                FROM  employee
          INNER JOIN  employee_department ON employee.id = employee_department.employee_id
          INNER JOIN  department ON employee_department.department_id = department.id
               WHERE `employee`.`id` = $e_id";
    // get employee data from employee table using employee id and return the row
    return $this->db->query($query)->row_array();
  }
}
