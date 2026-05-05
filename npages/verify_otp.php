<?php
// verify_otp.php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_otp = trim($_POST['otp'] ?? '');
    $sess_otp = $_SESSION['contact_otp'] ?? '';
    
    if (!empty($sess_otp) && $user_otp == $sess_otp) {
        $_SESSION['otp_verified'] = true;
        echo json_encode(['success' => true, 'message' => 'OTP Verified successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
