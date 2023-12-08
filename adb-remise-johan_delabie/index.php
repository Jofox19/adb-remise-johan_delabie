<?php 
require("header.php"); // Inclusion du fichier d'en-tête

$errors = array(); // Initialisation d'un tableau pour stocker les éventuelles erreurs

session_start(); // Démarrage de la session

// Redirection vers la liste des contacts si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: listContact.php");
    exit();
}

// Vérification des données de connexion lorsque le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bConnect'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $mysqli = new mysqli("localhost", "root", "", "adb_login"); // Connexion à la base de données

    if ($mysqli->connect_error) {
        die("Connexion failed : " . $mysqli->connect_error);
    }

    // Requête pour récupérer les données de l'utilisateur en fonction du nom d'utilisateur
    $stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Vérification de l'utilisateur et du mot de passe
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; // Enregistrement de l'ID de l'utilisateur en session
            $_SESSION['user_username'] = $user['username']; // Enregistrement du nom d'utilisateur en session
            header("Location: index.php"); // Redirection vers la page principale après la connexion
            exit();
        } else {
            $errors[] = "Wrong Password."; // Enregistrement d'une erreur si le mot de passe est incorrect
        }
    } else {
        $errors[] = "User not found."; // Enregistrement d'une erreur si l'utilisateur n'est pas trouvé
    }

    $stmt->close(); // Fermeture de la requête préparée
    $mysqli->close(); // Fermeture de la connexion à la base de données
}

?>

<main>
    <div class="login-table">
        <h2>Login</h2>

        <!-- Formulaire de connexion -->
        <form action="index.php" method="POST" id="loginForm">
            <label for="username">username <small>*</small></label>
            <input type="text" id="username" name="username" autofocus >

            <label for="password">password <small>*</small></label>
            <input type="password" id="password" name="password">
            <br>
            <!-- Boutons pour la connexion, inscription et mot de passe oublié -->
            <button type="submit" id="bConnect" name="bConnect" value="bConnect" class="eC_bModi">Connect</button>
            <button class="eC_bBack" id="bSign" name="bSign" value="bSign">Sign up</button> 
            <button class="forgot-password" id="bPF" name="bPF" value="bPF">Forget Password</button>
        </form>

        <?php
        // Affichage des erreurs éventuelles
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
        }
        ?>

    </div>
</main>

<?php
// Redirection vers les pages appropriées selon les boutons soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['bSign'])) {
        header("Location: signin.php"); // Redirection vers la page d'inscription
        exit();
    }
    if (isset($_POST['bPF'])) {
        header("Location: forgetpass.php"); // Redirection vers la page de mot de passe oublié
        exit();
    }
}

require("footer.php"); // Inclusion du fichier de pied de page
?>