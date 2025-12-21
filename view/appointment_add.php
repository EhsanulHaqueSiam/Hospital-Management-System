
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Appointment - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/validation-helpers.js"></script>
    <script src="../assets/js/validation-fields.js"></script>
    <script src="../assets/js/validation-patient.js"></script>
    <script src="../assets/js/validation-appointment.js"></script>
    <script src="../assets/js/validation-prescription.js"></script>
    <script src="../assets/js/validation-record.js"></script>
    <script src="../assets/js/validation-init.js"></script>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="#" class="navbar-link">Dashboard</a>
        <a href="#" class="navbar-link">My Profile</a>
        <a href="#" class="navbar-link" id="logout-btn">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <h2>Book New Appointment</h2>


        <!-- <div class="success-message">Appointment booked successfully! ID: APT202599</div> -->

        <form action="" method="POST" onsubmit="return validateAppointmentForm(this)">

            <fieldset>
                <legend>Appointment Details</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Patient:</td>
                        <td>

                            <select name="patient_id" required>
                                <option value="">-- Select Patient --</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Department:</td>
                        <td>
                            <select name="department" onchange="loadDoctors()" required>
                                <option value="">-- Select Department --</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Doctor:</td>
                        <td>

                            <select name="doctor_id" id="doctor-select" required>
                                <option value="">-- Select Department First --</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td><input type="date" name="appointment_date" required></td>
                    </tr>
                    <tr>
                        <td>Time Slot:</td>
                        <td>

                            <select name="time_slot" required>
                                <option value="">-- Select Date First --</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Type:</td>
                        <td>
                            <select name="type">
                                <option value="Consultation">Consultation</option>
                                <option value="Follow-up">Follow-up</option>
                                <option value="Emergency">Emergency</option>

                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Medical Info</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Symptoms:</td>
                        <td><textarea name="symptoms" rows="3" placeholder="Describe symptoms (optional)"></textarea>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <div>
                <button type="submit" name="book_appointment" class="button">Confirm Booking</button>
                <a href="appointment_list.php" class="button btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Logout Modal -->
    <div class="logout-modal" id="logout-modal">
        <div class="modal-content">
            <p>Are you sure you want to logout?</p>
            <br>
            <button id="confirm-logout">Yes</button>
            <button id="cancel-logout" class="btn-cancel">Cancel</button>
        </div>
    </div>


</body>

</html>
