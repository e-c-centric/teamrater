<?php
include 'confirm.php';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <title>Teamrater::Search</title>

    <link rel="stylesheet" type="text/css" href="../css/site.css" />
    <link rel="stylesheet" type="text/css" href="../css/starability-basic.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../js/modernizr-2.6.2.js"></script>
    <link rel="shortcut icon" href="../img/teamraterlogo.png">



    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container body-content">

        <div class="row">
            <div class="col-md-10">
                <h2>Search for a teammate by name, or criteria:</h2>
                <hr />
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#upview"><span class="fa fa-eye"></span>Search by surname</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#fullnameview"><span class="fa fa-eye"></span> Search by surname and first name</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#criteriaview"><span class="fa fa-eye"></span> Search by criteria</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content">
            <div class="container tab-pane active" id="upview"><br>
                <div class="row">
                    <div class="col-md-10">
                        <h2>Search by surname:</h2>
                        <hr />
                        <form class="form-inline" action="" method="post">
                            <input id="csrf_token" name="csrf_token" type="hidden">
                            <table class="table table-striped table-bordered" id="formtable">

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
                                        <input class="btn" id="submit" name="submit" type="submit" value="Continue">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>

                </div>



            </div>




            <div class="container tab-pane fade" id="fullnameview"><br>
                <div class="row">
                    <div class="col-md-10">
                        <h2>Search by surname and first name:</h2>
                        <hr />
                        <form class="form-inline" action="" method="post">
                            <input id="csrf_token" name="csrf_token" type="hidden">
                            <table class="table table-striped table-bordered" id="formtable">

                                <tr>
                                    <td class="col-md-6">
                                        <strong>Last Name:</strong>
                                    </td>
                                    <td class="col-md-6 text-center">
                                        <input class="form-control" id="lastname" name="lastname" required type="text" value="">

                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-6">
                                        <strong>First Name:</strong>
                                    </td>
                                    <td class="col-md-6 text-center">
                                        <input class="form-control" id="firstname" name="firstname" required type="text" value="">

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <input id="formName" name="formName" type="hidden" value="rateStep1">
                                        <input class="btn" id="fullnamesubmit" name="fullnamesubmit" type="submit" value="Continue">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>


            </div>

            <div class="container tab-pane fade" id="criteriaview"><br>
                <div class="row">
                    <div class="col-md-10">
                        <h2>Search by criteria:</h2>
                        <hr />
                        <form class="form-inline" action="" method="post">
                            <input id="csrf_token" name="csrf_token" type="hidden">
                            <table class="table table-striped table-bordered" id="formtable">

                                <tr>
                                    <td class="col-md-6">
                                        <strong>Criteria:</strong>
                                    </td>
                                    <td class="col-md-6 text-center">
                                        <select class="form-control" id="criteria" name="criteria" required>
                                            <option value selected disabled>Select criteria</option>
                                        </select>

                                        <select class="form-control" id="order" name="order" required>
                                            <option value selected disabled>Order by</option>
                                            <option value="0">Highest rating first</option>
                                            <option value="1">Rated by more people</option>
                                        </select>


                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <input id="formName" name="formName" type="hidden" value="rateStep1">
                                        <input class="btn" id="criterionsubmit" name="criterionsubmit" type="submit" value="Continue">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <h2>Results:</h2>
                <hr />
                <table class="table table-striped table-bordered" id="usertable">
                </table>
            </div>
        </div>




        <hr />
        <footer>
            <?php include 'footer.php'; ?>

        </footer>
    </div>


    </div>

    </div>


    <script>
        $.ajax({
            url: '../actions/fetch_all_criteria.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var criteriaDropdown = $('#criteria');
                criteriaDropdown.empty();
                $.each(data.criteria, function(index, criteria) {
                    criteriaDropdown.append($('<option></option>').attr('value', criteria.criteriaid).text(criteria.criterianame));
                });
            },
            error: function(xhr, status, error) {
                console.log('Error fetching criteria:', error);
            }
        });

        $('#criterionsubmit').click(function(e) {
            e.preventDefault();
            var usersTable = $('#usertable');
            var criteriaid = $('#criteria').val();
            var order = $('#order').val();
            $.ajax({
                url: '../actions/get_users_by_criterion.php',
                type: 'GET',
                data: {
                    criteriaid: criteriaid,
                    order: order
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        usersTable.empty();
                        usersTable.append('<tr><th>First Name</th><th>Middle Initial</th><th>Last Name</th><th>Association</th><th>Rating</th><th>Number of raters</th></tr>');
                        $.each(data.users_data, function(index, user) {
                            usersTable.append('<tr><td>' + user.fname + '</td><td>' + user.middle_initial + '</td><td>' + user.lname + '</td><td>' + user.association + '</td><td>' + user.rating_value + '</td><td>' + user.numberofraters + '</td></tr>');
                        });
                        usersTable.append('<tr><td colspan="6"><a onclick= window.location.reload()>Reset</a></td></tr>');
                    } else {
                        usersTable.append('<tr><td colspan="6">No users found</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    usersTable.append('<tr><td colspan="6">Error fetching users</td></tr>');
                }
            });
        });

        $('#fullnamesubmit').click(function(e) {
            e.preventDefault();
            var usersTable = $('#usertable');
            var lastname = $('#lastname').val();
            var firstname = $('#firstname').val();
            $.ajax({
                url: '../actions/fetch_all_users.php',
                type: 'GET',
                data: {
                    lname: lastname,
                    fname: firstname
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        usersTable.empty();
                        usersTable.append('<tr><th>First Name</th><th>Middle Initial</th><th>Last Name</th><th>Association</th><th>Rating</th><th>Number of raters</th></tr>');
                        $.each(data.users_data, function(index, user) {
                            $.each(user.ratings, function(index, rating) {
                                usersTable.append('<tr><td>' + user.fname + '</td><td>' + user.middle_initial + '</td><td>' + user.lname + '</td><td>' + user.association + '</td><td>' + rating.criterianame + ': ' + rating.rating_value + '</td><td>' + rating.numberofraters + '</td></tr>');
                            });
                        });
                        usersTable.append('<tr><td colspan="6"><a onclick= window.location.reload()>Reset</a></td></tr>');

                    } else {
                        usersTable.append('<tr><td colspan="6">No users found</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    usersTable.append('<tr><td colspan="6">Error fetching users</td></tr>');
                }
            });
        });

        $('#submit').click(function(e) {
            e.preventDefault();
            var lastname = $('#lastname').val();
            var usersTable = $('#usertable');
            $.ajax({
                url: '../actions/fetch_all_users.php',
                type: 'GET',
                data: {
                    lname: lastname,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        usersTable.empty();
                        usersTable.append('<tr><th>First Name</th><th>Middle Initial</th><th>Last Name</th><th>Association</th><th>Rating</th><th>Number of raters</th></tr>');
                        $.each(data.users_data, function(index, user) {
                            $.each(user.ratings, function(index, rating) {
                                usersTable.append('<tr><td>' + user.fname + '</td><td>' + user.middle_initial + '</td><td>' + user.lname + '</td><td>' + user.association + '</td><td>' + rating.criterianame + ': ' + rating.rating_value + '</td><td>' + rating.numberofraters + '</td></tr>');
                            });
                        });
                        usersTable.append('<tr><td colspan="6"><a onclick= window.location.reload()>Reset</a></td></tr>');

                    } else {
                        usersTable.append('<tr><td colspan="6">No users found</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    usersTable.append('<tr><td colspan="6">Error fetching users</td></tr>');
                }
            });
        });

        var navLinks = document.getElementsByClassName('nav-link');
        for (var i = 0; i < navLinks.length; i++) {
            navLinks[i].addEventListener('click', function() {
                var usersTable = $('#usertable');
                usersTable.empty();
            });
        }
    </script>

</body>

</html>