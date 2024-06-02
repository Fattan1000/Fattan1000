<!-- signup_success.php -->
<?php
header('Refresh:5; URL=login.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/js/bootstrap.min.js"></script>
    <style>
          body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        h4 {
            font-size: 1.5rem;
            color: #495057;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
           
        }
        p {
            font-size: 20px;
            color: #6c757d;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            line-height: 1.5;
            text-align: center;
        }
        .modal#statusSuccessModal .modal-content {
            border-radius: 30px;
        }
        .modal#statusSuccessModal .modal-content svg {
            width: 200px; 
            display: block; 
            margin: 0 auto;
        }
        .modal#statusSuccessModal .modal-content .path, 
        .modal#statusSuccessModal .modal-content .path {
            stroke-dasharray: 1000; 
            stroke-dashoffset: 0;
        }
        .modal#statusSuccessModal .modal-content .path.circle, 
        .modal#statusSuccessModal .modal-content .path.circle {
            -webkit-animation: dash 0.9s ease-in-out; 
            animation: dash 0.9s ease-in-out;
        }
        .modal#statusSuccessModal .modal-content .path.line, 
        .modal#statusSuccessModal .modal-content .path.line {
            stroke-dashoffset: 1000; 
            -webkit-animation: dash 0.95s 0.35s ease-in-out forwards; 
            animation: dash 0.95s 0.35s ease-in-out forwards;
        }
        .modal#statusSuccessModal .modal-content .path.check, 
        .modal#statusSuccessModal .modal-content .path.check {
            stroke-dashoffset: -100; 
            -webkit-animation: dash-check 0.95s 0.35s ease-in-out forwards; 
            animation: dash-check 0.95s 0.35s ease-in-out forwards;
        }

        @keyframes dash { 
            0% {
                stroke-dashoffset: 1000;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes dash-check { 
            0% {
                stroke-dashoffset: -100;
            }
            100% {
                stroke-dashoffset: 900;
            }
        }
    </style>
</head>
<body>
    <div class="container p-5">
        <div class="row">
            <div class="col-12 text-center">
                <!-- Success Modal -->
                <div class="modal fade" id="statusSuccessModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"> 
                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document"> 
                        <div class="modal-content"> 
                            <div class="modal-body text-center p-lg-4"> 
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                    <circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                                    <polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " /> 
                                </svg> 
                                <h4 class="text-success mt-3">Inscription Réussie !</h4> 
                                <p class="mt-3">Votre compte a été créé avec succès.</p>
                            </div> 
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#statusSuccessModal').modal('show');
        });
    </script>
</body>
</html>
