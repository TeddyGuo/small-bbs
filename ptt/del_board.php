<?php
    include(".././util/./constant.php");
    include(".././util/./connect.php");
    include(".././util/./general.php");

    if (!($_SESSION['default_permission']) >= MODERATOR)
    {
        exit("Not enough permission.");
    }
    else if ($_SESSION['user_id'] != $_GET['board_id'])
    {
        echo <<< EOT
        <script language="javascript">
            alert("message successfully sent");
        </script>
EOT;
        header("Location: $last_page");
    }

    $board_id = $_GET['board_id'];
    $board_id = addslashes($board_id);

    $query = "SELECT post_id FROM post WHERE board_id = '$board_id'";
    $result = $con->query($query) or die($query . '<br/>' . $con->error);
    
    while ($row = $result->fetch_array(MYSQLI_BOTH))
    {
        $post_id = $row['post_id'];
        $query = "DELETE FROM post_reply WHERE post_id = '$post_id'";
        $con->query($query) or die($query . '<br/>' . $con->error);
    }

    $query = "DELETE FROM post WHERE board_id = '$board_id'";
    $con->query($query) or die($query . '<br/>' . $con->error);

    $query = "DELETE FROM board WHERE board_id = '$board_id'";
    $con->query($query) or die($query . '<br/>' . $con->error);

    $last_page = $_SERVER["HTTP_REFERER"];
    header("Location: $last_page");
?>