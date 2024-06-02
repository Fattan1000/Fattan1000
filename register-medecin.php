<?php
include("util/connection.php");

if(isset($_POST["submit"])){
    $nom=$_POST["1"];
    $prenom=$_POST["2"];
    $specialite=$_POST["3"];
    $ville= $_POST["4"]  ;
    $email= $_POST["5"]  ;
    $password= $_POST["6"];
    $sexe= $_POST["7"] ;
 ////  /// ///////////////////////////////////////////////////

 if($_FILES['image']['name']==""){ 
   if($sexe=="male") {
    switch($num=rand(0,3)){ 
    case 0:$filepath='photo/doctor_male.png';break;
    default:$filepath='photo/medecin_icon_male'.$num.'.jpeg';break; }
                    }
    else{
        switch(rand(0,1)){ 
            case 0:$filepath='photo/doctor_female.png';break;
            case 1:$filepath='photo/medecin_icon_female.jpeg';break; }
    }
 }else{
 $uploadDir = 'uploads/';
 $filename = uniqid() . '_' . $_FILES['image']['name'];
 $filepath = $uploadDir.$filename;
 move_uploaded_file($_FILES['image']['tmp_name'], $filepath) ;
 move_uploaded_file($_FILES['image']['tmp_name'], 'medecin/uploads/'.$filename) ;
 }
 
 class EmailAlreadyUsedException extends Exception {}

 try {
     // Préparation de la requête pour vérifier si l'email existe déjà
     $stmt = $conn->prepare("SELECT id FROM medecin WHERE email = ?");
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->store_result();

     // Vérification du nombre de résultats
     if ($stmt->num_rows > 0) {
         throw new EmailAlreadyUsedException('Cette email est déjà utilisé');
     } else {
         // Préparation de la requête d'insertion
         $stmt_insert = $conn->prepare("INSERT INTO medecin (nom, prenom, sexe, specialite, ville, email, password, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
         $stmt_insert->bind_param("ssssssss", $nom, $prenom, $sexe, $specialite, $ville, $email, $password, $filepath);

         // Exécution de la requête d'insertion
         if ($stmt_insert->execute()) {
             header('Location: signup_success.php');
             exit();
         } else {
             header('Location: signup_failure.php?error=Data not inserted');
             exit();
         }
     }

     // Fermeture des statements
     $stmt->close();
     $stmt_insert->close();
 } catch (EmailAlreadyUsedException $e) {
     header('Location: signup_failure.php?error=' . urlencode($e->getMessage()));
     exit();
 } catch (Exception $e) {
     // Gestion des autres exceptions
     header('Location: signup_failure.php?error=' . urlencode($e->getMessage()));
     exit();
 }}


?>

<head>
        <meta charset="UTF-8">
        <title>Login Page</title>
        <link href="/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        
        <!-- Section: Design Block -->
        <section class="text-center">
        <!-- Background image -->
        <div class="p-5 bg-image" style="
                background-image: url('https://mdbootstrap.com/img/new/textures/full/171.jpg');
                height: 300px;
                "></div>
        <!-- Background image -->

        <div class="card mx-4 mx-md-5 shadow-5-strong" style="
                margin-top: -100px;
                background: hsla(0, 0%, 100%, 0.8);
                backdrop-filter: blur(30px);
                ">
            <div class="card-body py-5 px-md-5">

            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                <h2 class="fw-bold mb-5">Sign up now</h2>
                <form method="post" enctype="multipart/form-data".>
                    <!-- 2 column grid layout with text inputs for the first and last names -->
                    <div class="row">
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                        <input type="text" id="form3Example1"name="1"  class="form-control"required />
                        <label class="form-label" for="form3Example1">First name</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div data-mdb-input-init class="form-outline">
                        <input type="text" id="form3Example2" name="2"class="form-control"required />
                        <label class="form-label" for="form3Example2">Last name</label>
                        </div>
                    </div>
                    </div> </div>
                      <!-- sexe select -->
                      
                      <div data-mdb-input-init class="form-outline mb-4">
                      <label class="form-label" for="form3Example3" >Sexe : </label>
                      <select name="7" id="form3Example3">
                       <option value="male">male</option>
                       <option value="female">female</option>
                       
                     </select>

                        
                    </div>
                    <!-- specialiter input -->
                    <div data-mdb-input-init class="form-outline mb-4" >
                    <input type="text" id="form3Example4"name="3" class="form-control"required />
                    <label class="form-label" for="form3Example4">specialite</label>
                    </div>
                    <!-- ville input -->
                    <div data-mdb-input-init class="form-outline mb-4" >
                    <input type="text" id="form3Example5"name="4" class="form-control" required/>
                    <label class="form-label" for="form3Example5">Ville</label>
                    </div>
               <!-- image input -->
               <div data-mdb-input-init class="form-outline mb-4" >
                    <input type="file"accept=".jpg,.jpeg,.png" id="form3Example6"name="image" class="form-control" />
                    <label class="form-label" for="form3Example6" value="">image</label>
                    </div>
                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="form3Example7" name="5"class="form-control" required/>
                    <label class="form-label" for="form3Example7">Email address</label>
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form3Example8"name="6" class="form-control"required />
                    <label class="form-label" for="form3Example8">Password</label>
                    </div>
                    

                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-center mb-4">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                    <label class="form-check-label" for="form2Example33">
                        Subscribe to our newsletter
                    </label>
                    </div>

                    <!-- Submit button -->
                    <button name="submit" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">
                    Sign up
                    </button>

                    <!-- Register buttons -->
                    <div class="text-center">
                    <p>or sign up with:</p>
                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                        <i class="fab fa-facebook-f"></i>
                    </button>

                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                        <i class="fab fa-google"></i>
                    </button>

                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                        <i class="fab fa-twitter"></i>
                    </button>

                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-link btn-floating mx-1">
                        <i class="fab fa-github"></i>
                    </button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
        </section>
        <!-- Section: Design Block -->

        <script src="/js/jquery.min.js"></script>
        
    </body>
</html>

