<!-- stylesheet file -->


<?php

global $wpdb, $base, $client;
$sql = "SELECT * FROM wp_passwordlessadmin";

$results = $wpdb->get_results($sql);
foreach ($results as $result) {
	$base = $result->base_url;
	$client = $result->client_id;
}
?>


<?php
if (isset($_POST['submit'])) {

	$table_name = $wpdb->prefix . 'passwordlessadmin';
	$data_update = array('base_url' =>sanitize_text_field( $_POST['baseUrl']), 'client_id' => sanitize_text_field($_POST['clientId']));
	$data_where = array('client_id' => $client);
	echo sanitize_category(($wpdb))->update($table_name, $data_update, $data_where);

	echo '<script>window.location.reload();</script>';
}

if (isset($_POST['submit2'])) {


	global $wpdb;

	// Set table name
	$table = $wpdb->prefix . 'passwordlessadmin';


	$charset_collate = $wpdb->get_charset_collate();

	// Write creating query
	$query =  "CREATE TABLE IF NOT EXISTS  " . $table . " (
            base_url varchar(255) ,
            client_id VARCHAR(255)
            );";
	// Execute the query
	echo '<script>alert("Created")</script>';

	echo $wpdb->query($query);

	$data = array('base_url' => $base, 'client_id' => $client);
	$format = array('%s', '%d');
	$wpdb->insert($table, $data, $format);
	$my_id = $wpdb->insert_id;
	echo '<script>window.location.reload();</script>';
}
?>



<form method="POST" id="check-table">
	<p>Click the following button to create required tables in database</p>
	<strong>Note:- Need To create table for first time only....</strong>
	<input type="submit" name="submit2" value="Create">

</form>


<div class="wrap">
	<h1>Passwordless Admin Auth Configuration:</h1>
	<form method="POST">
		<label>Enter Base Url :- </label> <br>
		<input type="url" id="baseUrl" name="baseUrl" placeholder="Enter Base Url" value="<?php echo $base ?>" />
		<br>
		<br>
		<label>Enter Client Id :- </label> <br>
		<input type="text" id="clientId" name="clientId" placeholder="Enter Client Id" value="<?php echo $client ?>" />
		<br>
		<br>
		<input type="submit" onclick="handleSubmit()" value="submit" name="submit">
	</form>
</div>
<br/>
<div style="width: 30%">
<strong>Please change the slug of Passwordless Sign In Page to member-login</strong>
<p><strong>Passwordless Sign In page</strong> is auto generated when plugin is activated.
Please! change the slug of Passwordless Sign In page to <strong>member-login</strong>
</p>
<p>Ex: if your site is https://example.com then the page path is https://example.com/member-login</p>
<!-- <img src="./info.png" width="150px" height="auto" alt="info"/> -->
</div>