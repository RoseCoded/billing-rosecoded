<?php
    global $wpdb;
?>

<style>
    .tbl-tax-rates {
        border-collapse: collapse;
    }
    .tbl-tax-rates td {
        padding: 0.1em 1em;
    }
    .tbl-tax-rates td span {
        font-weight: 500;
    }
    div.container-scroll table {
        position: relative;
        border-top: 0;
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
        height: 350px;
        overflow-y: scroll;
        border-bottom: 1px solid #c1c1c1;
    }
    .fa-times-circle {
        color: #7B1425;
        font-size: 1.5em;
        cursor: pointer;
    }
    .fa-edit {
        color: #655e7a;
        font-size: 1.5em;
        cursor: pointer;
    }
    .fa-check {
        color: green;
        font-size: 1.5em;
        cursor: pointer;
        display: none;
    }
    .fa-plus {
        color: green;
        font-size: 1.5em;
        cursor: pointer;
        display: inline;
        margin-left: 0.5em;
    }
    .edit-close {
        display: none;
        color: #7B1425;
        font-size: 1.5em;
        cursor: pointer;
    }
    .btn-disabled {
        color: #D5B044;
        opacity: 0.6;
        cursor: not-allowed;
        color: gray;
    }
    .input-check-number, .input-notes {
        display: none;
        width: 100%;
    }
