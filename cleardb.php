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
		$sql = "SHOW TABLES FROM `$db`";
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

/*
	$query = 'CREATE TABLE `users` (
	  `userid` int(14) NOT NULL AUTO_INCREMENT,
	  `name` varchar(100) NOT NULL,
	  `email` varchar(100) NOT NULL,
	  `password` varchar(150) NOT NULL,
	  `username` varchar(100) NOT NULL,
	  `avatar` varchar(150) NOT NULL,
	  PRIMARY KEY (`userid`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;';

	$result = mysql_query($query);
	if (!$result) {
		echo mysql_error() . "\n";
	}

	$query = 'CREATE TABLE `fbconnect_users` (
	  `id` int(14) NOT NULL AUTO_INCREMENT,
	  `userid` int(14) NOT NULL,
	  `connectid` int(50) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;';

	$result = mysql_query($query);
	if (!$result) {
		echo mysql_error() . "\n";
	}

	*/

	$query = 'CREATE TABLE `groups` (
	  `groupid` int(14) NOT NULL AUTO_INCREMENT,
	  `lead_userid` int(14) NOT NULL,
	  `total_amt` int(10) NOT NULL,
	  `num_payers` int(2) NOT NULL DEFAULT 0,
	  PRIMARY KEY (`groupid`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';

	$result = mysql_query($query);
	if (!$result) {
		echo mysql_error() . "\n";
	}

	$query = 'CREATE TABLE `payments` (
  `paymentid` int(14) NOT NULL AUTO_INCREMENT,
  `userid` int(14) NOT NULL,
  `groupid` int(14) NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `paid_date` datetime NOT NULL,
  `pay_amt` int(10) NOT NULL,
  PRIMARY KEY (`paymentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;';

	$result = mysql_query($query);
	if (!$result) {
		echo mysql_error() . "\n";
	}

}

/*
$query = "ALTER TABLE users ADD fbid int(50);";

$result = mysql_query($query);
if (!$result) {
	echo mysql_error() . "\n";
}
*/

$query = "ALTER TABLE groups ADD paypal_email varchar(150), ADD date date;";

$result = mysql_query($query);
if (!$result) {
	echo mysql_error() . "\n";
}


?>