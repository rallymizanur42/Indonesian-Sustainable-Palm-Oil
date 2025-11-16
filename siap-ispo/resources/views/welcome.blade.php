<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISPO - Indonesian Sustainable Palm Oil</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c7c3d;
            --secondary-color: #f5a623;
            --light-bg: #f8fafc;
            --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            --footer-bg: #1a3e23;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light-bg);
            line-height: 1.6;
            color: #333;
        }
        
        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .nav-link, .dropdown-item {
            font-weight: 500;
            color: #555 !important;
            transition: all 0.3s ease;
        }
        
        .nav-link {
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
        }

        .nav-link.active, .nav-link:hover {
            color: white !important;
            background: var(--primary-color);
            transform: translateY(-2px);
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white !important;
        }
        
        /* Full-screen Sections */
        .fullscreen-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 5rem 0;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('https://images.unsplash.com/photo-1605000797499-95a51c5269ae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            position: relative;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            max-width: 600px;
            margin: auto;
            animation: fadeInUp 1s ease 0.2s both;
        }
        
        .section-title {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
            animation: expand 0.8s ease;
        }
        
        .section-dark {
            background: #f5f5f5;
        }
        
        .feature-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }
        
        .feature-card:hover {
            transform: translateY(-5px) !important;
            box-shadow: var(--hover-shadow);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }
        
        .footer {
            background: var(--footer-bg);
            color: white;
            padding: 3rem 0 1.5rem;
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 1.5rem;
            margin-top: 2rem;
            color: rgba(255,255,255,0.6);
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes expand {
            from {
                width: 0;
            }
            to {
                width: 50px;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .fullscreen-section {
                padding: 3rem 0;
            }
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-leaf me-2"></i> ISPO
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#home">
                                <i class="fas fa-home me-1"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">
                                <i class="fas fa-info-circle me-1"></i> Tentang ISPO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#benefits">
                                <i class="fas fa-star me-1"></i> Manfaat
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#features">
                                <i class="fas fa-cogs me-1"></i> Fitur
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="fullscreen-section hero-section" id="home">
        <div class="container hero-content">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="hero-title display-3">Indonesian Sustainable Palm Oil</h1>
                    <p class="hero-subtitle lead">
                        Sistem sertifikasi nasional untuk memastikan pengelolaan kelapa sawit yang berkelanjutan dan ramah lingkungan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="fullscreen-section section" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Apa Itu ISPO?</h2>
                    <p>ISPO (Indonesian Sustainable Palm Oil) adalah standar sertifikasi nasional untuk memastikan pengelolaan kelapa sawit yang berkelanjutan, ramah lingkungan, dan mematuhi peraturan Indonesia.</p>
                    <p>Sertifikasi ini bertujuan meningkatkan daya saing minyak sawit Indonesia di pasar global sekaligus menjamin praktik budidaya yang bertanggung jawab.</p>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0 text-center">
                    <img src="https://www.infosawit.com/wp-content/uploads/2023/10/kebun-sawit-masjid.jpg" 
                             alt="Palm Oil Plantation" 
                             class="img-fluid rounded shadow animate__animated animate__fadeInRight">
                </div>
            </div>
        </div>
    </section>

    <section class="fullscreen-section section section-dark" id="benefits">
        <div class="container">
            <h2 class="section-title text-center mb-5 mx-auto">Manfaat ISPO</h2>
            
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                        <h4>Pasar Global</h4>
                        <p>Meningkatkan daya saing minyak sawit Indonesia di pasar internasional.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tree"></i>
                        </div>
                        <h4>Lingkungan</h4>
                        <p>Memastikan praktik budidaya yang ramah lingkungan dan berkelanjutan.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <h4>Ekonomi</h4>
                        <p>Meningkatkan nilai tambah produk kelapa sawit Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fullscreen-section section" id="features">
        <div class="container">
            <h2 class="section-title text-center mb-5 mx-auto">Fitur Sistem Kami</h2>
            
            <div class="row text-center">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>Decision Support System</h4>
                        <p>Sistem pendukung keputusan untuk evaluasi sertifikasi ISPO.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h4>Sistem Pemetaan</h4>
                        <p>Visualisasi geografis perkebunan kelapa sawit bersertifikat.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <h4>Riwayat</h4>
                        <p>Riwayat dengan chart setiap perkembangan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fullscreen-section text-white" id="cta" style="background: url(https://images.pexels.com/photos/4210380/pexels-photo-4210380.jpeg)">
        <div class="container text-center">
            <h2 class="mb-4">Siap Memulai Sertifikasi ISPO?</h2>
            <a href="/login" class="btn btn-light btn-lg px-4">
                <i class="fas fa-sign-in-alt me-2"></i> Login Sekarang
            </a>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-leaf me-2"></i> ISPO</h5>
                    <p class="mt-3">Sistem sertifikasi nasional untuk memastikan pengelolaan kelapa sawit yang berkelanjutan dan ramah lingkungan.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Beranda</a></li>
                        <li class="mb-2"><a href="#about">Tentang</a></li>
                        <li class="mb-2"><a href="#benefits">Manfaat</a></li>
                        <li class="mb-2"><a href="#features">Fitur</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Layanan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Decision Support System</a></li>
                        <li class="mb-2"><a href="#">Pemetaan</a></li>
                        <li class="mb-2"><a href="#">Riwayat</a></li>
                        <li class="mb-2"><a href="#cta">Login</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jakarta, Indonesia</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +62 123 4567 890</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@ispo-indonesia.id</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom text-center">
                <p>&copy; 2023 Indonesian Sustainable Palm Oil. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Active nav link on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('.fullscreen-section');

            const options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.5
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            const href = link.getAttribute('href')?.substring(1);
                            if (href === entry.target.id) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }, options);

            sections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>
</body>
</html>