<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>Login - CurhaTI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<style>

*{
    font-family:'Outfit',sans-serif;
}

body{
    min-height:100vh;
    background:#F8FAFC;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:20px;
}

.login-card{

    width:100%;
    max-width:420px;

    background:white;

    border:none;
    border-radius:24px;

    padding:35px;

    box-shadow:
        0 10px 30px rgba(15,23,42,.08);
}

.logo{

    text-align:center;

    font-size:34px;
    font-weight:800;

    color:#0F172A;

    margin-bottom:8px;
}

.logo span{
    color:#2563EB;
}

.subtitle{

    text-align:center;

    color:#64748B;

    font-size:14px;

    margin-bottom:28px;
}

.form-label{

    font-size:14px;
    font-weight:600;

    color:#334155;
}

.form-control{

    height:52px;

    border-radius:14px;

    border:1px solid #CBD5E1;
}

.form-control:focus{

    box-shadow:none;

    border-color:#2563EB;
}

.btn-login{

    height:52px;

    border:none;

    border-radius:14px;

    background:#2563EB;

    color:white;

    font-weight:600;

    width:100%;
}

.btn-login:hover{

    background:#1D4ED8;
}

.login-note{

    margin-top:20px;

    text-align:center;

    font-size:13px;

    color:#64748B;

    line-height:1.7;
}

.alert-danger{

    border:none;

    border-radius:14px;
}

</style>

</head>

<body>

<div class="login-card">

    <div class="logo">

        CURHA<span>TI</span>

    </div>

    <div class="subtitle">

        Platform aspirasi anonim mahasiswa Teknologi Informasi Unimus

    </div>

    @if($errors->any())

    <div class="alert alert-danger">

        NIM atau password yang kamu masukkan tidak sesuai.

    </div>

    @endif

    <form method="POST"
          action="{{ route('login') }}">

        @csrf

        <div class="mb-3">

            <label class="form-label">

                NIM

            </label>

            <input
            type="text"
            name="nim"
            value="{{ old('nim') }}"
            class="form-control"
            placeholder="Contoh: 13242420021"
            required
            autofocus>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Password

            </label>

            <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Masukkan password"
            required>

        </div>

        <button
        type="submit"
        class="btn-login">

            Masuk

        </button>

    </form>

    <div class="login-note">

        Hanya untuk mahasiswa <b>Teknologi Informasi Universitas Muhammadiyah Semarang</b> yang telah terdaftar oleh admin.

    </div>

</div>

</body>

</html>