<?php 
require("header.php"); // Inclusion du fichier d'en-tête
session_start();

$mysqli = new mysqli("localhost", "root", "", "adb_login"); // Connexion à la base de données

if ($mysqli->connect_error) { // Vérification de la connexion à la base de données
    die("La connexion a échoué : " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Vérification de la méthode de requête HTTP
    if (isset($_POST['bModify'])) { // Si le bouton de modification est cliqué
        // Récupération des données du formulaire
        $user_id = $_POST['user_id'];
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $notes = $_POST['notes'];

        // Requête de mise à jour des informations de l'utilisateur dans la base de données
        $query = "UPDATE adds SET lastname = '$lastname', firstname = '$firstname', email = '$email', phone = '$phone', address = '$address', notes = '$notes' WHERE id = $user_id";

        if ($mysqli->query($query) === TRUE) { // Exécution de la requête de mise à jour
            echo "Les informations de l'utilisateur ont été mises à jour avec succès.";
            header("Location: listContact.php"); // Redirection vers la liste des contacts
            exit();
        } else {
            echo "Erreur lors de la mise à jour de l'utilisateur : " . $mysqli->error;
        }
    }

    if (isset($_POST['bBack'])) { // Si le bouton de retour est cliqué
        header("Location: listContact.php"); // Redirection vers la liste des contacts
        exit();
    }
    if (isset($_POST['bModify'])) { // Si le bouton de modification est cliqué
        header("Location: listContact.php"); // Redirection vers la liste des contacts
        exit();
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) { // Vérification de la présence et de la validité de l'identifiant dans l'URL
    $user_id = $_GET['id']; 

    // Requête pour récupérer les données de l'utilisateur spécifique
    $query = "SELECT * FROM adds WHERE id = $user_id";
    $result = $mysqli->query($query);

    if ($result->num_rows === 1) { // Si un seul utilisateur est retourné
        $user = $result->fetch_assoc(); // Récupération des données de l'utilisateur

        // Formulaire pour modifier les informations de l'utilisateur
?>
        <main>
            <div class="inscription-form">
                <form action="#" method="post">
                    <h2>Modify Contact</h2>
                    <!-- Champs de formulaire pré-remplis avec les données de l'utilisateur -->
                    <!-- Utilisation de PHP pour afficher les valeurs -->
                    <div class="form-group">
                        <label for="lastname">Name:</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Firstname:</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Mail:</label>
                        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number:</label>
                        <input type="phone" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="notes">notes:</label>
                        <input type="text" id="notes" name="notes" value="<?php echo $user['notes']; ?>" required>
                    </div>
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                    <button class="eC_bModi" type="submit" id="bModify" name="bModify" value="bModify">Modify</button>
                    <button class="eC_bBack" id="bBack" name="bBack" value="bBack" type="submit">Back</button>
                </form>
            </div>
        </main>
        <small>(* Required fields)</small> <!-- Champ obligatoire -->
<?php
    } else {
        echo "Aucun utilisateur trouvé avec cet identifiant."; // Si aucun utilisateur n'est trouvé avec l'identifiant donné
    }
} else {
    echo "Identifiant de l'utilisateur non fourni."; // Si aucun identifiant n'est donné dans l'URL
}

$mysqli->close(); // Fermeture de la connexion à la base de données
require_once("footer.php"); // Inclusion du fichier de pied de page
?>