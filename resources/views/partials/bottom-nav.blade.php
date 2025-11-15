<style>
    /* === Bottom Nav Modern === */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: #ffffff;
        border-top: 1px solid #e6e6e6;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 6px 0;
        z-index: 999;
        box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.06);
        border-radius: 16px 16px 0 0;
    }

    .bottom-nav a {
        text-decoration: none !important;
        color: #6c6c6c;
        font-size: 0.78rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: all 0.25s ease;
    }

    .bottom-nav a i {
        font-size: 1.35rem;
        margin-bottom: 2px;
        transition: all 0.25s ease;
    }

    /* ACTIVE NAV */
    .bottom-nav a.active {
        color: #d62828 !important; /* warna utama */
        font-weight: 600;
    }

    .bottom-nav a.active i {
        transform: scale(1.2);
        color: #d62828 !important;
    }

    /* Hover efek halus */
    .bottom-nav a:hover {
        color: #d62828;
    }

    .bottom-nav a:hover i {
        transform: scale(1.12);
    }
</style>



<div class="bottom-nav">

    {{-- BERANDA --}}
    <a href="{{ route('beranda.wisatawan') }}" 
       class="{{ ($active ?? '') == 'home' ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>Beranda</span>
    </a>

    {{-- PASAR DIGITAL --}}
    <a href="{{ route('marketplace.index') }}" 
       class="{{ ($active ?? '') == 'marketplace' ? 'active' : '' }}">
        <i class="fa-solid fa-bag-shopping"></i>
        <span>Pasar Digital</span>
    </a>

    {{-- PEMANDU WISATA --}}
    <a href="{{ route('pemandu-wisata.index') }}" 
       class="{{ ($active ?? '') == 'pemandu' ? 'active' : '' }}">
        <i class="fa-solid fa-bus"></i>
        <span>Pemandu Wisata</span>
    </a>

    {{-- AKUN --}}
    @auth
        <a href="{{ route('profile.show') }}" 
           class="{{ ($active ?? '') == 'akun' ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i>
            <span>Akun</span>
        </a>
    @else
        <a href="{{ route('login') }}" 
           class="{{ ($active ?? '') == 'akun' ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i>
            <span>Akun</span>
        </a>
    @endauth

</div>
