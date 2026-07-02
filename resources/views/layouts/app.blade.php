<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>CurhaTI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

@vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body>

<nav class="navbar navbar-curhati">
    <div class="container">

        <a href="/" class="logo">
            <span class="logo-cur">Curha</span><span class="logo-ti">TI</span>
        </a>

        <div>
            @guest
                <a href="/login" class="btn btn-primary">
                    <i class="bi bi-person"></i>
                    Login
                </a>
            @endguest

            @auth
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf

                    <button class="btn btn-light">
                        Logout
                    </button>
                </form>
            @endauth
        </div>

    </div>
</nav>

<div class="container mt-4 mb-5 pb-5">
    <div class="page-container">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    toast:true,
    position:'top-end',
    icon:'success',
    title:'{{ session("success") }}',
    showConfirmButton:false,
    timer:1800,
    timerProgressBar:true,
    width:'320px',
    background:'#ffffff',
    color:'#0F172A',
    customClass:{
        popup:'rounded-4 shadow-sm'
    }
})
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    toast:true,
    position:'top-end',
    icon:'error',
    title:'Oops 😥',
    text:'{{ session("error") }}',
    showConfirmButton:false,
    timer:2200,
    timerProgressBar:true,
    width:'320px',
    background:'#ffffff',
    color:'#0F172A',
    customClass:{
        popup:'rounded-4 shadow-sm'
    }
})
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon:'error',
    title:'Posting gagal',
    text:'{{ $errors->first() }}',
    confirmButtonColor:'#2563EB',
    background:'#ffffff',
    color:'#0F172A',
    customClass:{
        popup:'rounded-4 shadow-sm'
    }
})
</script>
@endif

<script>
function loginRequired(){
    Swal.fire({
        icon:'info',
        title:'Login dulu ya ✨',
        text:'Biar bisa posting, komentar, dan kasih reaksi.',
        confirmButtonText:'Login',
        confirmButtonColor:'#2563EB',
        showCancelButton:true,
        cancelButtonText:'Nanti dulu'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = '/login';
        }
    })
}
</script>

@guest
<button class="fab-post" onclick="loginRequired()">
    <i class="bi bi-pencil-square"></i>
</button>
@endguest

@auth
<button class="fab-post" data-bs-toggle="modal" data-bs-target="#postModal">
    <i class="bi bi-pencil-square"></i>
</button>
@endauth

@auth
<div class="modal fade" id="postModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4 shadow-lg">

            <div class="modal-body p-4">

                <div class="mb-4">
                    <div class="modal-intro-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>

                    <h4 class="fw-bold mb-2">
                        Bagikan Aspirasimu
                    </h4>

                    <p class="text-muted mb-0">
                        Postinganmu akan tampil anonim di CurhaTI dan identitasmu tetap tersembunyi.
                    </p>
                </div>

                <form method="POST" action="/post" enctype="multipart/form-data">
                    @csrf

                    <label class="form-label fw-semibold">
                        Kategori
                    </label>

                    <select name="category_id" class="form-select mb-3" required>
                        <option value="">
                            Pilih kategori
                        </option>

                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->nama }}
                            </option>
                        @endforeach
                    </select>

                    <label class="form-label fw-semibold">
                        Isi Aspirasi
                    </label>

                    <textarea
                        name="isi"
                        class="form-control"
                        rows="5"
                        placeholder="Tulis keresahan, saran, kritik, atau aspirasimu di sini..."
                        required></textarea>

                    <div class="mt-3">
                        <label class="form-label fw-semibold">
                            Tambahkan Gambar
                            <span class="text-muted fw-normal">(opsional)</span>
                        </label>

                        <input
                            type="file"
                            name="gambar"
                            accept="image/*"
                            class="form-control">
                    </div>

                    <div class="mt-3 p-3 rounded-4" style="background:#EFF6FF;color:#2563EB;font-size:14px;">
                        <i class="bi bi-shield-check"></i>
                        Identitas kamu tetap anonim.
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary flex-fill">
                            Kirim
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Log clicks on any collapse toggle elements
    document.addEventListener('click', function (e) {
        var toggle = e.target.closest('[data-bs-toggle="collapse"]');
        if (toggle) {
            console.log('[debug] collapse toggle clicked:', toggle, e);
        }
    }, true);

    // Attach Bootstrap collapse lifecycle logging
    var els = document.querySelectorAll('.collapse');
    els.forEach(function (el) {
        el.addEventListener('show.bs.collapse', function () { console.log('[debug] show', el.id); });
        el.addEventListener('shown.bs.collapse', function () { console.log('[debug] shown', el.id); });
        el.addEventListener('hide.bs.collapse', function () { console.log('[debug] hide', el.id); });
        el.addEventListener('hidden.bs.collapse', function () { console.log('[debug] hidden', el.id); });
    });
});
</script>

</body>
</html>