</style>
<script>
    jQuery(document).ready(function($) {
        $(".fa-edit").click(function() {
            var payDate = $(this).attr("data-pay-date");
            var usersID = $(this).attr("data-users-id");
            $("tr[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").children("td").children("span").hide();
            $("tr[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").children("td").children(".input-check-number, .input-notes, textarea").show();
            $(".edit-close[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").show();
            $(".fa-check[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").show();
            $(this).addClass("btn-disabled");
        });
        $(".edit-close").click(function() {
            var payDate = $(this).attr("data-pay-date");
            var usersID = $(this).attr("data-users-id");
            $("tr[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").children("td").children("span").show();
            $("tr[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").children("td").children(".input-check-number, .input-notes, textarea").hide();
            $(".fa-edit[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").removeClass("btn-disabled");
            $(".edit-close[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").hide();
            $(".fa-check[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").hide();
        });
        $(".fa-check").click(function() {
            var payDate = $(this).attr("data-pay-date");
            var usersID = $(this).attr("data-users-id");
            var checkNumber = $(".input-check-number[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").val();
            $.ajax({
                type: "POST",
                url: "admin-ajax.php",
                dataType:"json",
                data: { 
                    action: "upsert_check_notes_ajax",
                    payPeriod: payDate,
                    usersID: usersID,
                    checkNumber: checkNumber,
                    notes: $(".input-notes[data-pay-date=" + payDate + "][data-users-id=" + usersID + "]").val()
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
        });
        
        //Scroll divs to bottom
        var d = $(".container-scroll");
        d.scrollTop(d.prop("scrollHeight"));
    });
</script>

<h1 style="display: inline-block;">Time Keeping</h1>

<?php
    $tax_rates = $wpdb->get_results("
        SELECT *
        FROM wordpress.wp_rosecoded_tax_rates;
    ");

    $costs = $wpdb->get_results("
        SELECT *, hours * 40 AS cost
        FROM (SELECT time_category_id, name, SUM(hours) AS hours
            FROM wordpress.wp_rosecoded_time_entries AS te JOIN wordpress.wp_rosecoded_time_categories AS tc
                ON te.time_category_id = tc.ID
            GROUP by time_category_id) AS temp
        ORDER BY name;
    ");

    $sum_tax_rates = 0.0;
?>
<div style="display: flex; flex-direction: row;">
    <div>
        <span style="display:block;font-weight:bold;">Taxes</span>
        <table class="tbl-tax-rates">
            <?php
                foreach ( $tax_rates as $tax_rate) {
                    $sum_tax_rates += $tax_rate->amount;
                    echo '
                        <tr>
                            <td><span>' . $tax_rate->tax_name . '</span></td>
                            <td>' . $tax_rate->amount . '</td>
                        </tr>
                    ';
                }
            ?>
            <tr>
                <td style="border-top: 1px solid #000;"><span>Total Percent</span></td>
                <td style="border-top: 1px solid #000;"><?php echo $sum_tax_rates; ?></td>
            </tr>
        </table>
    </div>
    <div style="margin-left: 2em;">
        <span style="display:block;font-weight:bold;">Costs</span>
        <table class="tbl-tax-rates">
            <tr>
                <td>Name</td>
                <td>Hours</td>
                <td>Cost</td>
            </tr>
            <?php
                foreach ( $costs as $cost) {
                    echo '
                        <tr>
                            <td>' . $cost->name . '</td>
                            <td>' . $cost->hours . '</td>
                            <td>' . $cost->cost . '</td>
                        </tr>
                    ';
                }
            ?>
        </table>
    </div>
</div>
<?php
    $user = wp_get_current_user();
    $is_owner = false;
    //2 - Marco
    //4 - Rebecca
    //5 - Rory
    if ($user->ID == 2 || $user->ID == 4 || $user->ID == 5) {
        $is_owner = true;
    }
    if ($is_owner) {
        $owners = $wpdb->get_results("
            SELECT *
            FROM wordpress.wp_users
            WHERE ID IN (2, 4, 5);
        ");
        foreach ($owners as $owner) {
            echo '<h2>' . $owner->display_name . '</h2>';
            $time_entries = $wpdb->get_results("
                SELECT *
                FROM wordpress.wp_rosecoded_time_entries AS te JOIN wordpress.wp_rosecoded_time_categories AS c
                     ON te.time_category_id = c.ID
                WHERE te.users_id = " . $owner->ID . ";
            ");

            if (!$time_entries) {
                echo '<p>This user doesn\'t have time entries.</p>';
            }
            else {
                //var_dump($time_entries);
                echo '
                    <div class="container-scroll">
                        <table class="wp-list-table widefat fixed striped table-view-list" role="presentation">
                            <thead>
                                <th>Date</th>
                                <th>Hours</th>
                                <th>Rate</th>
                                <th>Gross Pay</th>
                                <th>Taxes/Savings Deposit</th>
                                <th>Net Pay</th>
                                <th>Check #</th>
                                <th>Notes</th>
                                <th style="width: 50px;"></th>
                            </thead>
                            <tbody>';

                $begin = new DateTime('2022-01-31');
                $end = new DateTime();
                //$end->modify('+14 days');
                $interval = DateInterval::createFromDateString('14 days');
                $period = new DatePeriod($begin, $interval, $end);
                //echo '<p>' . var_dump($period) . '</p>';
                //echo '<p>' . var_dump($end) . '</p>';
                //var_dump($time_entries);
                foreach ($period as $dt) {
                    $hours_sum = 0.0;
                    $check_num = "";
                    $str_notes = "";
                    $pay_period_date = $dt->format("Y-m-d");
                    foreach($time_entries as $time_entry) {
                        $begin_this_period = date('Y-m-d', strtotime($pay_period_date . ' - 14 days'));
                        //echo '<p>' . $dt->format('Y-m-d') . ' | ' . $time_entry->entry_date . '</p>';
                        //echo '<p>' . $time_entry->entry_date . ' | ' . $dt->format("Y-m-d") . '</p>';
                        if ($time_entry->entry_date <= $pay_period_date && $time_entry->entry_date > $begin_this_period) {
                            $hours_sum += $time_entry->hours;
                            $pay_period_check = $wpdb->get_row("
                                SELECT *
                                FROM wordpress.wp_rosecoded_checks
                                WHERE users_id = " . $owner->ID . " AND pay_period = '"  . $pay_period_date . "';
                            ");
                            $check_num = $pay_period_check->check_number;
                            $str_notes = $pay_period_check->notes;
                        }
                    }
                    $gross_pay = 40 * $hours_sum;
                    $taxes_pay = $gross_pay * ($sum_tax_rates / 100);
                    $net_pay = $gross_pay - $taxes_pay;
                    $fmt = numfmt_create( 'en-US', NumberFormatter::CURRENCY );
                    $symbol = $fmt->getSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL);
                    echo '
                                <tr data-pay-date="' .  $dt->format("Y-m-d") . '" data-users-id="' .  $owner->ID . '">
                                    <td>' . $dt->format("m-d-Y") . '</td>
                                    <td>' . $hours_sum . '</td>
                                    <td>$40.00</td>
                                    <td>' . $fmt->formatCurrency($gross_pay, $symbol) . '</td>
                                    <td>' . $fmt->formatCurrency($taxes_pay, $symbol) . '</td>
                                    <td>' . $fmt->formatCurrency($net_pay, $symbol) . '</td>
                                    <td>
                                        <span>' . $check_num . '</span>
                                        <textarea class="input-check-number" data-pay-date="' . $dt->format("Y-m-d") . '" data-users-id="' .  $owner->ID . '">' . $check_num . '</textarea>
                                    </td>
                                    <td>
                                        <span>' . $str_notes . '</span>
                                        <textarea class="input-notes" data-pay-date="' . $dt->format("Y-m-d") . '" data-users-id="' .  $owner->ID . '">' . $str_notes . '</textarea>
                                    </td>
                                    <td>
                                        <div>
                                            <i class="fas fa-edit" data-pay-date="' .  $dt->format("Y-m-d") . '" data-users-id="' .  $owner->ID . '"></i>
                                        </div>
                                        <div>
                                            <i class="fas fa-check" data-pay-date="' .  $dt->format("Y-m-d") . '" data-users-id="' .  $owner->ID . '"></i>
                                            <i class="fas fa-times edit-close" data-pay-date="' .  $dt->format("Y-m-d") . '" data-users-id="' .  $owner->ID . '"></i>
                                        </div>
                                    </td>
                                </tr>';
                    $hours_sum = 0.0;
                }     
                echo '
                            </tbody>
                        </table>
                    </div>
                ';
            }
        }
    }
?>