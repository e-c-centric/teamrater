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
    <link rel="stylesheet" type="text/css" href="../css/starability-basic.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="../js/modernizr-2.6.2.js"></script>
    <link rel="shortcut icon" href="../img/teamraterlogo.png">



    <script src="../js/respond.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>

</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container body-content">


        <div class="row">
            <div class="col-md-10">
                <h2>Rate Your Teammate</h2>
                <hr />
                <form class="form-inline" action="" method="post">
                    <input id="csrf_token" name="csrf_token" type="hidden" value="ImRiZDVjYjdjYmIzYjE3YjlhOTRlMTZlOTk4ODEwY2I4MWI0MTllMGIi.ZhKcdw.gBOPajm_v_rg0oAxDMfBNI6b5Cg">

                    <table class="table table-striped table-bordered">
                        <tr>
                            <td><strong>Teammate's First Name:</strong></td>
                            <td class="text-center">
                                <input class="form-control" id="firstname" name="firstname" required="required" type="text" value="">

                            </td>
                        </tr>
                        <tr>
                            <td><strong>Teammate's Last Name:</strong></td>
                            <td class="text-center">
                                <input class="form-control" id="lastname" name="lastname" required="required" type="text">

                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-6">
                                <strong>1. How would you rate this Teammate's ability to explain concepts clearly?</strong>
                            </td>
                            <td class="col-md-6">

                                <fieldset class="starability-basic text-center">

                                    <input type="radio" id="q1no-rate-basic" class="input-no-rate" name="q1" value="0" checked aria-label="No rating." required />


                                    <input id="q1-0" name="q1" type="radio" value="1">
                                    <label for="q1-0">one</label>

                                    <input id="q1-1" name="q1" type="radio" value="2">
                                    <label for="q1-1">two</label>

                                    <input id="q1-2" name="q1" type="radio" value="3">
                                    <label for="q1-2">three</label>

                                    <input id="q1-3" name="q1" type="radio" value="4">
                                    <label for="q1-3">four</label>

                                    <input id="q1-4" name="q1" type="radio" value="5">
                                    <label for="q1-4">five</label>


                                    <span class="starability-focus-ring"></span>
                                </fieldset>
                                <br />

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>2. How would you rate this Teammate's style of teaching?</strong>
                            </td>
                            <td class="col-md-6 text-center">

                                <fieldset class="starability-basic">

                                    <input type="radio" id="q2no-rate-basic" class="input-no-rate" name="q2" value="0" checked aria-label="No rating." required />


                                    <input id="q2-0" name="q2" type="radio" value="1">
                                    <label for="q2-0">one</label>

                                    <input id="q2-1" name="q2" type="radio" value="2">
                                    <label for="q2-1">two</label>

                                    <input id="q2-2" name="q2" type="radio" value="3">
                                    <label for="q2-2">three</label>

                                    <input id="q2-3" name="q2" type="radio" value="4">
                                    <label for="q2-3">four</label>

                                    <input id="q2-4" name="q2" type="radio" value="5">
                                    <label for="q2-4">five</label>


                                    <span class="starability-focus-ring"></span>
                                </fieldset>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>3. Was this Teammate easily understandable with regard to voice, tone, and pronunciation?</strong>
                            </td>
                            <td class="col-md-6 text-center">

                                <fieldset class="starability-basic">

                                    <input type="radio" id="q3no-rate-basic" class="input-no-rate" name="q3" value="0" checked aria-label="No rating." required />


                                    <input id="q3-0" name="q3" type="radio" value="1">
                                    <label for="q3-0">one</label>

                                    <input id="q3-1" name="q3" type="radio" value="2">
                                    <label for="q3-1">two</label>

                                    <input id="q3-2" name="q3" type="radio" value="3">
                                    <label for="q3-2">three</label>

                                    <input id="q3-3" name="q3" type="radio" value="4">
                                    <label for="q3-3">four</label>

                                    <input id="q3-4" name="q3" type="radio" value="5">
                                    <label for="q3-4">five</label>


                                    <span class="starability-focus-ring"></span>
                                </fieldset>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>7. How would you rate the Teammate's review for exams?</strong>
                            </td>
                            <td class="col-md-6 text-center">

                                <fieldset class="starability-basic">

                                    <input type="radio" id="q7no-rate-basic" class="input-no-rate" name="q7" value="0" checked aria-label="No rating." required />


                                    <input id="q7-0" name="q7" type="radio" value="1">
                                    <label for="q7-0">one</label>

                                    <input id="q7-1" name="q7" type="radio" value="2">
                                    <label for="q7-1">two</label>

                                    <input id="q7-2" name="q7" type="radio" value="3">
                                    <label for="q7-2">three</label>

                                    <input id="q7-3" name="q7" type="radio" value="4">
                                    <label for="q7-3">four</label>

                                    <input id="q7-4" name="q7" type="radio" value="5">
                                    <label for="q7-4">five</label>


                                    <span class="starability-focus-ring"></span>
                                </fieldset>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>8. Would you recommend this Teammate?</strong>
                            </td>
                            <td class="col-md-6 text-center">
                                <select class="form-control" id="q8" name="q8" required="required">
                                    <option value="0">-- Select your Recommendation --</option>
                                    <option value="24">Absolutely Yes!</option>
                                    <option value="25">Yes</option>
                                    <option value="26">Only if you have no choice</option>
                                    <option value="27">Never</option>
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>9. Comments or suggestions for others considering this Teammate?</strong><br />
                                <blockquote>
                                    <p><samp><textarea class="form-control" cols="240" id="q9" name="q9" rows="6">
</textarea></samp></p>
                                </blockquote>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>10. Comments, suggestions, or feedback to our dev team regarding our site (This is for internal purposes and will not be published)?</strong><br />
                                <blockquote>
                                    <p><samp><textarea class="form-control" cols="240" id="q10" name="q10" rows="6">
</textarea></samp></p>
                                </blockquote>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input name="state" id="state" type="hidden" value="1" />
                                <input name="stateName" id="state" type="hidden" value="Alabama" />
                                <input name="school" id="school" type="hidden" value="1" />
                                <input name="schoolName" id="school" type="hidden" value="Alabama Agricultural and Mechanical University" />



                                <input class="btn btn-default btn-sm" id="submit" name="submit" type="submit" value="submit">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>


</body>

</html>