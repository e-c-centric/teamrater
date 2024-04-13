<?php
include 'confirm.php';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>Teamrater::Rate</title>

    <link rel="stylesheet" type="text/css" href="../css/site.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../js/modernizr-2.6.2.js"></script>
    <link rel="shortcut icon" href="../img/teamraterlogo.png">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>




</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container body-content">


        <div class="row">
            <div class="col-md-10">
                <h2>Rate your teammate:</h2>
                <hr />
                <form class="form-inline" action="" method="post">
                    <input id="csrf_token" name="csrf_token" type="hidden">
                    <table class="table table-striped table-bordered">

                        <tr>
                            <td class="col-md-6">
                                <strong>Last Name:</strong>
                            </td>
                            <td class="col-md-6 text-center">
                                <input class="form-control" id="lastname" name="lastname" required type="text" value="">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right">
                                <input id="formName" name="formName" type="hidden" value="rateStep1">
                                <input class="btn" id="submitLastName" name="submitLastName" type="submit" value="Continue" onclick="rateUser(event)">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

        </div>

        <div class="modal fade" id="rateTeammateModal" tabindex="-1" role="dialog" aria-labelledby="rateTeammateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rateTeammateModalLabel">Rate Your Teammate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline" action="" method="post">
                            <div class="form-group">
                                <label for="userDropdown">Select Teammate:</label>
                                <select class="form-control" id="userDropdown">
                                </select>
                            </div>
                            <br><br>
                            <div id="questionFields">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="rateNewTeammateModal" tabindex="-1" role="dialog" aria-labelledby="rateTeammateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rateTeammateModalLabel">Rate Your Teammate</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline" action="" method="post">
                            <div class="form-group">
                                <label for="fname">First Name:</label>
                                <input type="text" class="form-control" id="fname" name="fname" required>
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name:</label>
                                <input type="text" class="form-control" id="lname" name="lname" required>
                            </div>
                            <div class="form-group">
                                <label for="middle_initial">Middle Initial:</label>
                                <input type="text" class="form-control" id="middle_initial" name="middle_initial">
                            </div>
                            <div class="form-group">
                                <label for="association">Association:</label>
                                <input type="text" class="form-control" id="association" name="association" required>
                            </div>
                            <br><br>
                            <div id="questionFieldsForNewUser">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitNewUser">Submit</button>
                    </div>
                </div>
            </div>
        </div>




        <hr />
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </div>

    <script>
        var userDropdown = $("#userDropdown");

        function rateUser(event) {
            event.preventDefault();
            fetchUsers();
            fetchCriteriaAndGenerateQuestions();
            $("#rateTeammateModal").modal("show");
        }


        function fetchUsers() {

            userDropdown.empty();
            $.ajax({
                type: "GET",
                url: "../actions/fetch_all_users.php",
                data: {
                    lname: $("#lastname").val()
                },
                dataType: "json",
                success: function(data) {
                    userDropdown.prepend($("<option></option>")
                        .attr("value", "")
                        .text("Select your teammate")
                        .prop("selected", true)
                        .prop("disabled", true));
                    if (data.success) {
                        $.each(data.users_data, function(index, user) {
                            userDropdown.append($("<option></option>")
                                .attr("value", user.userid)
                                .text(user.fname + " " + user.lname));
                        });
                    } else {
                        userDropdown.append($("<option></option>")
                            .attr("value", "new")
                            .text("Add New Teammate"));
                    }
                },
                error: function(data) {
                    console.error("Error fetching users: " + data.message);
                }
            });
        }



        function fetchCriteriaAndGenerateQuestions() {
            $.ajax({
                type: "POST",
                url: "../actions/fetch_all_criteria.php",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        var questionFields = $("#questionFields");
                        questionFields.empty();
                        $.each(data.criteria, function(index, criterion) {
                            var question = $("<div></div>")
                                .addClass("form-group")
                                .append($("<label></label>")
                                    .text("Rate your temmate in terms of their " + criterion.criterianame.toLowerCase() + " (" + criterion.description + ")"))
                                .append($("<input>")
                                    .attr("type", "number")
                                    .addClass("form-control")
                                    .attr("name", "q" + criterion.criteriaid)
                                    .attr("placeholder", "Enter rating (1-10)")
                                    .attr("min", "1")
                                    .attr("max", "10")
                                    .prop("required", true));
                            questionFields.append(question);
                        });
                    } else {
                        console.error("Error fetching criteria: " + data.message);
                    }
                }
            });
        }

        userDropdown.change(function() {
            if ($(this).val() === 'new') {
                $("#rateNewTeammateModal").modal("show");
                fetchCriteriaAndGenerateQuestionsForNewUser();
            }
        });

        $("#submit").click(function() {
            var target_userid = $("#userDropdown").val();
            var target_criteriaids = "";
            var values = "";
            $("#questionFields input").each(function(index, input) {
                target_criteriaids += $(input).attr("name").substring(1) + ",";
                var numericValue = parseFloat($(input).val());
                if (isNaN(numericValue)) {
                    numericValue = $(input).val();
                }
                values += numericValue + ",";
            });
            target_criteriaids = target_criteriaids.slice(0, -1);
            values = values.slice(0, -1);

            $.ajax({
                type: "POST",
                url: "../actions/update_ratings_action.php",
                data: {
                    target_userid: target_userid,
                    target_criteriaids: target_criteriaids,
                    values: values
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
                            window.location.href = "index.php";
                        });
                    } else {
                        swal("Error", data.message, "error");
                    }
                }
            });
        });


        function fetchCriteriaAndGenerateQuestionsForNewUser() {
            $.ajax({
                type: "POST",
                url: "../actions/fetch_all_criteria.php",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        var questionFields = $("#questionFieldsForNewUser");
                        questionFields.empty();
                        $.each(data.criteria, function(index, criterion) {
                            var question = $("<div></div>")
                                .addClass("form-group")
                                .append($("<label></label>")
                                    .text("Rate your temmate in terms of their " + criterion.criterianame.toLowerCase() + " (" + criterion.description + ")"))
                                .append($("<input>")
                                    .attr("type", "number")
                                    .addClass("form-control")
                                    .attr("name", "q" + criterion.criteriaid)
                                    .attr("placeholder", "Enter rating (1-10)")
                                    .attr("min", "1")
                                    .attr("max", "10")
                                    .prop("required", true));
                            questionFields.append(question);
                        });
                    } else {
                        console.error("Error fetching criteria: " + data.message);
                    }
                }
            });
        }




        $("#submitNewUser").click(function() {
            var fname = $("#fname").val();
            var lname = $("#lname").val();
            var middle_initial = $("#middle_initial").val();
            var association = $("#association").val();
            var target_criteriaids = "";
            var values = "";
            $("#questionFieldsForNewUser input").each(function(index, input) {
                target_criteriaids += $(input).attr("name").substring(1) + ",";
                var numericValue = parseFloat($(input).val());
                if (isNaN(numericValue)) {
                    numericValue = $(input).val();
                }
                values += numericValue + ",";
            });
            target_criteriaids = target_criteriaids.slice(0, -1);
            values = values.slice(0, -1);

            $.ajax({
                type: "POST",
                url: "../actions/add_new_user.php",
                data: {
                    fname: fname,
                    lname: lname,
                    middle_initial: middle_initial,
                    association: association,
                    target_criteriaids: target_criteriaids,
                    values: values
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        var userid = data.userid;
                        $.ajax({
                            type: "POST",
                            url: "../actions/update_ratings_action.php",
                            data: {
                                target_userid: userid,
                                target_criteriaids: target_criteriaids,
                                values: values
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
                                        window.location.href = "index.php";
                                    });
                                } else {
                                    swal("Error", data.message, "error");
                                }
                            }
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