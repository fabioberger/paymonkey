<?php
$LOCAL = true;

if ($LOCAL) {
	$url = parse_url("mysql://b9c25d6971cf1d:7e5b4676@us-cdbr-east-02.cleardb.com/heroku_cd07237f8c9079f?reconnect=true");
} else {
	$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
}

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
	printf("MySQL client info: %s\n", mysql_get_client_info());
	printf("MySQL host info: %s\n", mysql_get_host_info());
	printf("MySQL server version: %s\n", mysql_get_server_info());
	printf("MySQL protocol version: %s\n", mysql_get_proto_info());
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

mysql_select_db($db);
?>