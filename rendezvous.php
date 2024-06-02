<?php
include("util/connection.php");
include("util/navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
<script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<title>Rendezvous</title>
<style>
    .doctor-image {
        height: 130px;
        width: 130px;
        margin-top: -90px;
        margin-left: 60px;
        border-radius: 450px;
    }
    .doc-infoB {
        background-color: white;
        color: black;
        margin: 12px;
        margin-top: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ajoute une ombre subtile */
        margin-right: 650px;
        border-radius: 20px;
    }
    .doc-info {
        padding:5px;
      padding-top:30px;
      
        margin-right: 80px;
        text-align: center;
    }
    .doc-info2 {
        background-color: #E3FEF7;
        padding: 1px;
        color: white;
    }
    .doc-info3B {
        background-color: white;
        color: black;
        margin: 12px;
        margin-top: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ajoute une ombre subtile */
        margin-right: 650px;
        border-radius: 20px;
    }
    .doc-info3 {
        padding: 20px;
    }
    .commentaireB {
        margin: 30px;
        margin-top: 12px;
        background-color: white;
        color: black;
    }
    .comment-form {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: 14px;
    }
    .Ajouter_un_commentaire {
        background-color: #003C43;
        color: white;
        height: 45px;
        width: 280px;
        border-radius: 6px;
        margin-left: 5px;
    }
    .ajouter_commentaire_div {
        padding: 40px;
        background-color:#f5f5f5;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Ajoute une ombre subtile */
        border-radius: 6px;
    }
    .input_commentaire {
        height: 45px;
        width: 732px;
        border-color: #083344;
        border-width: 2px;
        border-radius: 6px;
    }
    .input_note {
        display: none;
    }
    .star {
        cursor: pointer;
        font-size: 1.5em;
        color: gold;
    }
    .icon {
        color: gray;
        font-size: 0.75em; /* 50% smaller */
        margin-right: 8px; /* Small margin for spacing */
    }
    .rating{
        margin-top:-38px;
       
       
    }
    .social-buttons a {
       
        margin: 0 5px;
       
        color: gray; /* Matching the button color */
        font-size: 1.5em;
    }
</style>
</head>
<body>
<div class="doc-info2">
<div class="doc-infoB">
    <div class="doc-info">
        <?php
        // Check if the doctor's ID is passed as a query parameter
        if (isset($_GET['id_medecin'])) {
            $doctorId = mysqli_real_escape_string($conn, $_GET['id_medecin']);
            
            // Fetch doctor's data from the database
            $query = "SELECT * FROM medecin WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'i', $doctorId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
               
                echo "<p style='font-weight: bold; font-size: 1.5em;'>Dr. " . $row['nom'] . " " . $row['prenom'] . "</p>";
                echo "<p> " . $row['specialite'] . " à " . $row['ville'] . "</p>";
                echo "<img src='" . $row['image'] . "' alt='Doctor Image' class='doctor-image'>";
            } else {
                echo "<p>No doctor found.</p>";
            }
        } else {
            echo "<p>No doctor ID provided.</p>";
        }

        // Calculate the average rating
        $query = "SELECT AVG(note) as average_rating FROM evaluation WHERE medecin_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $doctorId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $averageRating = round($row['average_rating'], 1); // Round to 1 decimal place
            echo "<div class='rating'>";
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $averageRating) {
                    
                    echo "<i class='fas fa-star' style='color: gold;'></i>";
                    
                } else {
                    echo "<i class='far fa-star' style='color: gold;'></i>";
        ;
                }
            }
            echo "<p> " . $averageRating . "/5</p>";
            echo "</div>";
        } else {
            echo "<p>No ratings available.</p>";
        }
        ?>
         <div class="social-buttons">
            <a href="https://www.facebook.com/sharer/sharer.php?u=YOUR_URL" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/intent/tweet?url=YOUR_URL" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="mailto:?subject=Check out this doctor&amp;body=Check out this doctor: YOUR_URL"><i class="fas fa-envelope"></i></a>
        </div>
    </div>
</div>

