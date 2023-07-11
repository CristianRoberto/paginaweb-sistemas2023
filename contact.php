<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if(!$_POST) exit;

// Email address verification, do not edit.
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$comments = $_POST['comments'];

if(trim($first_name) == '') {
    echo '<div class="error_message">Attention! You must enter your name.</div>';
    exit();
} else if(trim($email) == '') {
    echo '<div class="error_message">Attention! Please enter a valid email address.</div>';
    exit();
} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo '<div class="error_message">Attention! You have entered an invalid email address, try again.</div>';
    exit();
}

if(trim($comments) == '') {
    echo '<div class="error_message">Attention! Please enter your message.</div>';
    exit();
}

// Configuración de la conexión a la base de datos
$host = "localhost";
$dbName = "contactospagina";
$username = "root";
$password = "gilcespanta1994";

// Establecer la conexión a la base de datos
$conn = new mysqli($host, $username, $password, $dbName);

// Verificar si hay errores de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Preparar la consulta de inserción
$stmt = $conn->prepare("INSERT INTO contactos (first_name, last_name, email, phone, comments) VALUES (?, ?, ?, ?, ?)");

// Vincular los valores de los campos del formulario a los parámetros de la consulta
$stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $comments);

// Ejecutar la consulta
if ($stmt->execute()) {
    // La inserción en la base de datos fue exitosa

    // ... Código adicional si es necesario ...
echo "<fieldset>";
echo "<div id='success_page'>";
echo "<h1>Email enviado exitosamente.</h1>";
echo "<p>Gracias <strong>$first_name</strong>, tu mensaje ha sido enviado correctamente.</p>";
echo "</div>";
echo "</fieldset>";

} else {
    // Ocurrió un error al ejecutar la consulta
    // ... Código adicional si es necesario ...
    echo 'ERROR!';
}

// Cerrar la conexión y liberar recursos
$stmt->close();
$conn->close();
