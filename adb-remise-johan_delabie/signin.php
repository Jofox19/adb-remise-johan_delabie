<?php require("header.php"); ?> <!-- Inclusion du fichier d'en-tête -->

<main>
  <div class="inscription-form">
    <form action="" method="post"> <!-- Formulaire d'inscription -->
      <h2>Inscription</h2>
      <div class="form-group">
        <label for="lastname">Name:</label>
        <input type="text" id="lastname" name="lastname" required>
      </div>
      <div class="form-group">
          <label for="firstname">Firstname:</label>
          <input type="text" id="firstname" name="firstname" required>
        </div>
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="SecretQuestion">Secret question:</label>
          <select id="SecretQuestion" name="SecretQuestion" required>
            <option value="">choose your question</option>
            <option>What is your favorite movie ?</option>
            <option>What was your first car?</option>
            <option>What is the name of your first pet ?</option>
            <option>What is your mother's maiden name ?</option>
            <option>What is your favorite color ?</option>
          </select>
        </div>
        <div class="form-group">
          <label for="SecretResponse">Secret Response:</label>
          <input type="text" id="SecretResponse" name="SecretResponse" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
      <button type="submit" id="bConnect" name="bConnect" value="bConnect" class="eC_bModi">Sign in</button>
    </form>
    <!-- Formulaire pour le bouton de retour -->
    <form action="" method="post">
      <button class="eC_bBack" id="bBack" name="bBack" value="bBack" type="submit">Back</button>
    </form>
  </div>
</main>

<?php
if (isset($_POST['bConnect'])) { // Vérification si le bouton d'inscription est soumis
    // Récupération des données du formulaire
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $SQ = $_POST['SecretQuestion'];
    $SR = $_POST['SecretResponse'];
    $password = $_POST['password'];
    
    // Connexion à la base de données
    $mysqli = new mysqli("localhost", "root", "", "adb_login");

    // Vérification de la connexion à la base de données
    if ($mysqli->connect_error) {
        die("La connexion a échoué : " . $mysqli->connect_error);
    }

    // Vérification si un utilisateur avec le même nom et prénom existe déjà
    $checkQuery = "SELECT * FROM users WHERE lastname = ? AND firstname = ?";
    $checkStmt = $mysqli->prepare($checkQuery);
    
    if ($checkStmt) {
        $checkStmt->bind_param("ss", $lastname, $firstname);
        $checkStmt->execute();
        $checkStmt->store_result();
        
        if ($checkStmt->num_rows > 0) {
            header("Location: index.php");
            $checkStmt->close();
            $mysqli->close();
            exit(); 
        }
        
        $checkStmt->close();
    } else {
        $mysqli->close();
        exit();
    }

    // Préparation et exécution de la requête d'insertion
    $stmt = $mysqli->prepare("INSERT INTO users (lastname, firstname, username, email, SecretQuestion, SecretResponse, password) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Liaison des paramètres et exécution de la requête préparée
        $stmt->bind_param("sssssss", $lastname, $firstname, $username, $email, $SQ, $SR, $hashed_password);
        $stmt->execute();

        // Vérification des erreurs lors de l'exécution de la requête
        if ($stmt->errno) {
            $stmt->error;
        }

        $stmt->close(); // Fermeture de la requête
    } 
    $mysqli->close(); // Fermeture de la connexion à la base de données
}
?>

<?php
// Redirection vers index.php si le bouton de retour est soumis
if (isset($_POST['bBack'])) {
  header("Location: index.php");
  exit();
}

// Redirection vers index.php si le bouton d'inscription est soumis
if (isset($_POST['bConnect'])) {
  header("Location: index.php");
  exit();
}
?>

<?php require("footer.php"); // Inclusion du fichier de pied de page ?>