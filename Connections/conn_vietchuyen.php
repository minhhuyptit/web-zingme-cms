<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$url = "http://localhost:8888/cms/"; //Khai báo địa chỉ website
$hostname_conn_vietchuyen = "localhost";
$database_conn_vietchuyen = "cms";
$username_conn_vietchuyen = "root";
$password_conn_vietchuyen = "";
$conn_vietchuyen = mysql_pconnect($hostname_conn_vietchuyen, $username_conn_vietchuyen, $password_conn_vietchuyen) or trigger_error(mysql_error(),E_USER_ERROR); 
?>