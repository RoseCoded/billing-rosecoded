<?php
    global $wpdb;
    $user = wp_get_current_user();

    if(isset($_POST['btn-add-category']))
    {
        $wpdb->insert(
            'wp_rosecoded_time_categories',
            array(
                'name' => $_POST['add-category']
            )
        );

        $time_categories = $wpdb->get_results("
            SELECT *
            FROM wordpress.wp_rosecoded_time_categories
            ORDER BY name;
        ");
    }
?>

<style>
    
</style>
<script>
    jQuery(document).ready(function($) {
        
    });
</script>

<h1>Time Categories</h1>

<form method="post">
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="add-category">Category</label>
                </th>
                <td>
                    <input name="add-category" type="text" class="input-category">
                </td>
            </tr>
        </tbody>
    </table>
    <input type="submit" id="submit" class="button button-primary" name="btn-add-category" value="Add">
</form>
<br />
<hr />
<br />

<?php
    $time_categories = $wpdb->get_results("
        SELECT *
        FROM wordpress.wp_rosecoded_time_categories
        ORDER BY name;
    ");

    echo '
        <table class="wp-list-table widefat fixed striped table-view-list" role="presentation">
            <thead>
                <th>ID</th>
                <th>Category</th>
            </thead>
            <tbody>';

    foreach($time_categories as $time_category) {
        echo '
                <tr>
                    <td>' . $time_category->ID . '</td>
                    <td>' . $time_category->name . '</td>
                </tr>';
    }
    
    echo '
            </tbody>
        </table>';
?>