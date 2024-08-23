<!-- process_donation.php -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $donor_name = $_POST['donor_name'];
    $donor_email = $_POST['donor_email'];

    // Here you would typically insert the donation information into a database
    // and perhaps send a confirmation email to the donor.

    // Redirect to a thank-you page or echo a success message
    echo "Thank you for your donation of $amount, $donor_name!";
    // Optionally, you can return a JSON response for AJAX handling
    // echo json_encode(['status' => 'success', 'message' => 'Thank you for your donation!']);
} else {
    // If someone tries to access this page directly, redirect them
    header('Location: index.php');
}
?>
