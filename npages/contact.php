<?php
session_start();
require_once '../config/constants.php';
require_once '../includes/head.php';
require_once '../includes/navbar.php';
require_once '../config/database.php';
require_once '../includes/mailer.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['otp_code'])) {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mobile = trim($_POST['mobile'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $user_otp = trim($_POST['otp_code']);
        $sess_otp = $_SESSION['contact_otp'] ?? '';
        
        if ($user_otp != $sess_otp) {
            $msg = "<div class='alert alert-danger'>Invalid OTP. Please verify your email again.</div>";
        } elseif (empty($name) || empty($email) || empty($message)) {
            $msg = "<div class='alert alert-warning'>Please fill in all required fields.</div>";
        } else {
            try {
                // 1. Save to Database
                $stmt = $conn->prepare("INSERT INTO contact_queries (name, email, mobile, subject, message) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $mobile, $subject, $message]);
                
                // 2. Send Confirmation Email to User
                $confirmSubject = "We received your message - S.B. Syscon";
                $confirmBody = "Dear $name,<br><br>Thank you for contacting S.B. Syscon.<br><br>We have received your message regarding '$subject'. Our team will review your query and get back to you shortly.<br><br><strong>Your Details:</strong><br>Mobile: $mobile<br>Email: $email<br><br>Best Regards,<br>S.B. Syscon Team<br>www.sbsyscon.in";
                sendMail($email, $confirmSubject, $confirmBody); 

                // 3. Send Notification Email to Admin
                $adminEmail = SITE_EMAIL;
                $adminSubject = "New Inquiry: $subject - from $name";
                $adminBody = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; border: 1px solid #eee; padding: 20px;'>
                    <h2 style='color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px;'>New Contact Inquiry</h2>
                    <p>You have received a new message through the website contact form.</p>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr><td style='padding:10px; background:#f9f9f9; border-bottom:1px solid #eee;'><strong>Name:</strong></td><td style='padding:10px; border-bottom:1px solid #eee;'>$name</td></tr>
                        <tr><td style='padding:10px; background:#f9f9f9; border-bottom:1px solid #eee;'><strong>Email:</strong></td><td style='padding:10px; border-bottom:1px solid #eee;'>$email</td></tr>
                        <tr><td style='padding:10px; background:#f9f9f9; border-bottom:1px solid #eee;'><strong>Mobile:</strong></td><td style='padding:10px; border-bottom:1px solid #eee;'>$mobile</td></tr>
                        <tr><td style='padding:10px; background:#f9f9f9; border-bottom:1px solid #eee;'><strong>Subject:</strong></td><td style='padding:10px; border-bottom:1px solid #eee;'>$subject</td></tr>
                    </table>
                    <div style='margin-top: 20px; padding: 15px; background: #fdfdfd; border-left: 4px solid #dc3545;'>
                        <strong>Message:</strong><br>".nl2br(htmlspecialchars($message))."
                    </div>
                </div>";
                sendMail($adminEmail, $adminSubject, $adminBody); 
                
                $msg = "<div class='alert alert-success bg-transparent text-success border border-success'>Thank you, $name! Your message has been sent successfully.</div>";
                
                // Clear Session
                unset($_SESSION['contact_otp']);
                unset($_SESSION['otp_verified']);
            } catch(Exception $e) {
                $msg = "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
        }
    }
}
?>

<!-- AOS Animation CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/contact.css">

<!-- Hero Section -->
<div class="contact-hero-dark text-center">
    <div class="container" data-aos="zoom-in">
        <p class="hero-subtitle">GET IN TOUCH</p>
        <h1 class="hero-title-large"><span class="animate-highlight">Contact Us</span></h1>
    </div>
</div>

