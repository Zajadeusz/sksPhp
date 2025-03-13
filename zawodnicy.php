<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>zawodnicy</title>
</head>
<body>
    <?php
    $connection = mysqli_connect('localhost','root','','sks');
 
    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }
    echo "Connected successfully";
 
 
     
 
    // if(mysqli_query($connection,$test)){
    //     echo "Nowy rekord";
    // }else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    // }
 
    if(isset($_POST["button"]) && isset($_POST['imie'])){
        $imie=$_POST["imie"];
        $nazwisko=$_POST["nazwisko"];
        $klasa=$_POST["klasa"];
        $date=$_POST["rokurodzenia"];
        $wzrost=$_POST["wzrost"];
        echo $imie . "<br>";
       
        $polecenie="INSERT INTO zawodnicy (imie, nazwisko, klasa, rokurodzenia, wzrost)
        VALUES ('$imie','$nazwisko',$klasa,$date,$wzrost)";
        if(mysqli_query($connection,$polecenie)){
                echo "Nowy rekord";
                header('Location: zawodnicy.php');
                exit;
            }else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connection);
            }  
           
    }
 
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $sql = "SELECT * FROM zawodnicy WHERE id = $id";
        $result = mysqli_query($connection, $sql);
        $zawodnik = mysqli_fetch_assoc($result);
    }
 
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $imie = $_POST['imie'];
        $nazwisko = $_POST['nazwisko'];
        $klasa = $_POST['klasa'];
        $rokurodzenia = $_POST['rokurodzenia'];
        $wzrost = $_POST['wzrost'];
 
        $sql = "UPDATE zawodnicy SET imie='$imie', nazwisko='$nazwisko', klasa=$klasa, rokurodzenia=$rokurodzenia, wzrost=$wzrost WHERE id=$id";
       
        if(mysqli_query($connection, $sql)){
            echo "Rekord zaktualizowany";
            header('Location: zawodnicy.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
   
    if (isset($_POST["delete"]) && isset($_POST['zawodnik_id'])) {
        $ids = implode(",", $_POST['zawodnik_id']);
        $del_polceenie = "DELETE FROM zawodnicy WHERE id IN ($ids)";
       
        if (mysqli_query($connection, $del_polceenie)) {
            echo "Usunięto zaznaczone rekordy";
            header('Location: zawodnicy.php');
            exit;
        } else {
            echo "Error: " . $del_polceenie . "<br>" . mysqli_error($connection);
        }
    }
    ?>
 
 
 
   
 
    <h4>Dodaj zawodnika</h4>
    <form  method="POST" action="zawodnicy.php">
   
    Imię: <input type="text" name="imie"><br>
    Nazwisko: <input type="text" name="nazwisko"><br>
    Klasa: <input type="number" name="klasa"><br>
    RokUrodzenia:<input type="number" name="rokurodzenia"><br>
    Wzrost: <input type="number" name="wzrost">
    <input type="submit" value="zapisz" name="button">
   
    </form>
 
    <?php if (isset($_GET['edit'])) { ?>
        <h4>Edytuj zawodnika</h4>
        <form method="POST" action="zawodnicy.php">
            <input type="hidden" name="id" value="<?= $zawodnik['id'] ?>">
            Imię: <input type="text" name="imie" value="<?= $zawodnik['imie'] ?>"><br>
            Nazwisko: <input type="text" name="nazwisko" value="<?= $zawodnik['nazwisko'] ?>"><br>
            Klasa: <input type="number" name="klasa" value="<?= $zawodnik['klasa'] ?>"><br>
            Rok Urodzenia: <input type="number" name="rokurodzenia" value="<?= $zawodnik['rokurodzenia'] ?>"><br>
            Wzrost: <input type="number" name="wzrost" value="<?= $zawodnik['wzrost'] ?>"><br>
            <input type="submit" name="update" value="Aktualizuj">
        </form>
    <?php } ?>
 
   
 
  <form method="POST" action="zawodnicy.php">
        <h4>Lista zawodników</h4>
        <table>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Klasa</th>
                <th>Rok Urodzenia</th>
                <th>Wzrost</th>
                <th></th>
            </tr>
            <?php
            $zapytanie = "SELECT * FROM zawodnicy";
            $wynik = mysqli_query($connection, $zapytanie);
 
            while ($wiersz = mysqli_fetch_assoc($wynik)) {
                echo "<tr>";
                echo "<td><input type='checkbox' name='zawodnik_id[]' value='{$wiersz['id']}'></td>";
                echo "<td>{$wiersz['id']}</td>";
                echo "<td>{$wiersz['imie']}</td>";
                echo "<td>{$wiersz['nazwisko']}</td>";
                echo "<td>{$wiersz['klasa']}</td>";
                echo "<td>{$wiersz['rokurodzenia']}</td>";
                echo "<td>{$wiersz['wzrost']}</td>";
                echo "<td><a href='zawodnicy.php?edit={$wiersz['id']}'>Edytuj</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <input type="submit" name="delete" value="Usuń wybranych zawodników">
    </form>
 
    <?php
    if(isset(($_POST["delete"]))){
        $ids=implode(",", $_POST["zawodnik_id[]"]);
 
    $del_polceenie ="DELETE FROM zawodnicy WHERE id=$id";
    if(mysqli_query($connection,$del_polceenie)){
        echo "Usunięto rekord";
                    header('Location: zawodnicy.php');
                    exit;
    }else{
        echo "Error: " .sql ."<br>" . mysqli_error($connection);
    }
    }
   
?>
     
    <?php
    mysqli_close($connection);
    ?>
 
<script>
       
        function selectAll() {
            var checkboxes = document.querySelectorAll('input[name="zawodnik_id[]"]');
            var selectAllCheckbox = document.getElementById('select_all');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }
    </script>
 
</body>
</html>