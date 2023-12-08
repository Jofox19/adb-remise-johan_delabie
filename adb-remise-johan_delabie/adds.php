<?php
session_start(); // Démarrer la session

require("header.php"); // Inclure le fichier d'en-tête

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Obtenir l'identifiant de l'utilisateur depuis la session
} else {
    exit('Identifiant utilisateur non trouvé dans la session.'); // Quitter si l'identifiant utilisateur n'est pas trouvé dans la session
}
?>

<main>
    <div class="ad_fCon">
        <form action="#" method="post">
            <h2>Add contact</h2>
            <!-- Formulaire pour ajouter un contact -->
            <div class="ad_eCon">
                <label for="lastname">Name :</label>
                <input type="text" id="lastname" name="lastname" autofocus >
            </div>
            <div class="ad_eCon">
                <label for="firstname">Firstname  :</label>
                <input type="text" id="firstname" name="firstname">
            </div>
            <div class="ad_eCon">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="ad_eCon">
                <label for="phone">phone number :</label>
                <input type="phone" id="phone" name="phone">
            </div>
            <div class="ad_eCon">
                <label for="address">Address :</label>
                <input type="text" id="address" name="address">
            </div>
            <div class="ad_eCon">
                <label for="notes">Notes :</label>
                <textarea id="notes" name="notes"></textarea>
            </div>
            <!-- Champ caché pour stocker l'identifiant de l'utilisateur actuel -->
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
            <!-- Bouton pour créer le contact -->
            <button class="ad_bCrea" type="submit" id="bCreate" name="bCreate" value="bCreate">Create</button>
        </form>
        <form action="" method="post">
            <!-- Bouton pour revenir en arrière -->
            <button class="ad_bBack" id="bBack" name="bBack" value="bBack" type="submit">Back</button>
        </form>
    </div>
</main>

<?php
if (isset($_POST['bCreate'])) { // Vérifier si le bouton "Créer" est cliqué
    // Récupérer les valeurs du formulaire
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $notes = $_POST['notes']; // Récupérer les notes du formulaire
    $user_id = $_POST['user_id'];

    // Se connecter à la base de données et insérer les détails du contact
    $mysqli = mysqli_connect('localhost', 'root', '', 'adb_login');
    mysqli_query($mysqli, "INSERT INTO adds VALUES (NULL, '$lastname', '$firstname', '$email', '$phone', '$address', '$notes', $user_id)") or die(mysqli_error($mysqli));

    // Vérifier la connexion à la base de données
    if (mysqli_connect_errno()) {
        echo "Connexion perdue : " . mysqli_connect_error();
        exit();
    }

    $stmt = $mysqli->prepare("INSERT INTO ads (lastname, firstname, email, phone, address, notes) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Binder les valeurs et exécuter la requête préparée pour ajouter le contact
        $stmt->bind_param("ssssss", $lastname, $firstname, $email, $phone, $address, $notes, $user_id);
        $stmt->execute();

        if ($stmt->errno) {
            echo "adds failes: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Querry error"; // Erreur dans la préparation de la requête
    }

    $mysqli->close(); // Fermer la connexion à la base de données
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Rediriger vers la page de liste de contacts si le bouton "Retour" ou "Créer" est cliqué
    if (isset($_POST['bBack'])) {
        header("Location: listContact.php");
        exit();
    }
    if (isset($_POST['bCreate'])) {
        header("Location: listContact.php");
        exit();
    }
}
?>

<?php require("footer.php"); // Inclure le fichier de pied de page ?>