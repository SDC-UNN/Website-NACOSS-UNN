<?php
$message = '';
if (isset($array['rename']) and isset($array['group_id'])) {
    if (!empty($array['new_name'])) {
        if ($admin->renameGroup($array['group_id'], $array['new_name'])) {
            $message = '<span style="color:green">Successful</span>';
        } else {
            $message = '<span style="color:red">Oops! Something went wrong</span>';
        }
    } else {
        $message = '<span style="color:red">New name not specified</span>';
    }
}

if (isset($_GET['a'])) {
    if ($_GET['a'] == 'dg' and isset($_GET['g'])) {
        if ($admin->deleteGroup($_GET['g'])) {
            $message = '<span style="color:green">Successful</span>';
        } else {
            $message = '<span style="color:red">Oops! Something went wrong</span>';
        }
    }
}

if (isset($array['delete_m']) and isset($array['group_id'])) {
    if (!empty($array['regnos'])) {
        try {
            if ($admin->removeFromGroup($array['group_id'], $array['regnos'])) {
                $message = '<span style="color:green">Successful</span>';
            } else {
                $message = '<span style="color:red">Oops! Something went wrong</span>';
            }
        } catch (Exception $exc) {
            $message = "<span style='color:red'>{$exc->getMessage()}</span>";
        }
    } else {
        $message = '<span style="color:red">No contact selected</span>';
    }
}

$groups = getStudentsList_contactGroups($admin);
?>
<script>
    function warn() {
        var ok = confirm("Are you sure?");
        if (ok === false) {
            //Cancel request
            $("#form").submit(function () {
                return false;
            });
        }
    }
    ;
</script>
<div>
    <h4>CONTACTS: GROUPS</h4>
    <div class="row">
        <div class="span4"><?= $message; ?></div>
        <div class="span8">
            <a href="index.php?p=23" class="button disabled place-right">MY GROUPS</a>
            <a href="index.php?p=22" class="button bg-blue bg-hover-dark fg-white place-right"> ALL CONTACTS </a>
        </div>
    </div>
    <br/>
    <div class="row ntm">
        <?php
        foreach ($groups as $group) {
            ?>
            <div class="panel no-border bg-transparent" data-role="panel">
                <p class="panel-header"><?= $group['group_name']; ?></p>
                <div class="panel-content bg-grayLighter">
                    <p>
                    <form action="index.php?p=23" enctype="multipart/form-data" method="post">
                        <input name="group_id" value="<?= $group['group_id']; ?>" type="hidden"/>
                        <input name="new_name" value="<?= $group['group_name']; ?>"/>
                        <input name="rename" value="Rename" type="submit" class="button bg-blue bg-hover-dark fg-white"/>
                        [<a href="index.php?p=23&a=dg&g=<?= $group['group_id']; ?>">delete group</a>]
                    </form>
                    </p>
                    <form action="index.php?p=23" enctype="multipart/form-data" method="post" id="form">
                        <input name="group_id" value="<?= $group['group_id']; ?>" type="hidden"/>
                        <table class="table hovered bordered">
                            <thead>
                            <th class="text-left">SN</th>
                            <th class="text-left">Names</th>
                            <th class="text-left">Email</th>
                            <th class="text-left">Phone</th>
                            <th class="text-left">&hellip;</th>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 1;
                                foreach ($group['group_members'] as $member) {
                                    ?>
                                    <tr>
                                        <td class="text-left"><?= $sn; ?></td>
                                        <td class="text-left"><?= $member['first_name'] . ' ' . $member['last_name'] . ' ' . $member['other_names']; ?></td>
                                        <td class="text-left"><?= $member['email']; ?></td>
                                        <td class="text-left"><?= $member['phone']; ?></td>
                                        <td class="text-left"><input name="regnos[]" value="<?= $member['regno']; ?>" type="checkbox"/></td>
                                    </tr>
                                    <?php
                                    $sn++;
                                }
                                ?>
                                <tr>
                                    <td class="text-right" colspan="5">
                                        <input name="delete_m" value="Remove Selected" type="submit" class="button bg-blue bg-hover-dark fg-white"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>                    
            </div>
            <br/>
        <?php } ?>
    </div>
</div>