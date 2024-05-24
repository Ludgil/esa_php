<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Color Cookie</title>
</head>
<?php
$random_number = rand(1, 20);
if(isset($_POST['colors'])){
    if(isset($_COOKIE['color'])){
        setcookie('color', $_POST['colors']);
    }else{
        setcookie('color', 'white');
    }
    header('location:index.php');
}
?>
<body style="background-color:<?php echo $_COOKIE['color'] ?>">
    <div class="container">
        <form action="index.php" method="post">
            <div>
                <label for="colors"  style="color:<?php echo $_COOKIE['color'] == 'black' ? "white" : "black" ?>">Background Color:</label>
                <select name="colors" id="colors">
                    <option value="white"> white </option>
                    <option value="red"> red </option>
                    <option value="black"> black </option>
                    <option value="yellow"> yellow </option>
                    <option value="pink"> pink </option>
                    <option value="brown"> brown </option>
                    <option value="blue"> blue </option>
                </select>
            </div>
            <div>
                <button type="submit">Select</button>
            </div>
        </form>
        <div>
            <p class="number" style="color:<?php echo $_COOKIE['color'] == 'black' ? "white" : "black" ?>"><?php echo $random_number; ?></p>
        </div>
    </div>
</body>
</html>


