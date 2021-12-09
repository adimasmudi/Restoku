<?php
    require_once('../auth.php');
    require_once('../config.php');

    // Program to display URL of current page.
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $link = "https";
    else $link = "http";

    // Here append the common URL characters.
    $link .= "://";

    // Append the host(domain name, ip) to the URL.
    $link .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL
    $link .= $_SERVER['REQUEST_URI'];

    // Print the link
    $id_menu = explode("?",$link)[1];

    $sql = "DELETE FROM menu WHERE ID_menu=:id_menu";

    $stmt = $db->prepare($sql);

    // bind
    $params = array(
        ":id_menu" => $id_menu
    );

    $deleted = $stmt->execute($params);

    if($deleted) header("Location:index_admin.php");

    



?>