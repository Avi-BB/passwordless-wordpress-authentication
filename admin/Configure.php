<!-- stylesheet file -->
<style>
	.wrap {
		background-color: white;
		width: fit-content;
		padding: 2rem;
		box-shadow: 0 0 5px #ccc;
		border-radius: 0.2rem;

	}

	.wrap-cnd {
		background-color: white;
		width: fit-content;
		padding: 0.3rem 1rem;
		box-shadow: 0 0 5px #ccc;
		border-radius: 0.2rem;
		margin-top: 1rem;
	}

	.form-container {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: flex-end;
	}

	.text-field-container {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: flex-start;
		margin: 0 0.5rem;
	}

	label {
		color: black;
		font-weight: bold;
		font-size: 0.9rem;
	}

	input {
		text-overflow: ellipsis;

	}

	#submit-btn {
		background-color: #00a0d2;
		color: white;
		border: none;
		border-radius: 0.2rem;
		padding: 0.3rem 0.7rem;
		font-size: 1rem;
		cursor: pointer;
	}
</style>

<?php

global $wpdb, $base, $client;

$sql = "SELECT * FROM wp_passwordlessadmin";
echo "<script>console.log('" . $sql . "')</script>";
$results = $wpdb->get_results($sql);
foreach ($results as $result) {
	$base = $result->base_url;
	$client = $result->client_id;
}
?>


<?php
if (isset($_POST['submit'])) {

	// Set table name
	$table = $wpdb->prefix . 'passwordlessadmin';


	$charset_collate = $wpdb->get_charset_collate();
	$query1 = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table));
	if ($wpdb->get_var($query1) !== $table) {
		// Write creating query
		$query =  "CREATE TABLE IF NOT EXISTS  " . $table . " (
            base_url varchar(255) ,
            client_id VARCHAR(255)
            );";
		// Execute the query
		echo '<script>alert("Table Created")</script>';
		echo sanitize_category($wpdb)->query($query);
		// $my_id = $wpdb->insert_id;
		echo '<script>window.location.reload();</script>';
	} else {
		$table_name = $wpdb->prefix . 'passwordlessadmin';
		$data_update = array('base_url' => sanitize_text_field($_POST['baseUrl']), 'client_id' => sanitize_text_field($_POST['clientId']));
		$data_where = array('client_id' => $client);
		$format = array('%s',  '%s');
		$success = sanitize_category($wpdb)->insert($table_name, $data_update, $format);
		if ($success) {
			echo '<script>window.location.reload();</script>';
		} else {
			echo '<script>alert("Data not saved")</script>';
		}
	}
}


?>




<div class="wrap-cnd">
	<h3>Get your passwordless credentials</h3>
	<p>Visit: <a href="https://www.passwordless.com.au" alt="passwordless" target="_blank" noreffer>passwordless.com.au</a></p>
</div>

<div class="wrap">
	<h1 style="margin-bottom: 1rem;">Passwordless Configuration:</h1>
	<form class="form-container" method="POST" autocomplete="false">
		<div class="text-field-container">
			<label>Enter Base Url </label>
			<input type="url" id="baseUrl" name="baseUrl" placeholder="Enter Base Url" value="<?php echo esc_attr($base) ?>" />

		</div>
		<div class="text-field-container">
			<label>Enter Client Id </label>
			<input type="password" id="clientId" name="clientId" placeholder="Enter Client Id" value="<?php echo esc_attr($client) ?>" />

		</div>
		<input id="submit-btn" type="submit" onclick="handleSubmit()" value="submit" name="submit">
	</form>
</div>
<!-- <div style="margin-top: 1rem;">
<h2>Intgration Guide: </h2>
	<iframe width="500" height="345" src="https://www.youtube.com/watch?v=QXbrdVjWaME">
	</iframe>

</div> -->
<!-- <div style="width: 30%">
<strong>Please change the slug of Passwordless Sign In Page to member-login</strong>
<p><strong>Passwordless Sign In page</strong> is auto generated when plugin is activated.
Please! change the slug of Passwordless Sign In page to <strong>member-login</strong>
</p>
<p>Ex: if your site is https://example.com then the page path is https://example.com/member-login</p>
<img src="./info.png" width="150px" height="auto" alt="info"/> -->