<?php include("util/calendrier.php"); ?>
<div class="doc-info3B">
    <div class="doc-info3" id="carte">
       
        <?php
        if (isset($_GET['id_medecin'])) {
            $doctorId = mysqli_real_escape_string($conn, $_GET['id_medecin']);
            
            // Fetch doctor's data from the database
            $query = "SELECT * FROM medecin WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'i', $doctorId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                ?>
                <h5 style="font-weight: bold;"><i class="fas fa-user-md icon"></i>Presentation</h5>   
                <?php 
                echo "<p> " . $row['presentation'] . "</p>";

                ?>
                <h5 style="font-weight: bold;"><i class="fas fa-clock icon"></i>Horaires d'ouverture</h5>   
                <?php 
                echo "<p> " . $row['horaires'] . "</p>";

                ?>
                <h5 style="font-weight: bold;"><i class="fas fa-graduation-cap icon"></i>Expériences / Diplômes nationaux et universitaires</h5>   
                <?php 
                echo "<p> " . $row['experience_diplome'] . "</p>";

                ?>
                <h5 style="font-weight: bold;"><i class="fas fa-money-bill-wave icon"></i>Tarifs</h5>   
                <?php 
                echo "<p> " . $row['tarif'] . "</p>";

                ?>
                <h5 style="font-weight: bold;"><i class="fas fa-credit-card icon"></i>Moyens de paiement</h5>   
                <?php 
                echo "<p> " . $row['mode_paiement'] . "</p>";
            }
        }
        ?>
    </div>
</div>
</div>

<div class="commentaireB" id="commentaire">
    <div class="commentaire">
    <?php
        // Count the number of comments
        $query = "SELECT COUNT(*) as comment_count FROM evaluation WHERE medecin_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $doctorId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $commentCount = $row['comment_count'];
        ?>
        <h5 style="font-weight: bold;"><i class="fas fa-comment icon"></i>Commentaires (<?php echo $commentCount; ?>)</h5>
        <!-- Form to add a comment -->
        <div class="ajouter_commentaire_div">
            <form id="comment-form" class="comment-form">
                <input type="hidden" name="id_medecin" value="<?php echo $doctorId; ?>">
                <input class="input_commentaire" type="text" name="commentaire" placeholder="Ajoutez un commentaire...">
                <div class="note">
                    <i class="star far fa-star" data-value="1"></i>
                    <i class="star far fa-star" data-value="2"></i>
                    <i class="star far fa-star" data-value="3"></i>
                    <i class="star far fa-star" data-value="4"></i>
                    <i class="star far fa-star" data-value="5"></i>
                </div>
                <input class="input_note" type="number" name="note" min="1" max="5">
                <button type="submit" class="Ajouter_un_commentaire">Ajouter un commentaire</button>
            </form>
        </div>

        <p> </p>
      

        <div id="comments-list">
            <?php
            // Display existing comments
            $query = "
                SELECT e.commentaire, e.note, e.date_evaluation, p.nom AS patient_nom, p.prenom AS patient_prenom
                FROM evaluation e
                JOIN patient p ON e.patient_id = p.id
                WHERE e.medecin_id = ?
            ";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'i', $doctorId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p><strong>" . $row['patient_prenom'] . " " . $row['patient_nom'] . "</strong> " . $row['date_evaluation'] . " / ";
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $row['note']) {
                        echo "<i class='fas fa-star' style='color: gold;'></i>";
                    } else {
                        echo "<i class='far fa-star' style='color: gold;'></i>";
                    }
                }
                echo "<br> " . $row['commentaire'] . "</p>";
            }
            ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.star');
    const noteInput = document.querySelector('.input_note');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-value');
            noteInput.value = rating;

            stars.forEach(s => {
                if (s.getAttribute('data-value') <= rating) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                } else {
                    s.classList.remove('fas');
                    s.classList.add('far');
                }
            });
        });
    });

    const commentForm = document.getElementById('comment-form');
    commentForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(commentForm);

        fetch('submit_comment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('comments-list').innerHTML = data;
            commentForm.reset();
            stars.forEach(s => {
                s.classList.remove('fas');
                s.classList.add('far');
            });
        });
    });
});


</script>
</body>
</html>
