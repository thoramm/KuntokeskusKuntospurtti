<?php
session_start();

// Lomakkeen käsittely
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $aihe = $_POST['aihe'];
  $nimi = $_POST['nimi'];
  $sposti = $_POST['sposti'];
  $puhelin = $_POST['puhelin'];
  $viesti = $_POST['viesti'];

  // Vahvistusviestin lähettäminen asiakkaalle
  $to = $sposti;
  $otsikko = "Vahvistus: $aihe lähetetty";
  $vahvistusviesti = "Hei $nimi,\n\n"
        . "Kiitos yhteydenotostasi. Tässä ovat lähettämäsi tiedot:\n\n"
        . "Aihe: $aihe\n"
        . "Nimi: $nimi\n"
        . "Sähköposti: $sposti\n"
        . "Puhelin: $puhelin\n"
        . "Viesti: $viesti\n\n"
        . "Olemme sinuun yhteydessä mahdollisimman pian.\n\n"
        . "Ystävällisin terveisin,\n"
        . "Kuntokeskus Kuntospurtti";

  $headers = "X-Mailer: PHP/" . phpversion();

  if (mail($to, $otsikko, $vahvistusviesti, $headers)) {
      $_SESSION['vahvistus'] = "Kiitos yhteydenotosta! Vahvistusviesti on lähetetty sähköpostiisi.";
  } else {
      $_SESSION['vahvistus'] = "Lähetys epäonnistui. Yritä uudelleen.";
  }

  // Yhteydenottoilmoitus Kuntospurtille
  $to2 = 'kuntokeskus.kuntospurtti@meiliboxi.fi';
  $otsikko2 = "$aihe lomakkeelta";
  $vahvistusviesti2 = "$aihe lomakkeelta:\n\n"
        . "Aihe: $aihe\n"
        . "Nimi: $nimi\n"
        . "S-posti: $sposti\n"
        . "Puhelin: $puhelin\n"
        . "Viesti: $viesti\n\n";

  mail($to2, $otsikko2, $vahvistusviesti2, $headers);

  // Uudelleenohjaus lomakesivulle
  header("Location: yhteydenotto.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yhteydenotto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="header">
    <img src="salilogo.png" alt="Kuntokeskus Kuntospurtti logo" class="logo-left">
    <h1>Kuntokeskus Kuntospurtti</h1>
    <img src="salilogo.png" alt="Kuntokeskus Kuntospurtti logo" class="logo-right">
</div>

<div class="nav">
    <a href="index.php">Etusivu</a>
    <div class="dropdown">
        <button class="dropbtn">Palvelut</button>
        <div class="dropdown-content">
            <a href="kuntosalitoiminta.html">Kuntosalitoiminta</a>
            <a href="ohjatut-treenit.html">Ohjatut liikuntatreenit</a>
            <a href="personaltraining.html">Personaltraining</a>
            <a href="hieronta.html">Hieronta</a>
        </div>
    </div>
    <a href="yhteydenotto.php">Yhteydenotto</a>
</div>

<div class="yhteydenottolomake">
    <p>Jos sinulla heräsi kysyttävää, niin ota rohkeasti yhteyttä! Yhteystietomme löytyvät sivun alaosasta tai voit käyttää tätä yhteydenottolomaketta. Vastaamme mielellämme mieltäsi askarruttaviin kysymyksiin!</p>
    <h2>Yhteydenottolomake</h2>
    
    <form action="yhteydenotto.php" method="post" class="contact-form">
        <label for="aihe">Aihe:</label>
        <select id="aihe" name="aihe" required>
            <option value="Yhteydenotto">Yhteydenotto</option>
            <option value="Palaute">Palaute</option>
            <option value="Muu viesti">Muu viesti</option>
        </select>
        <br><br>
        <label for="nimi">Nimi:</label>
        <input type="text" id="nimi" name="nimi" required>
        <br><br>
        <label for="sposti">Sähköposti:</label>
        <input type="email" id="sposti" name="sposti" required>
        <br><br>
        <label for="puhelin">Puhelin:</label>
        <input type="tel" id="puhelin" name="puhelin">
        <br><br>
        <label for="viesti">Viesti:</label>
        <textarea id="viesti" name="viesti" rows="10" required></textarea>
        <br><br>
        <button type="submit">Lähetä</button><br><br><hr>
    </form>

    <?php
    // Sähköpostivahvistusviestin lähetyksen onnistumis- tai epäonnistumisviesti näkyy näytöllä
    if (isset($_SESSION['vahvistus'])) {
        echo '<div class="vahvistus">' . $_SESSION['vahvistus'] . '</div>';
        unset($_SESSION['vahvistus']); // Sivun päivitys poistaa viestin näytöltä
    }
    ?>
</div>

<div class="contact-info">
    <h3>Yhteystiedot</h3>
    <p>Kuntokeskus Kuntospurtti<br>
    Kuntotie 3<br>
    01800 Klaukkala</p>
    <p>Puhelin: 040 123 4567<br>
    Sähköposti: kuntokeskus.kuntospurtti@meiliboxi.fi</p>
    <p><a href="https://www.google.com/maps/place/Kuntotie+3,+01800+Klaukkala" target="_blank">Katso kartalta</a></p>
    <br><br>
</div>

<div class="footer">
    <p>&copy; 2024 Kurpitsa Solutions</p>
</div>

</body>
</html>
