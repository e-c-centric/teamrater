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

    <div class="modal" id="register_modal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="register_email">Email address</label>
                            <input type="email" class="form-control" id="register_email" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="register_button">Register</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#register_modal").modal('show');

            $('#register_modal').on('hidden.bs.modal', function(e) {
                window.location.href = "index.php";
            });

        });

        $("#register_button").click(function() {
            var email = $("#register_email").val();
            $.ajax({
                type: "POST",
                url: "../actions/register_action.php",
                data: {
                    email: email
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        swal({
                            title: "Success",
                            text: data.message,
                            icon: "success",
                            buttons: true,
                            dangerMode: false,
                        }).then((value) => {
                            window.location.href = "loginModal.php";
                        });
                    } else {
                        swal("Error", data.message, "error");
                    }
                }
            });
        });
    </script>
</body>

</html>