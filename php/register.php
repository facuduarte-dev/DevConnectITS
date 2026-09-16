<?php

// Load the database connection.
require_once "db_connect.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //add trim to delete te spaces " " 
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];


   

    //validations before saving it to the database.

    // Require a non-empty name.
    if($name === ""){
        echo "nombre de usuario obligatorio ";
        exit();
    }

    //validate the email format.
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "El correo electronico ingresado no es valido";
        exit();
    }

    // Require a minimum password length.
    if(strlen($password) < 8){
        echo "la contraseña tiene un minimo de 8 caracteres";
        exit();
    }

    //require at least one uppercase letter.
    if (!preg_match("/[A-Z]/", $password)) {
    echo "La contraseña debe contener al menos una letra mayúscula";
    exit();
}

 //require at least one lowercase letter.
    if (!preg_match("/[a-z]/", $password)) {
    echo "La contraseña debe contener al menos una letra minúscula";
    exit();
}


 //require at least one number.
    if (!preg_match("/[0-9]/", $password)) {
    echo "La contraseña debe contener al menos un numero ";
    exit();
}

    if(!preg_match('/[!@#$%^&*]/', $password)){
        echo "La contraseña debe contener al menos un caracter especial";
        exit();
    }


    // Hash the password before storing it.
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Define the SQL query using placeholders.
    $sql = "INSERT INTO usuarios (name, email, password) VALUES
     (?, ?, ?)";


    // Prepare the SQL query.
    $stmt = $conn->prepare($sql);

    // Bind the values to the placeholders.
    $stmt->bind_param("sss", $name, $email, $passwordHash);

    // Execute the prepared query.
    $stmt->execute();

    echo "luciogay";

    echo "Los datos se obtuvieron de manera correcta";
}