<!-- Main Contact Section -->
<div class="container contact-container">
    <div class="glass-panel" data-aos="fade-up">
        
        <!-- LEFT SIDE: Contact Info -->
        <div class="info-side">
            <h3 class="form-heading">Reach Out</h3>
            
            <div class="contact-item">
                <div class="icon-box">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="text-white">
                    <h5 class="fw-bold mb-1">Our Headquarters</h5>
                    <p class="text-white-50 mb-0 small">ID-45A, NIT Faridabad<br>Haryana, India - 121001</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="icon-box">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="text-white">
                    <h5 class="fw-bold mb-1">Email Us</h5>
                    <p class="text-white-50 mb-0 small">info@sbsyscon.in</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="icon-box">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="text-white">
                    <h5 class="fw-bold mb-1">Call Us</h5>
                    <p class="text-white-50 mb-0 small">+91 129 4150555<br>+91 9899598900</p>
                </div>
            </div>

            <!-- Mini Map -->
            <div class="map-wrapper mt-4">
                 <iframe 
                    width="100%" 
                    height="100%" 
                    id="gmap_canvas" 
                    src="https://maps.google.com/maps?q=S%20B%20SYSCON%20PVT%20LTD%20Faridabad&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                    frameborder="0" 
                    scrolling="no" 
                    marginheight="0" 
                    marginwidth="0">
                </iframe>
            </div>
        </div>

        <!-- RIGHT SIDE: Contact Form -->
        <div class="form-side">
            <h3 class="form-heading">Send Message</h3>
            <?php echo $msg; ?>
            
            <form method="POST" action="contact.php" id="contactForm">
                <div class="row">
                    <div class="col-md-6">
                        <label class="dark-label">Name</label>
                        <input type="text" name="name" class="dark-input" placeholder="John Doe" required>
                    </div>
                    <div class="col-md-6">
                        <label class="dark-label">Mobile Number</label>
                        <input type="tel" name="mobile" class="dark-input" placeholder="+91 9876543210" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="dark-label">Email</label>
                        <div class="input-group mb-3">
                            <input type="email" name="email" id="emailInput" class="dark-input" placeholder="john@example.com" style="border-top-right-radius: 0; border-bottom-right-radius: 0; margin-bottom: 0;" required>
                            <button type="button" class="btn btn-outline-danger" id="sendOtpBtn" style="border-top-right-radius: 12px; border-bottom-right-radius: 12px; border: 1px solid #333; height: 58px;">Verify</button>
                        </div>
                        <small id="otpHelp" class="text-warning" style="display:none; margin-top: -15px; margin-bottom: 10px; display: block;">Click 'Verify' to receive OTP.</small>
                    </div>
                </div>
                
                <!-- Hidden OTP Field -->
                <div id="otpSection" style="display:none;">
                    <label class="dark-label">Enter OTP</label>
                    <div class="input-group mb-3">
                        <input type="text" name="otp_code" id="otpInput" class="dark-input" placeholder="Enter 6-digit code" style="border-top-right-radius: 0; border-bottom-right-radius: 0; margin-bottom: 0;">
                        <button type="button" class="btn btn-outline-success" id="verifyOtpBtn" style="border-top-right-radius: 12px; border-bottom-right-radius: 12px; border: 1px solid #333; height: 58px;">Verify OTP</button>
                    </div>
                    <small id="otpVerifyMsg" class="mb-3 d-block"></small>
                </div>

                <label class="dark-label">Subject</label>
                <input type="text" name="subject" class="dark-input" placeholder="Project Inquiry" value="<?php echo isset($_GET['product']) ? 'Inquiry about '.htmlspecialchars($_GET['product']) : ''; ?>">
                
                <label class="dark-label">Message</label>
                <textarea name="message" class="dark-input" rows="4" placeholder="How can we assist you?" required></textarea>
                
                <button type="submit" class="btn-submit-dark" id="submitBtn" disabled>
                    <span>Send Message</span> <i class="fas fa-paper-plane ms-2"></i>
                </button>
            </form>
        </div>

    </div>
</div>

<script>
// Send OTP Logic
document.getElementById('sendOtpBtn').addEventListener('click', function() {
    const email = document.getElementById('emailInput').value;
    const btn = this;
    const msg = document.getElementById('otpHelp');
    
    if(email && email.includes('@')) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;
        
        fetch('send_otp.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'email=' + encodeURIComponent(email)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                btn.innerHTML = 'Sent';
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-success');
                // Show OTP Field
                document.getElementById('otpSection').style.display = 'block';
                msg.innerText = "OTP Sent to " + email;
                msg.classList.remove('text-warning');
                msg.classList.add('text-success');
            } else {
                btn.innerHTML = 'Retry';
                btn.disabled = false;
                msg.innerText = data.message;
                msg.classList.add('text-danger');
            }
        })
        .catch(err => {
            btn.innerHTML = 'Error';
            btn.disabled = false;
            console.error(err);
        });
    } else {
        alert("Please enter a valid email first.");
    }
});

// Verify OTP Logic
document.getElementById('verifyOtpBtn').addEventListener('click', function() {
    const otp = document.getElementById('otpInput').value;
    const btn = this;
    const msg = document.getElementById('otpVerifyMsg');
    const submitBtn = document.getElementById('submitBtn');
    
    if(otp.length >= 4) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch('verify_otp.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'otp=' + encodeURIComponent(otp)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                btn.innerHTML = '<i class="fas fa-check"></i> Verified';
                btn.classList.remove('btn-outline-success');
                btn.classList.add('btn-success');
                btn.disabled = true;
                document.getElementById('otpInput').readOnly = true;
                
                msg.innerText = data.message;
                msg.className = "text-success mb-3 d-block small";
                
                // ENABLE SUBMIT BUTTON
                submitBtn.disabled = false;
            } else {
                btn.innerHTML = 'Verify OTP';
                msg.innerText = data.message;
                msg.className = "text-danger mb-3 d-block small";
            }
        })
        .catch(err => {
            btn.innerHTML = 'Retry';
            console.error(err);
        });
    } else {
        alert("Please enter the OTP first.");
    }
});
</script>



<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>

<?php require_once '../includes/footer.php'; ?>
