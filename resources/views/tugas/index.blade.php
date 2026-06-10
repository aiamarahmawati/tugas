<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tugasku</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 600px">

  <!-- HEADER -->
  <div class="mb-4">
    <h1 class="fw-bold">📋 Tugasku</h1>
  </div>

  <!-- FORM TAMBAH TUGAS -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h6 class="text-muted text-uppercase fw-bold mb-3">Tambah Tugas Baru</h6>

      @if($errors->has('judul'))
        <div class="alert alert-danger py-2">⚠️ Judul tugas tidak boleh kosong!</div>
      @endif

      <form action="{{ route('tugas.store') }}" method="POST">
        @csrf
        <div class="mb-2">
          <input type="text" name="judul" class="form-control"
                 placeholder="Judul tugas . . ." value="{{ old('judul') }}">
        </div>
        <div class="mb-2">
          <textarea name="deskripsi" class="form-control"
                    placeholder="Deskripsi tugas (opsional) . . ." rows="2"></textarea>
        </div>
        <div class="mb-3">
          <input type="date" name="tanggal" class="form-control">
        </div>
        <button type="submit" class="btn btn-success w-100 fw-bold">+ Tambah Tugas</button>
      </form>
    </div>
  </div>

  <!-- FILTER -->
  <div class="mb-3 d-flex gap-2">
    <a href="{{ route('tugas.index') }}"
       class="btn btn-sm rounded-pill {{ !request('filter') ? 'btn-success' : 'btn-outline-secondary' }}">
       Semua
    </a>
    <a href="{{ route('tugas.index', ['filter' => 'aktif']) }}"
       class="btn btn-sm rounded-pill {{ request('filter') == 'aktif' ? 'btn-success' : 'btn-outline-secondary' }}">
       Aktif
    </a>
    <a href="{{ route('tugas.index', ['filter' => 'selesai']) }}"
       class="btn btn-sm rounded-pill {{ request('filter') == 'selesai' ? 'btn-success' : 'btn-outline-secondary' }}">
       Selesai
    </a>
  </div>

  <!-- DAFTAR TUGAS -->
  <div id="daftarTugas">
    @forelse($tugas as $t)
      @php
        $status = 'aman';
        if ($t->tanggal) {
          $hari = now()->diffInDays($t->tanggal, false);
          if ($hari < 0) $status = 'terlambat';
          elseif ($hari <= 2) $status = 'mepet';
        }
        $labelTanggal = $t->tanggal
          ? \Carbon\Carbon::parse($t->tanggal)->translatedFormat('j M Y')
          : 'Tanpa tenggat';
        $labelStatus = match($status) {
          'terlambat' => '⚠️ Terlambat!',
          'mepet'     => '⏳ Mepet!',
          default     => '📅 ' . $labelTanggal
        };
        $warnaBorder = match($status) {
          'terlambat' => 'border-danger',
          'mepet'     => 'border-warning',
          default     => 'border-success'
        };
        $warnaBadge = match($status) {
          'terlambat' => 'bg-danger',
          'mepet'     => 'bg-warning text-dark',
          default     => 'bg-success'
        };
      @endphp

      <div class="card shadow-sm mb-2 border-start border-4 {{ $t->selesai ? 'border-secondary opacity-50' : $warnaBorder }}">
        <div class="card-body py-3">

          <div class="d-flex justify-content-between align-items-start mb-1">
            <span class="fw-bold {{ $t->selesai ? 'text-decoration-line-through text-muted' : '' }}">
              {{ $t->judul }}
            </span>
            @if(!$t->selesai)
              <span class="badge {{ $warnaBadge }} ms-2" style="font-size:11px">
                    {{ $labelStatus }}
              </span>
            @else
            <span class="badge bg-secondary ms-2" style="font-size:11px">✅ Selesai</span>
            @endif
          </div>

          <p class="text-muted mb-2" style="font-size:13px">
            {{ $t->deskripsi ?: 'Tidak ada deskripsi.' }}
          </p>

          <div class="d-flex gap-2">
            <!-- Tombol Selesai / Batalkan -->
            <form action="{{ route('tugas.update', $t->id) }}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="judul" value="{{ $t->judul }}">
              <input type="hidden" name="deskripsi" value="{{ $t->deskripsi }}">
              <input type="hidden" name="tanggal" value="{{ $t->tanggal }}">
              <input type="hidden" name="selesai" value="{{ $t->selesai ? 0 : 1 }}">
              <button type="submit" class="btn btn-sm btn-outline-success">
                {{ $t->selesai ? '↩ Batalkan' : '✔ Selesai' }}
              </button>
            </form>

            <!-- Tombol Edit -->
            <a href="{{ route('tugas.edit', $t->id) }}" class="btn btn-sm btn-outline-warning">
              ✏️ Edit
            </a>

            <!-- Tombol Hapus -->
            <form action="{{ route('tugas.destroy', $t->id) }}" method="POST"
                  onsubmit="return confirm('Yakin mau hapus tugas ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Hapus</button>
            </form>
          </div>

        </div>
      </div>
    @empty
      <div class="text-center py-5 text-muted">
        <div style="font-size:40px">📭</div>
        <p>Tidak ada tugas di sini.</p>
      </div>
    @endforelse
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>