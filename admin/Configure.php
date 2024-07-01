<!-- stylesheet file -->
<style>
	.wrap {
		background-color: white;
		width: 40%;
		padding: 1rem;
		box-shadow: 0 0 5px #ccc;
		border-radius: 0.2rem;

	}

	.wrap-cnd {
		background-color: white;
		width: 40%;
		padding: 1rem;
		box-shadow: 0 0 5px #ccc;
		border-radius: 0.2rem;
		margin-top: 1rem;
		width: 40%;
	}

	.form-container {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: flex-end;
		width: 100%;
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

	.submit-btn {
		background-color: #00a0d2;
		color: white;
		border: none;
		border-radius: 0.2rem;
		padding: 0.3rem 0.7rem;
		font-size: 1rem;
		cursor: pointer;
	}
@media screen and (max-width: 600px) {
	.wrap {
		width: 90%;
	}
	.wrap-cnd {
		width: 90%;
	}
	.form-container{
		flex-direction: column;
		align-items: center;
		justify-content: space-between;
	}
	.text-field-container{
		margin: 0.5rem;
	}
	h3{
		text-align: center !important;
		margin: 0 auto;

	}
}
</style>

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
<div class="wrap">
	<h3 id="pwl-plugin-title" style="margin-bottom: 1rem; font-weight:bold; text-align:justify;">Passwordless Configuration:</h3>
	<form class="form-container" method="POST" autocomplete="false">
		<div class="text-field-container">
			<label>Enter Base Url </label>
			<input type="url" style="width: 12rem;" id="baseUrl" name="baseUrl" placeholder="Enter Base Url" value="<?php echo esc_attr($base) ?>" />

		</div>
		<div class="text-field-container">
			<label>Enter Client Id </label>
			<input type="text" style="width: 12rem;" id="clientId" name="clientId" placeholder="Enter Client Id" value="<?php echo esc_attr($client) ?>" />
		</div>
		<input class="submit-btn" type="submit" onclick="handleSubmit()" value="submit" name="submit">
	</form>
</div>

<div class="wrap-cnd">
	<h3>Get your Passwordless credentials</h3>
	<p>Visit: <a href="https://app.passwordless4u.com" alt="passwordless" target="_blank" noreferrer>app.passwordless4u.com</a></p>
</div>

<div class="wrap-cnd">
	<h3 style="margin-bottom: 0; padding-bottom:0;">Documentation</h3>
	<p>Detail Integration of Passwordless's WordPress account authentication plugin</p>
	<p>Visit: <a href="https://docs.passwordless4u.com/getting-started/wordpress" alt="passwordless" target="_blank" noreferrer>docs.passwordless4u.com</a></p>
</div>
