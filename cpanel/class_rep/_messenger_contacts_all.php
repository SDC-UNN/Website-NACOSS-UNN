<?php
//Initializing variables with default values
$defaultPage = "index.php?p=1";
$sort_type = SORT_STUDENTS_TYPE_FIRSTNAME;
$order = ORDER_STUDENTS_ASC;
$level = $admin->getField('level');

$message = "";

if(isset($array['search_button']) ){
    //process POST requests
    $page = 22;
    $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
    $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
    $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));
    $students = searchStudentsList($searchQuery, $level, $gender='all', $sort_type, $order);
}else{
    //Process GET requests or no requests
    $page = filter_input(INPUT_GET, "pg");
    if (isset($page)) {
        //if switching page, repeat search
        $searchQuery = filter_input(INPUT_GET, "q");
        $sort_type = filter_input(INPUT_GET, "s");
        $order = filter_input(INPUT_GET, "o");
	    $students = searchStudentsList($searchQuery, $level, $gender='all', $sort_type, $order);
    } else {
        $page = 22;
        $students = getStudentsList($level);
   	}
}

if(isset($array['create_group']) and isset($array['new_group']) and isset($array['regnos'])){
	if($admin->createGroup($array['new_group'], $array['regnos'])){
		$message = '<span style="color:green">Successful</span>';
	}
}

if(isset($array['add_to_group']) and isset($array['group']) and isset($array['regnos'])){
	if($admin->addToGroup($array['group'], $array['regnos'])){
		$message = '<span style="color:green">Successful</span>';
	}
}
?>
<script>
    function warn() {
        var ok = confirm("Are you sure?");
        if(ok === false){
            //Cancel request
            window.stop();
        }
    }
    ;
</script>
<div>
    <h4>CONTACTS: ALL</h4>
   <div class="row">
      <div class="span4"><?= $message; ?></div>
      <div class="span5">
        <a href="index.php?p=23" class="button bg-blue bg-hover-dark fg-white place-right">MY GROUPS</a>
        <a href="index.php?p=22" class="button disabled place-right"> ALL CONTACTS </a>
      </div>
    </div>
    <div class="row">
        <?php
        if (empty($students) and !isset($array['search_button']) ) {
            echo '<p>No students in this class</p>';
        } else {

            if (isset($actionPerformed)) {
                if ($success) {
                    ?>
                    <p class="fg-NACOSS-UNN">Action successful</p>
                <?php } else { ?>
                    <p class="fg-red"><?= $error_message ?></p>
                    <?php
                }
            }
            ?>
              <form action="index.php?p=22" method="post">
                  <div class="row ntm">
                      <table class="table hovered bordered">
                          <thead>
                              <tr>
                                  <th class="text-left">SN</th>
                                  <th class="text-left">First Name</th>
                                  <th class="text-left">Last Name</th>
                                  <th class="text-left">Other Names</th>
                                  <th class="text-left">Email</th>
                                  <th class="text-left">Phone</th>
                                  <th class="text-left">&hellip;</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              for ($index = 0; $index < count($students); $index++) {
                                  if ($index != 0 && $index % 20 === 0) {
                                      echo '<tr><td></td><td colspan="6"><a href="#top">back to top</a></td></tr>';
                                  }
                                  ?>
                                  <tr>                            
                                      <td class="text-left"><?= $index + 1 ?></td>
                                      <td class="text-left"><?= $students[$index]['first_name']; ?></td>
                                      <td class="text-left"><?= $students[$index]['last_name']; ?></td>
                                      <td class="text-left"><?= $students[$index]['other_names']; ?></td>
                                      <td class="text-left"><?= strtolower($students[$index]['email']); ?></td>
                                      <td class="text-left"><?= $students[$index]['phone']; ?></td> 
                                      <td class="text-left"><input type="checkbox" name="regnos[]" value="<?= $students[$index]['regno'] ?>"/></td>
                                  </tr>
                                  <?php
                              }
                              echo '<tr><td></td><td colspan="6"><a href="#top">back to top</a></td></tr>';
                              ?>
                          </tbody>
                      </table>
                  </div>
                      <fieldset>
                          <legend>Create new group with selected contacts</legend>
                          <label class="span2">Group Name</label>
                          <input name="new_group" placeholder="Name your new group" type="text" class="span5"/>
                          <input type="submit" name="create_group" value="Create Group" class="button bg-blue bg-hover-dark fg-white place-right"/>
                      </fieldset>
                      <fieldset>
                          <legend>Add selected contacts to existing group</legend>
                          <label class="span2">Select Group</label>
                          <select name="group" class="span5">
                          <?php
						  $groups = getStudentsList_contactGroups($admin);
						  	$options = '';
						  	foreach($groups as $g){
								$options .= '<option value="'.$g['group_id'].'">'.$g['group_name'].'</option>';
							}
							echo $options;
						  ?>
                          </select>
                          <input type="submit" name="add_to_group" value="Add Contacts" class="button bg-blue bg-hover-dark fg-white place-right"/>
                      </fieldset>
              </form>
            <?php } ?>
    </div>
</div>