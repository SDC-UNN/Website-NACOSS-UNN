<?php

/*
 * Copyright 2015 NACOSS UNN Developers Group (NDG).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

	  const SORT_STUDENTS_TYPE_FIRSTNAME = "first_name";
	  const SORT_STUDENTS_TYPE_LASTNAME = "last_name";
	  const SORT_STUDENTS_TYPE_OTHERNAMES = "other_names";
	  const SORT_STUDENTS_TYPE_DATE_GENDER = "gender";

	  const ORDER_STUDENTS_ASC = "ASC";
	  const ORDER_STUDENTS_DESC = "DESC";

function getNumberOfStudents($level, $gender='all'){
	$query = "select * from users where level='$level'";
	$query .= ($gender != 'all') ? " and gender='$gender'" : "";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return 0;
}

function getStudentsList($level, $gender='all', $auto_index = true){
	$students = array();
	$query = "select * from users where level='$level'";
	$query .= ($gender != 'all') ? " and gender='$gender'" : "";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        if($auto_index === true){
			while ($row = mysqli_fetch_array($result)) {
				$students[] = $row;
			}
		}else{
			while ($row = mysqli_fetch_array($result)) {
				$students[$row[$auto_index]] = $row;
			}
		}
        sortStudentsList($students, SORT_STUDENTS_TYPE_FIRSTNAME, ORDER_STUDENTS_ASC);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return $students;
}

/**
 * 
 * @param type $search_query
 * @param type $sort_type
 * @param type $sort_order
 * @return array
 */
function searchStudentsList($search_query, $level, $gender='all', $sort_type = NULL, $sort_order = NULL){
    $students = array();
    $link = AdminUtility::getDefaultDBConnection();
    //process query
    $fields = explode(" ", $search_query);
	$query = "select * from users where level='$level'";
	$query .= ($gender != 'all') ? " and gender='$gender'" : "";
    $query .= " and (";
    for ($count = 0; $count < count($fields); $count++) {
        $query .= "regno like '%$fields[$count]%' or "
				. "first_name like '%$fields[$count]%' or "
                . "last_name like '%$fields[$count]%' or "
                . "other_names like '%$fields[$count]%'";
        if ($count !== (count($fields) - 1)) {
            $query .= " or ";
        }
    }
	$query .= ")";
	//Search
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($students, $row);
        }
        sortStudentsList($students, $sort_type, $sort_order);
    }
    //Log error
    AdminUtility::logMySQLError($link);
    return $students;
}

function sortStudentsList(array &$students, $sort_type, $sort_order) {
    if (empty($students)) {
        return;
    }

    foreach ($students as $key => $row) {
        $regno[$key] = $row['regno'];
        $first_name[$key] = $row['first_name'];
        $last_name[$key] = $row['last_name'];
        $other_names[$key] = $row['other_names'];
    }

    switch ($sort_type) {
        case SORT_STUDENTS_TYPE_FIRSTNAME:
            array_multisort($first_name, ($sort_order == ORDER_STUDENTS_DESC ? SORT_DESC : SORT_ASC), $students);
            break;
        case SORT_STUDENTS_TYPE_LASTNAME:
            array_multisort($last_name, ($sort_order == ORDER_STUDENTS_DESC ? SORT_DESC : SORT_ASC), $first_name, SORT_ASC, $students);
            break;
        case SORT_STUDENTS_TYPE_OTHERNAMES:
            array_multisort($other_names, ($sort_order == ORDER_STUDENTS_DESC ? SORT_DESC : SORT_ASC), $first_name, SORT_ASC, $last_name, SORT_ASC, $students);
            break;
        default :
            throw new Exception("Invalid sort type");
    }
}

function getStudentsList_contactGroups(Admin $admin, $is_temp=0, $gender='all'){
	$user_id = $admin->getField('username');
	$level = $admin->getField('level');
	$students = getStudentsList($level, $gender, 'regno');
	$groups = array();
	
	$query = "select * from messenger_contacts_groups where username='$user_id' and is_temp=$is_temp";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while($row = mysqli_fetch_array($result)){
			$group = array();
			$group['group_id'] = $row['id'];
			$group_members = array();
			$group_members_ids = explode(',', $row['group_members']);
			
			foreach($group_members_ids as $menber_id){
				$group_members[] = $students[$menber_id];
			}
			
	        sortStudentsList($group_members, SORT_STUDENTS_TYPE_FIRSTNAME, ORDER_STUDENTS_ASC);
			$group = array_merge($group, $row);
			$group['group_members'] = $group_members;
            $groups[] = $group;
        }//end while
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return $groups;
}

function getByCol($table, $key_col, $key_col_val){
	$query = "select * from ".$table." where ".$key_col."='".$key_col_val."'";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
		$row = mysqli_fetch_array($result);
		return $row;
	}
	return false;
}

function totalSmsSent($user_id){
	$query = "select sum(num_delivered) as num from messenger_log where user_id = '".$user_id."' and is_sent=1";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
		$row = mysqli_fetch_array($result);
		return $row['num'];
	}
    //Log error
    AdminUtility::logMySQLError($link);
	return false;
}
?>