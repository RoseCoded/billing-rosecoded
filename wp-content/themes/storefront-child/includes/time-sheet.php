<?php
    global $wpdb;
    $user = wp_get_current_user();

    if(isset($_POST['btn-add-time']))
    {
        $wpdb->insert(
            'wp_rosecoded_time_entries',
            array(
                'entry_date' => $_POST['add-date'],
                'time_category_id' => $_POST['add-category'],
                'hours' => $_POST['add-hours'],
                'users_id' => $user->ID
            )
        );
    }
?>

<style>
    div.container-scroll table {
        position: relative;
        border-top: 0;
    }
    .wp-list-table th {
        font-weight: 500;
    }
    div.container-scroll table thead tr th {
        position: sticky;
        top: 0;
        background: white;
        font-weight: 500;
        border-top: 1px solid #c1c1c1;
    }
    .container-scroll {
        display: flex;
        flex-wrap: wrap;
        height: 400px;
        overflow-y: scroll;
        border-bottom: 1px solid #c1c1c1;
    }
    .input-hours {
        width: 118px;
    }
    .fa-times-circle {
        color: #7B1425;
        font-size: 1.5em;
        cursor: pointer;
    }
</style>
<script>
    jQuery(document).ready(function($) {
        var d = $(".container-scroll");
        d.scrollTop(d.prop("scrollHeight"));

        $(".btn-time-entry").click(function() {
            if (confirm("Are you sure you want to delete this entry?")) {
                $.ajax({
                    type: "POST",
                    url: "admin-ajax.php",
                    dataType:"json",
                    data: { 
                        action: "delete_time_entry_ajax",
                        timeEntryID: $(this).attr("data-time-entry-id")
                    },
                    success: function(result){
                        location.reload();
                    },
                    error: function(error) {
                        if (error.responseText == "success") {
                            //location.reload();
                        }
                    }
                });
            }
        });
    });
</script>

<h1>Time Sheet</h1>

<form method="post">
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="add-date">Date</label>
                </th>
                <td>
                    <input id="add-date" type="date" name="add-date" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="add-category">Category</label>
                </th>
                <td>
                    <select name="add-category">
                        <option>-- Select --</option>
                        <?php
                            $time_categories = $wpdb->get_results("
                                SELECT *
                                FROM wordpress.wp_rosecoded_time_categories;
                            ");
                            foreach($time_categories as $time_category) {
                                echo '<option value="' . $time_category->ID . '">' . $time_category->name . '</option>';
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="add-hours">Hours</label>
                </th>
                <td>
                    <input name="add-hours" type="number" step="0.25" value="0.00" class="input-hours">
                </td>
            </tr>
        </tbody>
    </table>
    <input type="submit" id="submit" class="button button-primary" name="btn-add-time" value="Add">
</form>
<br />
<hr />
<br />

<?php
    $time_entries = $wpdb->get_results("
        SELECT te.*, tc.name
        FROM wordpress.wp_rosecoded_time_entries AS te JOIN wordpress.wp_rosecoded_time_categories AS tc
            ON te.time_category_id = tc.ID
        WHERE te.users_id = " . $user->ID . "
        ORDER BY entry_date;
    ");

    if (!$time_entries) {
        echo '<p>You don\'t have any time entries.</p>';
    }
    else {
        echo '
            <div class="container-scroll">
                <table class="wp-list-table widefat fixed striped table-view-list" role="presentation">
                    <thead>
                        <th>Date</th>
                        <th>Hours</th>
                        <th>Category</th>
                        <th style="width:60px;">Delete</th>
                    </thead>
                    <tbody>';

        foreach($time_entries as $time_entry) {
            $entry_date = new DateTime($time_entry->entry_date);
            echo '
                        <tr>
                            <td>' . $entry_date->format("m-d-Y") . '</td>
                            <td>' . $time_entry->hours . '</td>
                            <td>' . $time_entry->name . '</td>
                            <td><i class="fas fa-times-circle btn-time-entry" data-time-entry-id="' . $time_entry->ID . '"></i></td>
                        </tr>
            ';
        }
        
        echo '
                    </tbody>
                </table>
            </div>';
    }
?>