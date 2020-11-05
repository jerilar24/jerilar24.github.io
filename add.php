<?php

// Associative array which contains the error messages
$errors = array('email' => '', 'title' => '', 'ingredients' => '');

// Debemos revisar si se han enviado datos, 
// o si se entra por primera vez.
if (isset($_POST['submit'])) {
    //toda la informacion de guarda en un arreglo asociativo
    //con los datos que nombres que hemos dado a cada campo input
    //  para evitar xss Cada salida al site debe ser hecha tras la funcion
    // htmlspecialchars()
    // echo htmlspecialchars($_POST['email']) . '<br>';

    // Validaciones basicas

    // chk email
    if (empty($_POST['email'])) {
        // echo 'An email is required <br>';
        $errors['email'] =  'An email is required';
    } else {
        // echo htmlspecialchars($_POST['email']) . '<br>';
        $email = $_POST['email'];
        // filter_var valida una variable con diferentes filtros
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // echo 'A valid email is required' . '<br>';
            $errors['email'] = 'A valid email is required';
        }
    }

    // chk title
    if (empty($_POST['title'])) {
        // echo 'A titel is required <br>';
        $errors['title'] = 'A titel is required';
    } else {
        // echo htmlspecialchars($_POST['title']) . '<br>';
        $title = $_POST['title'];
        // preg_match revisa si un texto cumple con la expresion regular
        // regex inicia y finaliza con /
        // ^ desde el inicio, $ hasta el final
        // \s son espacios blancos
        // + todo lo anterior n veces donde n >= 1
        // * todo lo anterior n veces donde n >= 0
        if (!preg_match('/^[a-zA-z\s]+$/', $title)) {
            // echo 'Title must be letters and spaces only' . '<br>';
            $errors['title'] = 'Title must be letters and spaces only';
        }
    }

    // chk ingredient
    if (empty($_POST['ingredients'])) {
        // echo 'At least an ingrediet is required <br>';
        $errors['ingredients'] = 'At least an ingredient is required';
    } else {
        // echo htmlspecialchars($_POST['ingredients']) . '<br>';
        $ingredients = $_POST['ingredients'];
        // regex para validar lista de solo palabras separada por comas
        if (!preg_match('/^([a-zA-z\s]+)(,\s+[a-zA-Z\s]*)*$/', $ingredients)) {
            // echo 'Ingredients must be a comma separeted list' . '<br>';
            $errors['ingredients'] = 'Ingredients must be a comma separated list';
        }
    }

    // Si todos los elementos de un array son falsos o empty strings return true
    if(!array_filter($errors)){
        header('Location: index.php');
    }

}   //End of POST chk
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'templates/header.php'; ?>

<section class="container grey-text">
    <h4 class="center">Ingrese los datos</h4>
    <!--action es lo que se hara al hacer click, o en este caso el archivo 
    donde esta que se hara, y method es el metodo a usar,
    post o get(se muestra la info en la barra) -->
    <form action="" class="white" action="add.php" method="POST">
        <label>Email:</label>
        <input type="text" name="email" , value="<?php echo isset($email) ? $email : ''; ?>"> <!-- poner el tipo de dato a recibir ayuda a vallidar-->
        <!--showing errors area-->
        <div class="red-text"><?php echo htmlspecialchars($errors['email']); ?></div>
        <label>Title:</label>
        <input type="text" name="title" , value="<?php echo isset($title) ? $title : ''; ?>">
        <div class="red-text"><?php echo htmlspecialchars($errors['title']); ?></div>
        <label>Ingredients:</label>
        <input type="text" name="ingredients" , value="<?php echo isset($ingredients) ? $ingredients : ''; ?>">
        <div class="red-text"><?php echo htmlspecialchars($errors['ingredients']); ?></div>
        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include 'templates/footer.php'; ?>

</html>