<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

print_r($url);

$link = mysql_connect($server, $username, $password);

if (!$link) {
	echo "<p>Could not connect to the server '" . $server . "'</p>\n";
	echo mysql_error();
} else {
	echo "<p>Successfully connected to the server '" . $server . "'</p>\n";
	printf("<p>MySQL client info: %s</p>\n", mysql_get_client_info());
	printf("<p>MySQL host info: %s</p>\n", mysql_get_host_info());
	printf("<p>MySQL server version: %s</p>\n", mysql_get_server_info());
	printf("<p>MySQL protocol version: %s</p>\n", mysql_get_proto_info());
}

if ($link && !$db) {
	echo "<p>No database name was given. Available databases:</p>\n";
	$db_list = mysql_list_dbs($link);
	echo "<pre>\n";
	while ($row = mysql_fetch_array($db_list)) {
	     echo $row['Database'] . "\n";
	}
	echo "</pre>\n";
}

if ($db) {
	$dbcheck = mysql_select_db($db);
	if (!$dbcheck) {
		echo mysql_error();
	} else {
		echo "<p>Successfully connected to the database '" . $db . "'</p>\n";
		$sql = "SHOW TABLES FROM `$database`";
		$result = mysql_query($sql);
		if (mysql_num_rows($result) > 0) {
			echo "<p>Available tables:</p>\n";
			echo "<pre>\n";
			while ($row = mysql_fetch_row($result)) {
				echo "{$row[0]}\n";
			}
			echo "</pre>\n";
		} else {
			echo "<p>The database '" . $db . "' contains no tables.</p>\n";
			echo mysql_error();
		}
	}
}

$CREATETABLES = false;

if ($CREATETABLES) {

}
?>