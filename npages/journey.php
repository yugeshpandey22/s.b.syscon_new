<?php
require_once '../includes/head.php';
require_once '../includes/navbar.php';
?>

<!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<!-- Vanila Tilt -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>

<link rel="stylesheet" href="../assets/css/journey.css">

<!-- Hero Section -->
<div class="journey-hero">
    <div class="hero-content">
        <h1 class="animate-slide-up">Our Journey</h1>
        <p class="animate-slide-up" style="animation-delay: 0.2s;">A Legacy of Innovation & Excellence Since 1992</p>
    </div>
</div>

<section class="journey-section">
    <div class="container timeline-container">
        <!-- Main Scroll Line -->
        <div class="timeline-line">
            <div class="timeline-line-fill" id="drawingLine"></div>
        </div>

        <?php
        $milestones = [
            ["year" => "1992", "text" => "Company established by a Graduate Engineer & Entrepreneur - Mr. R. P. Pandey."],
            ["year" => "1993", "text" => "Appointed as Channel Partner for Standard Company."],
            ["year" => "1995", "text" => "Appointed as Channel Partner for AEI - NGEF Company."],
            ["year" => "1999", "text" => "Started a Panel Manufacturing Unit in Faridabad."],
            ["year" => "2000", "text" => "Appointed as Channel Partner for GE."],
            ["year" => "2001", "text" => "Appointed as Channel Partner for Siemens."],
            ["year" => "2004", "text" => "Shifted focus solely to Trading & Distribution."],
            ["year" => "2005", "text" => "Became the 2nd Largest All-India by Volume for GE."],
            ["year" => "2006", "text" => "Broke the Barrier of 100 Million Revenue."],
            ["year" => "2007", "text" => "Reached milestone of 3,000 satisfied customers."],
            ["year" => "2008", "text" => "Became Biggest in North India for Siemens LV Switchgear."],
            ["year" => "2009", "text" => "Incorporated S.B. Syscon Pvt. Ltd. and moved to a 10,000+ sqft warehouse."],
            ["year" => "2010", "text" => "Achieved ISO Certification for Quality, Process, and Management."],
            ["year" => "2011", "text" => "Entered the LV Motors & Gearboxes industry."],
            ["year" => "2012", "text" => "Opened Western Region Office in Mumbai."],
            ["year" => "2013", "text" => "Recognized as an Export House after gaining IEC."],
            ["year" => "2014", "text" => "Broke 250 Million Revenue mark & workforce diversity reached 40% women."],
            ["year" => "2015", "text" => "Became ASCO Channel Partner."],
            ["year" => "2016", "text" => "Appointed as Havells Channel Partner."],
            ["year" => "2017", "text" => "Appointed as LAPP Channel Partner."],
            ["year" => "2018", "text" => "Established Centralized Warehouse in Faridabad as per GST norms."],
            ["year" => "2019", "text" => "Crossed 500 Million Revenue."],
            ["year" => "2020", "text" => "Launched SB Smart — Online B2B Portal for Omni-channel Sales."],
            ["year" => "2021", "text" => "Established Export BU with regular exports to 5 continents."],
            ["year" => "2022", "text" => "Top 3 finalist for MSME of the Year Award by Economic Times."],
            ["year" => "2023", "text" => "Started Special Purpose Machine manufacturing & Achieved 75% Green Fuel Delivery."],
            ["year" => "2024", "text" => "Reached 1000 Million Revenue milestone (₹100 Cr)."],
            ["year" => "2025", "text" => "Projecting 1250 Million Revenue (₹125 Cr) with stakeholder support."]
        ];

        foreach($milestones as $index => $ms) {
            $aos = ($index % 2 == 0) ? "fade-right" : "fade-left";
            ?>
            <div class="timeline-row" data-aos="<?php echo $aos; ?>">
                <div class="timeline-content-wrapper">
                    <div class="timeline-card" data-tilt>
                        <!-- Moving Borders -->
                        <span></span><span></span><span></span><span></span>
                        
                        <div class="journey-year"><?php echo $ms['year']; ?></div>
                        <p class="journey-text"><?php echo $ms['text']; ?></p>
                    </div>
                </div>
                <div class="timeline-dot"></div>
            </div>
            <?php
        }
        ?>

    </div>
</section>

<!-- AOS Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        offset: 100,
        once: false, // Re-animate on scroll up too
        mirror: true
    });

    // 3D Tilt Init
    VanillaTilt.init(document.querySelectorAll(".timeline-card"), {
        max: 10,
        speed: 400,
        glare: true,
        "max-glare": 0.2
    });

    // Scroll Logic for Line & Dots
    const journeySection = document.querySelector('.journey-section');
    const drawLine = document.getElementById('drawingLine');
    const rows = document.querySelectorAll('.timeline-row');

    window.addEventListener('scroll', () => {
        const sectionTop = journeySection.offsetTop;
        const sectionHeight = journeySection.offsetHeight;
        const scrollPos = window.scrollY + (window.innerHeight / 2); // Trigger point center screen

        // 1. Line Progress
        if (scrollPos > sectionTop) {
            const progress = ((scrollPos - sectionTop) / sectionHeight) * 100;
            drawLine.style.height = `${Math.min(progress, 100)}%`;
        }

        // 2. Active Dots
        rows.forEach(row => {
            const rowTop = row.offsetTop + sectionTop;
            if (scrollPos > rowTop) {
                row.classList.add('active');
            } else {
                row.classList.remove('active');
            }
        });
    });
</script>

<?php require_once '../includes/footer.php'; ?>
