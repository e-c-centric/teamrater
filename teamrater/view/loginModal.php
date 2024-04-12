<?php
session_start();
if (isset($_SESSION['email'])) {
    unset($_SESSION['email']);
}
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>Teamrater</title>

    <link rel="shortcut icon" href="../img/teamraterlogo.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>

<body>
    <div class="modal" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login/Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="pin">PIN</label>
                            <input type="password" class="form-control" id="pin" placeholder="PIN">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="login_btn">Login</button>
                    <button type="button" class="btn btn-primary" id="register_btn">Register</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $("#login_modal").modal('show');

            $('#login_modal').on('hidden.bs.modal', function(e) {
                window.location.href = "index.php";
            });

            $('#register_btn').click(function() {
                window.location.href = "registerModal.php";
            });

        });

        $('#login_btn').click(function() {
            var email = $('#email').val();
            var pin = $('#pin').val();

            $.ajax({
                url: '../actions/login_action.php',
                type: 'POST',
                data: {
                    email: email,
                    pin: pin
                },
                dataType: 'text',
                success: function(response) {
                    if (response == 'success') {
                        swal({
                            title: "Success",
                            text: "You have successfully logged in",
                            icon: "success",
                            buttons: true,
                            dangerMode: false,
                        }).then((value) => {
                            window.location.href = "index.php";
                        });
                    } else {
                        swal({
                            title: "Error",
                            text: response,
                            icon: "error",
                            buttons: true,
                            dangerMode: true,

                        }).then((value) => {
                            window.location.href = "loginModal.php";
                        });
                    }

                }
            });
        });
    </script>
</body>

</html>