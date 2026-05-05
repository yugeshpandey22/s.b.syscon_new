<?php
// send_otp.php
session_start();
require_once '../includes/mailer.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Simple OTP Generation
        $otp = rand(100000, 999999);
        $_SESSION['contact_otp'] = $otp;
        $_SESSION['contact_email'] = $email;
        
        // 1. Try to send Real Email (Works on Hosting/Live Server)
        $subject = "Your Verification Code - S.B. Syscon";
        $message = "Your verification OTP is: $otp";
        
        $mailSent = sendMail($email, $subject, $message); 

        if ($mailSent) {
            echo json_encode([
                'success' => true, 
                'message' => 'OTP Sent! Please check your email.'
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Failed to send email. Please check SMTP settings or use localhost log.'
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
