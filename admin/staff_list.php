<?php include 'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_staff_account"><i class="fa fa-plus"></i> Add New User</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table tabe-hover table-responsive table-bordered" id="list">
                <colgroup>
                    <col width="2%">
                    <col width="20%">
                    <col width="20%">
                    <col width="10%">
                    <!-- <col width="5%"> -->
                    <col width="2%">
                </colgroup>
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Unit</th>
                        <!-- <th class="text-center">Role</th> -->
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $type = array('', "Admin", "Staff");
                    if ($_GET['page'] == 'staff_list') {
                        $qry = $conn->query("SELECT *,concat(first_name,' ',last_name) as name FROM tbl_unifast_staff WHERE type != 1 && status = 'ACTIVE' && unit != '-SELECT UNIT-' order by id");
                    } else {
                        $qry = $conn->query("SELECT *,concat(first_name,' ',last_name) as name FROM tbl_unifast_staff order by id");
                    }
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td><?php echo ucwords($row['last_name']) . ',' . ' ' . ($row['first_name']) . ' ' . substr($row['middle_name'], 0, 1) . '.'?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['unit'] ?></td>
                            <!-- <td class="text-center"><?//php echo $type[$row['type']] ?></td> -->
                            <!--- <td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action</button>
		                    <div class="dropdown-menu">
		                      <a class="dropdown-item view_user" href="javascript:void(0)" data-id="<?php // echo $row['id']?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php // echo $row['id']?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php // echo $row['id']?>">Delete</a>
		                    </div>
						</td> --->
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="./index.php?page=edit_staff_account&id=<?php echo $row['id'] ?>">
                                        <button href="button" class="btn btn-primary btn-flat">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </a>&nbsp;
                                    <button type="button" class="btn btn-danger btn-flat delete_staff_user" data-id="<?php echo $row['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#list').dataTable()
        $('.view_user').click(function() {
            uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id=" + $(this).attr('data-id'))
        })
        $('.delete_staff_user').click(function() {
            _conf("Are you sure to delete this user?", "delete_staff_user", [$(this).attr('data-id')])
        })
    })

    function delete_staff_user($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_staff_user',
            method: 'POST',
            data: {
                id: $id
            },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1500)

                }
            }
        })
    }
</script>