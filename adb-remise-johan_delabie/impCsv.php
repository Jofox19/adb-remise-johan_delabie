<?php
session_start();

require("header.php"); // Inclusion du fichier d'en-tête

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Récupération de l'ID de l'utilisateur depuis la session
} else {
    exit('User ID not found in session.'); // Sortie si l'ID de l'utilisateur n'est pas trouvé dans la session
}
?>

<?php
$uploadMessage = ''; // Initialisation du message d'erreur pour le téléchargement du fichier

if (isset($_POST['bUpload'])) { // Vérification de la soumission du formulaire de téléchargement
    $user_id = $_SESSION['user_id']; // Récupération de l'ID de l'utilisateur depuis la session

    if (empty($_FILES['csv_file']['name'])) {
        $uploadMessage = "Please select a CSV file."; // Message si aucun fichier n'a été sélectionné
    } else {
        $user_id = $_SESSION['user_id']; // Récupération de l'ID de l'utilisateur depuis la session
        $file = $_FILES['csv_file']['tmp_name']; // Récupération du nom temporaire du fichier
        $handle = fopen($file, "r"); // Ouverture du fichier en mode lecture

        $mysqli = new mysqli('localhost', 'root', '', 'adb_login'); // Connexion à la base de données

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error; // Message en cas d'échec de connexion à la base de données
            exit();
        }

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Boucle de lecture du fichier CSV et insertion des données dans la base de données
            $lastname = $data[0]; // Récupération des données du fichier CSV
            $firstname = $data[1];
            $email = $data[2];
            $phone = $data[3];
            $address = $data[4];
            $notes = $data[5]; // Initialisation du champ de notes (Modifier cette ligne pour inclure les notes réelles du fichier CSV)

            $mysqli = mysqli_connect('localhost', 'root', '', 'adb_login'); // Nouvelle connexion à la base de données
            mysqli_query($mysqli, "INSERT INTO adds VALUES (NULL, '$lastname', '$firstname', '$email', '$phone', '$address', '$notes', $user_id)") or die(mysqli_error($mysqli)); // Requête d'insertion SQL
            $stmt = $mysqli->prepare("INSERT INTO ads (lastname, firstname, email, phone, address, notes) VALUES (?, ?, ?, ?, ?, ?)"); // Préparation d'une requête SQL

            if ($stmt) {
                $stmt->bind_param("sssssi", $lastname, $firstname, $email, $phone, $address, $notes, $user_id); // Liaison des paramètres à la requête préparée
                $stmt->execute(); // Exécution de la requête préparée

                if ($stmt->errno) {
                    echo "Failed to add user: " . $stmt->error; // Message en cas d'échec de l'ajout de l'utilisateur
                } else {
                    echo "User added successfully"; // Message de succès pour l'ajout d'utilisateur
                    header("Location: listContact.php"); // Redirection vers la page de liste de contacts
                    exit();
                }

                $stmt->close(); // Fermeture du statement
            } else {
                header("Location: listContact.php"); // Redirection vers la page de liste de contacts en cas d'erreur
            }
        }

        $mysqli->close(); // Fermeture de la connexion à la base de données
    }
}
?>

<main>
    <div class="inscription-form">
        <form action="" method="post" enctype="multipart/form-data">
            <h2>download file</h2>
            <div class="form-group">
                <label for="csv_file">Choose csv file :</label>
                <input type="file" id="csv_file" name="csv_file" accept=".csv"> <!-- Champ pour choisir le fichier CSV -->
            </div>
            <button class="eC_bModi" type="submit" id="bUpload" name="bUpload" value="bUpload">Inject</button>
            <!-- Bouton pour soumettre le formulaire de téléchargement -->
        </form>
        <form action="" method="post">
            <button class="eC_bBack" id="bBack" name="bBack" value="bBack" type="submit">Back</button>
            <!-- Bouton pour revenir en arrière -->
        </form>
    </div>
</main>

<?php
if (isset($_POST['bBack'])) {
    header("Location: listContact.php"); // Redirection vers la page de liste de contacts si le bouton "Retour" est cliqué
    exit();
}
?>
<?php require("footer.php"); // Inclusion du fichier de pied de page ?>