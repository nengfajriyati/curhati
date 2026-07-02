@extends('layouts.app')

@section('content')

<div class="row align-items-center py-5">

    <div class="col-lg-6">

        <span class="badge bg-primary-subtle text-primary px-3 py-2 mb-3">

            Ruang Aspirasi Mahasiswa TI

        </span>

        <h1 class="fw-bold mb-4"
            style="font-size:58px;line-height:1.1">

            Ada yang ingin<br>
            disampaikan?

        </h1>

        <p class="text-secondary mb-4"
           style="font-size:18px;line-height:1.8">

            CurhaTI adalah tempat untuk berbagi cerita,
            kritik, saran, maupun aspirasi secara anonim.
            Sampaikan pendapatmu dengan nyaman tanpa
            khawatir identitasmu diketahui pengguna lain.

        </p>

        <div class="d-flex gap-3 flex-wrap">

            <a href="/login"
               class="btn btn-primary btn-lg px-4">

                Mulai Sekarang

            </a>

            <a href="#feed"
               class="btn btn-outline-primary btn-lg px-4">

                Lihat Curhatan

            </a>

        </div>

    </div>

    <div class="col-lg-6 mt-5 mt-lg-0">

        <div class="card shadow-lg border-0">

            <div class="card-body p-4">

                <div class="anonymous">

                    Anonymous

                </div>

                <p class="mt-4 mb-3"
                   style="line-height:1.8">

                    Menurut saya fasilitas laboratorium
                    perlu ditingkatkan agar praktikum
                    lebih maksimal dan nyaman digunakan
                    mahasiswa.

                </p>

                <hr>

                <div class="d-flex justify-content-between text-secondary">

                    <span>❤️ 24 Suka</span>

                    <span>💬 8 Komentar</span>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row text-center my-5">

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm">

            <div class="card-body py-4">

                <h2 class="fw-bold text-primary">

                    {{ count($posts) }}+

                </h2>

                <p class="text-muted mb-0">

                    Curhatan Dibagikan

                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm">

            <div class="card-body py-4">

                <h2 class="fw-bold text-primary">

                    100%

                </h2>

                <p class="text-muted mb-0">

                    Anonim

                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4 mb-3">

        <div class="card shadow-sm">

            <div class="card-body py-4">

                <h2 class="fw-bold text-primary">

                    AI

                </h2>

                <p class="text-muted mb-0">

                    Moderation

                </p>

            </div>

        </div>

    </div>

</div>

<div id="feed">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="section-title mb-0">

            Lagi Ramai Dibahas 🔥

        </h2>

    </div>

    @forelse($posts as $post)

    <div class="card post-card shadow-sm mb-3">

        <div class="card-body">

            <div class="anonymous">

                Anonymous

            </div>

            <p class="mt-3 mb-3"
               style="line-height:1.8">

                {{ $post->isi }}

            </p>

            <div class="text-secondary small">

                ❤️ Reaksi • 💬 Komentar

            </div>

        </div>

    </div>

    @empty

    <div class="card shadow-sm">

        <div class="card-body text-center py-5">

            <h5 class="mb-2">

                Masih sepi nih 👀

            </h5>

            <p class="text-muted mb-0">

                Belum ada curhatan yang dibagikan.
                Jadi yang pertama buat cerita yuk.

            </p>

        </div>

    </div>

    @endforelse

</div>

<div class="text-center mt-5 pt-3">

    <small class="text-muted">

        CurhaTI © 2026 • Ruang Aman untuk Bersuara

    </small>

</div>

@endsection