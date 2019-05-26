<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <title>Registeration Form</title>
</head>
<body>
    <div class="user">
        <h3>Form Registerasi User</h3>
        <form class="form">
            <!-- textinput 1: Nama -->
            <div class="form__group">
                <input type="text" placeholder="Nama" class="form__input" name="Nama" id="nama"/>
            </div>
            <!-- textinput 2: Email -->
            <div class="form__group">
                <input type="email" placeholder="Email" class="form__input" name="Email" id="email"/>
            </div>
            <!-- textinput 3: Profesi -->
            <div class="form__group">
                <input type="text" placeholder="Profesi" class="form__input" name="Profesi" id="profesi"/>
            </div>
            <!-- textinput 4: Umur -->
            <div class="form__group">
                <input type="text" placeholder="Umur" class="form__input" name="Umur" id="umur"/>
            </div>
            <!-- the button -->
            <input type="submit" class="btn" name="submit" id="submit" value="Register">
            <input type="submit" class="btn" name="load_data" id="load_data" value="Tampilkan Data">
        </form>
    </div>

    <!-- Backend : Php code -->
    <?php
        $host = "registeration.database.windows.net";
        $user = "aditya340";
        $pass = "A@d1ty4&A";
        $db = "Registeration";

        try {
            $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch(Exception $e) {
            echo "Failed: ".$e;
        }

        if (isset($_POST['submit'])) {
            try {
                $name = $_POST['Nama'];
                $email = $_POST['Email'];
                $profession = $_POST['Profesi'];
                $age = $_POST['Umur'];
                $date = date("Y-m-d");
                // insert data
                $sql_insert = "INSERT INTO Registeration (Nama, Email, Profesi, Umur, date) VALUES (?,?,?,?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $name);
                $stmt->bindValue(2, $email);
                $stmt->bindValue(3, $profession);
                $stmt->bindValue(4, $age);
                $stmt->bindValue(5, $date);
                $stmt->execute();
            } catch(Exception $e) {
                echo "Failed: ".$e;
            }
            // if success : the dialog will be appear
            echo "<h3>Data telah tersimpan</h3>";
        } else if (isset($_GET['load_data'])) {
            try {
                $sql_select = "SELECT * FROM Registeration";
                $stmt = $conn->query($sql_select);
                $registerants = $stmt->fetchAll();

                if (count($registerants) > 0) {
                    echo "<h2 style='color: white; text-align: center; text-transform: uppercase;'>User yang telah terdaftar:</h2>";
                    echo "<table class='table table-hover'><thead>";
                    echo "<tr><th>Nama</th>";
                    echo "<th>Email</th>";
                    echo "<th>Profesi</th>";
                    echo "<th>Umur</th>";
                    echo "<th>Date</th></tr></thead><tbody>";
                    foreach($registerants as $registerant) {
                        echo "<tr><td>".$registerant['Nama']."</td>";
                        echo "<td>".$registerant['Email']."</td>";
                        echo "<td>".$registerant['Profesi']."</td>";
                        echo "<td>".$registerant['Umur']."</td>";
                        echo "<td>".$registerant['date']."</td></tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<h3>Tidak ada user yang terdaftar</h3>";
                }
            } catch(Exception $e) {
                echo "Failed: ".$e;
            }
        }
    ?>
    <!-- end of backend -->
</body>
</html>