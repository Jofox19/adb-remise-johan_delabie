<?php require("header.php"); // Inclusion du fichier d'en-tête ?>

<main>
  <div class="inscription-form">
    <form action="" method="post"> 
      <h2>Reset Password</h2>
      <!-- Formulaire pour réinitialiser le mot de passe -->
      <div class="form-group">
        <label for="username">username :</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="SecretResponse">Answer to the secret question :</label>
        <input type="text" id="SecretResponse" name="SecretResponse" required>
      </div>
      <div class="form-group">
        <label for="newPassword">New Password :</label>
        <input type="password" id="newPassword" name="newPassword" required>
      </div>
      <button type="submit" id="resetPassword" name="resetPassword" value="resetPassword" class="eC_bModi">Reset Password</button>
    </form>
    <form action="index.php" method="post">
      <button class="eC_bBack" id="bBack" name="bBack" value="bBack" type="submit">back</button>
    </form>
  </div>
</main>

<?php
// Section de code responsable du processus de réinitialisation du mot de passe
if (isset($_POST['resetPassword'])) {
    $username = $_POST['username'];
    $SR = $_POST['SecretResponse'];
    $newPassword = $_POST['newPassword'];
    
    // Connexion à la base de données
    $mysqli = new mysqli("localhost", "root", "", "adb_login");

    if ($mysqli->connect_error) {
        die("La connexion a échoué : " . $mysqli->connect_error);
    }

    // Préparation et exécution de la requête SQL pour récupérer la réponse secrète associée à l'utilisateur
    $stmt = $mysqli->prepare("SELECT SecretResponse FROM users WHERE username = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($storedResponse);
            $stmt->fetch();
            
            if ($SR === $storedResponse) { // Vérification de la réponse secrète
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $mysqli->prepare("UPDATE users SET password = ? WHERE username = ?");
                
                if ($updateStmt) {
                    $updateStmt->bind_param("ss", $hashed_password, $username);
                    $updateStmt->execute();

                    $updateStmt->close();
                }
            }
        }

        $stmt->close();
        $mysqli->close();
    }
}
?>

<?php
// Redirection vers la page d'accueil après la réinitialisation du mot de passe
if (isset($_POST['resetPassword'])) {
    header("Location: index.php");
    exit();
}
// Redirection vers la page d'accueil si le bouton de retour est cliqué
if (isset($_POST['bBack'])) {
  header("Location: index.php");
  exit();
}
?>

<?php require("footer.php"); // Inclusion du fichier de pied de page ?>