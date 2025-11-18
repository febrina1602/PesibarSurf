<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PesibarSurf | Jelajahi Pesona Lampung')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #ffffff;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh; 
            display: flex;
            flex-direction: column;
        }

        /* Konten utama akan mendorong footer ke bawah */
        .main-content {
            flex: 1;
        }

        h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        p { font-weight: 400; color: #555; }
        section { padding: 60px 0; text-align: center; }

        /* * SEMUA STYLE KHUSUS .auth-wrapper, .form-control, .btn-grad, dll.
         * TELAH DIHAPUS DARI SINI KARENA SUDAH ADA DI FILE LOGIN/REGISTER.
        */

        /* ================================================= */
        /* --- TAMBAHKAN STYLE UNTUK HEADER & BUTTON BARU --- */
        /* ================================================= */
        .header-gradient {
            /* Gradien baru: Atas Kuning (#FFE467) ke Bawah Pink (#FFDFCF) */
            background: linear-gradient(180deg, #FFE467, #FFDFCF);
            position: relative;
            overflow: hidden; /* Penting agar siger tidak bocor */
        }

        .siger-pattern-header {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            pointer-events: none;
            opacity: 0.15; /* Opacity agar menyatu */
        }

        /* Tombol Gradien Baru */
        .btn-pesibar-grad {
            background: linear-gradient(to right, #FFE75D, #D19878);
            border: none;
            color: #333; /* Teks gelap agar kontras */
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 24px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-pesibar-grad:hover {
            color: #000;
            filter: brightness(1.1); /* Sedikit lebih cerah saat hover */
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-custom { background-color: red; color: white; border-radius: 8px; padding: 8px 20px; font-weight: 600; border: none; text-decoration: none; transition: all 0.3s ease-in-out; box-shadow: 0 0 0 rgba(0, 0, 0, 0); }
        .btn-custom:hover { background-color: #cc0000; transform: scale(1.0); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); }
        
        /* NAVIGATION STYLES */
        .nav-custom { background-color: white; border-bottom: 1px solid #dee2e6; }
        .nav-link-custom { padding: 12px 8px; color: #333; text-decoration: none; font-weight: 600; border-bottom: 2px solid transparent; transition: all 0.3s ease; display: inline-block; }
        .nav-link-custom:hover { color: #dc3545; }
        .nav-link-custom.active { color: #dc3545; border-bottom-color: #dc3545; }
        
        /* CATEGORY SECTION STYLES */
        .category-section { background: linear-gradient(180deg, #FFE467, #FFDFCF); padding: 40px 0; }
        .category-card { background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 20px; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: all 0.3s ease; cursor: pointer; }
        .category-card:hover { box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); transform: translateY(-2px); }
        .category-icon { width: 64px; height: 64px; }

        /* HERO IMAGE STYLES */
        .hero-img { width: 100%; height: 400px; object-fit: cover; border-radius: 20px; transition: transform 0.5s ease, box-shadow 0.5s ease; }
        .hero-img:hover { transform: scale(1.02); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); }

        /* TYPING ANIMATION */
        .typing { display: inline-block; border-right: 3px solid #333; white-space: nowrap; overflow: hidden; animation: typing 3s steps(30, end), blink 0.75s step-end infinite; }
        @keyframes typing { from { width: 0 } to { width: 35% } }
        @keyframes blink { 50% { border-color: transparent } }
        
        /* FOOTER STYLES */
        .footer { background: linear-gradient(180deg, #FFE467, #FFDFCF); color: #000; position: relative; overflow: hidden; padding: 30px 0; flex-shrink: 0; }
        .footer a.footer-link { color: #000; text-decoration: none; }
        .footer a.footer-link:hover { text-decoration: underline; }
        .social-icons a {color: #000; font-size: inherit; text-decoration: none; margin-bottom: 0; transition: all 0.3s ease-in-out; }
        .social-icons a:hover { text-decoration: underline;  transform: none; color: #000;}
        .social-icons a i { margin-right: 8px; font-size: 16px; width: 20px; text-align: center}
        .siger-pattern { position: absolute; bottom: 0; left: 0; width: 100%; height: auto; pointer-events: none; }
        
        /* RESPONSIVE STYLES */
        @media (max-width: 768px) {
            .siger-pattern { opacity: 0.2; }
            header { padding: 15px 20px; }
            .nav-link-custom { font-size: 14px; padding: 10px 6px; }
        }

        /* =============================
        CSS KHUSUS HALAMAN MARKETPLACE
        ============================= */

        .app-wrapper {
            width: 100%;
            max-width: 100%;
            margin: 0;
            background: #f7f7f7;
            min-height: 100vh;
            position: relative;
        }
        .marketplace-header-img {
            height: 80px;
            border-radius: 0;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            position: relative;

            /* GRADIENT DASAR */
            background: linear-gradient(180deg, #FFE467, #FFDFCF);
        }

        /* Tambahkan pattern SIGER */
        .marketplace-header-img::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url('/images/siger-pattern.png');
            background-repeat: repeat-x;
            background-position: center bottom;
            background-size: 900px auto;
            /* sesuaikan besar kecilnya */
            opacity: 0.50;
            /* supaya samar seperti contoh */
            pointer-events: none;
        }

        .marketplace-title {
            font-weight: 700;
            font-size: 22px;
        }

        .marketplace-title span {
            font-size: 22px;
            font-weight: 700;
        }

        @media (max-width: 576px) {
            .modal-dialog.modal-xl, 
            .modal-dialog.modal-lg {
                margin: 0.5rem; /* Margin lebih tipis di HP */
            }
        }


        .marketplace-card {
            background-color: #fff;
            border-radius: 20px; /* Lebih bulat */
            border: none;
            /* Shadow halus */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        /* Efek Hover Kartu (Naik sedikit) */
        .marketplace-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Deskripsi teks */
        .marketplace-desc {
            font-size: 0.85rem;
            line-height: 1.5;
            color: #6c757d; /* Abu-abu lembut */
        }

        .btn-market {
            background-color: #d6181f;
            color: #fff;
            border-radius: 999px;
            font-size: 11px;
            padding: 6px 12px;
        }

        .btn-market:hover {
            background-color: #b51219;
            color: #fff;
        }

    </style>

    {{-- Ini adalah tempat style dari login/register akan dimasukkan --}}
    @stack('styles')
</head>
<body>
    
    <div class="main-content">
        @yield('content')
    </div>
    
    {{-- FOOTER --}}
    <footer class="footer position-relative">
        <div class="container py-3">
            <div class="row align-items-start">
                <div class="col-md-3 d-flex align-items-center mb-3 mb-md-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PesibarSurf" class="me-2" style="height:130px;">
                </div>

                <div class="col-md-3 text-start mb-3 mb-md-0">
                    <h6 class="fw-bold mb-2">Ikuti Kami</h6>
                    <div class="d-flex flex-column social-icons">
                        <p class="mb-1"><a href="mailto:pesibarsurf@gmail"><i class="fa fa-envelope"></i>pesibarsurf@gmail.com</a></p>
                        <p class="mb-1"><a href="https://www.instagram.com/pesibarsurf/"><i class="fab fa-instagram"></i>PesibarSurf</a></p>
                        <p class="mb-0"><a href="https://wa.me/62895344533797"><i class="fab fa-whatsapp"></i>+62 895-3445-33797</a></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-2">Informasi</h6>
                    <p class="mb-1"><a href="{{ route('tentang') }}" class="footer-link">Tentang</a></p>
                    <p class="mb-0"><a href="#" class="footer-link">Ulasan</a></p>
                </div>
            </div>

            <hr class="my-3" style="border-top: 1px solid rgba(0,0,0,0.2);">
            
            <div class="text-center small">
                <p class="mb-0">&copy; {{ date('Y') }} PesibarSurf. Hak Cipta Dilindungi.</p>
            </div>
        </div>
        </div>
        <img src="{{ asset('images/siger-pattern.png') }}" alt="Siger Pattern" class="siger-pattern" loading="lazy">
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    
</body>
</html>