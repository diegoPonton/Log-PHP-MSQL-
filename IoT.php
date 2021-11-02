<?php
session_start();

require 'database.php';

if (isset($_SESSION['user_id'])) {
  $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
  $records->bindParam(':id', $_SESSION['user_id']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = null;

  if (count($results) > 0) {
    $user = $results;
  }
}
?>


<!DOCTYPE HTML>
<html>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' integrity='sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr' crossorigin='anonymous'>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;1,700&display=swap' rel='stylesheet'>
    <style>
        html {
            font-family: Arial;
            display: inline-block;
            margin: 0px auto;
            text-align: center;
        }
        
        h2 {
            font-size: 3.0rem;
        }
        
        p {
            font-size: 3.0rem;
        }
        
        .units {
            font-size: 1.2rem;
        }
        
        .dht-labels {
            font-size: 1.5rem;
            vertical-align: middle;
            padding-bottom: 15px;
        }
        
        .button {
            border: none;
            outline: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            color: white;
            width: 150px;
            transition: 0.2s;
        }
        
        .verde {
            background-color: chartreuse;
        }
        
        .rojo {
            background-color: crimson;
        }
        
        .blanco {
            background-color: darkgrey;
        }
        
        .amarillo {
            background-color: yellow;
            color: black;
        }
        
        body {
            color: white;
            background: rgb(2, 0, 36);
            background: linear-gradient(180deg, rgba(45, 81, 228, 1) 50%, rgba(0, 212, 255, 1) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100vw;
            align-items: center;
            font-family: 'Open Sans', sans-serif;
            font-weight: 700;
            font-style: italic;
        }
    </style>
</head>

<body>

    <?php require 'partials/header.php' ?>
        
    <h1>Sesion iniciada como:  <?php echo $user['email']?></h1> 
      


    <h1>Servidor Web ESP32</h1>


    <p>
        <i class="fas fa-thermometer-half" style="color:#059e8a;"></i>
        <span class="dht-labels">Temperature</span>
        <span id="temperature">%TEMPERATURE%</span>
        <sup class="units">&deg;C</sup>
    </p>
    <p>
        <i class="fas fa-tint" style="color:#00add6;"></i>
        <span class="dht-labels">Humidity</span>
        <span id="humidity">%HUMIDITY%</span>
        <sup class="units">&percnt;</sup>
    </p>
    <h2>Foco Verde</h2>
    <p><a href='/onV'><button class='button verde'>ON</button></a></p>
    <p><a href='/offV'><button class='button verde'>OFF</button></a></p>
    <div></div>
    <h2>Foco Blanco</h2>
    <p><a href='/onB'><button class='button blanco'>ON</button></a></p>
    <p><a href='/offB'><button class='button blanco'>OFF</button></a></p>
    <div></div>
    <h2>Foco Rojo</h2>
    <p><a href='/onR'><button class='button rojo'>ON</button></a></p>
    <p><a href='/offR'><button class='button rojo'>OFF</button></a></p>
    <div></div>
    <h2>Foco Amarillo</h2>
    <p><a href='/onA'><button class='button amarillo'>ON</button></a></p>
    <p><a href='/offA'><button class='button amarillo'>OFF</button></a></p>
    
</body>
<script>
    setInterval(function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("temperature").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/temperature", true);
        xhttp.send();
    }, 10000);

    setInterval(function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("humidity").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/humidity", true);
        xhttp.send();
    }, 10000);
</script>

</html>