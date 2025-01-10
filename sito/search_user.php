<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('db_connect.php');

if (!empty($_POST["keyword"])) {
    $stmt = $conn->prepare("SELECT username_utente FROM utente WHERE username_utente LIKE ? LIMIT 2");
    if ($stmt) {
        $search = $_POST['keyword'] . "%";
        $stmt->bind_param("s", $search);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        ?>
            <p style="text-align:center;">Utenti suggeriti:</p>
            <?php
                foreach ($result as $username) {
            ?>
            <p style="text-align:center;"><?php echo $username["username_utente"]; ?></p>
        
    <?php
        }// end for
    ?>
    </ul>
    <?php
    } else {
            echo "<p style='text-align:center;'>Nessun risultato trovato.</p>";
        }
        $stmt->close();
    } else {
        echo "Errore nella preparazione della query.";
    }
}

$conn->close();
?> 
