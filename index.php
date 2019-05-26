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
        <form class="form" action="index.php" method="POST">
            <!-- textinput 0: ID -->
            <div class="form__group">
                <input type="text" placeholder="ID" class="form__input" name="ID" id="ID"/>
            </div>

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
        </form>
        <form class="form" action="index.php" method="GET">
            <input type="submit" class="btn" name="load_data" id="load_data" value="Tampilkan Data">
        </form>
    </div>

    <!-- Backend : Php code -->
    <?php
        $host = "registeruser.database.windows.net";
        $user = "aditya34";
        $pass = "A@d1ty4&A";
        $db = "registeruser";

        try {
            $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch(Exception $e) {
            echo "Failed: ".$e;
        }

        if (isset($_POST['submit'])) {
            try {
                $id = $_POST['ID'];
                $name = $_POST['Nama'];
                $email = $_POST['Email'];
                $profession = $_POST['Profesi'];
                $age = $_POST['Umur'];
                $date = Date("Y-m-d");
                // insert data
                $sql_insert = "INSERT INTO Reguser (ID, Nama, Email, Profesi, Umur, Date) VALUES (?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $id);
                $stmt->bindValue(2, $name);
                $stmt->bindValue(3, $email);
                $stmt->bindValue(4, $profession);
                $stmt->bindValue(5, $age);
                $stmt->bindValue(6, $date);
                $stmt->execute();
            } catch(Exception $e) {
                echo "Failed: ".$e;
            }
            // if success : the dialog will be appear
            echo "<h3>Data telah tersimpan</h3>";
        } else if (isset($_GET['load_data'])) {
            try {
                $sql_select = "SELECT * FROM Reguser";
                $stmt = $conn->query($sql_select);
                $registerants = $stmt->fetchAll();

                if (count($registerants) > 0) {
                    echo "<h3 style='color: white; text-align: center; text-transform: uppercase;'>User yang telah terdaftar:</h3>";
                    echo "<table class='table table-hover' style='color: white; margin: 20px auto;'><thead>";
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
                        echo "<td>".$registerant['Date']."</td></tr>";
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