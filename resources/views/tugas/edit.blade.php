<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Tugas</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('img/icon.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 600px">

  <h4 class="fw-bold mb-4">✏️ Edit Tugas</h4>

  <div class="card shadow-sm">
    <div class="card-body">
      <form action="{{ route('tugas.update', $tugas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label fw-bold">Judul Tugas</label>
          <input type="text" name="judul" class="form-control"
                 value="{{ $tugas->judul }}" required>
          @error('judul')
            <div class="text-danger" style="font-size:13px">⚠️ Judul tidak boleh kosong!</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Deskripsi</label>
          <textarea name="deskripsi" class="form-control" rows="3">{{ $tugas->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Deadline</label>
          <input type="date" name="tanggal" class="form-control"
                 value="{{ $tugas->tanggal }}">
        </div>

        <div class="mb-4 form-check">
          <input type="checkbox" name="selesai" value="1" class="form-check-input" id="selesai"
                  {{ $tugas->selesai ? 'checked' : '' }}>
          <label class="form-check-label" for="selesai">Tandai sebagai selesai</label>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-warning fw-bold">Update</button>
          <a href="{{ route('tugas.index') }}" class="btn btn-secondary">Batal</a>
        </div>

      </form>
    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>