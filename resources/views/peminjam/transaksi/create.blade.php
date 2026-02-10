@extends('layouts.peminjam') {{-- Gunakan layout khusus peminjam --}}

@section('content')
<div class="container" style="margin-top: 40px; max-width: 800px; font-family: 'Segoe UI', sans-serif;">
    <div
        style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 35px; border: 1px solid #e3e6f0;">
        <h4 style="margin-bottom: 10px; color: #3a3b45; font-weight: 700; text-align: center;">Form Pinjam Alat</h4>
        <p style="text-align: center; color: #858796; margin-bottom: 30px;">Silakan pilih alat yang ingin Anda gunakan.
        </p>

        @if(session('error'))
        <div
            style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #f5c2c7;">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('peminjam.peminjaman.store') }}" method="POST">
            @csrf

            {{-- Info User (Read Only) --}}
            <div
                style="margin-bottom: 25px; background: #f8f9fc; padding: 15px; border-radius: 8px; border: 1px solid #e3e6f0;">
                <label
                    style="display: block; margin-bottom: 5px; font-size: 11px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Peminjam
                    Aktif</label>
                <div style="font-weight: 600; color: #3a3b45;">{{ auth()->user()->name }} ({{ auth()->user()->email }})
                </div>
            </div>

            <div id="container-alat">
                <label
                    style="display: block; margin-bottom: 12px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Daftar
                    Alat</label>

                <div class="item-alat" style="display: flex; gap: 10px; margin-bottom: 15px; align-items: flex-end;">
                    <div style="flex: 2;">
                        <small style="color: #858796;">Pilih Alat</small>
                        <select name="alat_id[]"
                            style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;" required>
                            <option value="" disabled selected>-- Pilih Alat --</option>
                            @foreach($alats as $alat)
                            <option value="{{ $alat->id }}">{{ $alat->nama_alat }} (Tersedia: {{ $alat->stok }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <small style="color: #858796;">Jumlah</small>
                        <input type="number" name="jumlah[]" min="1" value="1"
                            style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;" required>
                    </div>
                    <div style="flex: 0.2;">
                        <button type="button" class="btn-hapus"
                            style="background: #e74a3b; color: white; border: none; padding: 12px 15px; border-radius: 6px; cursor: pointer; visibility: hidden;">&times;</button>
                    </div>
                </div>
            </div>

            <button type="button" id="tambah-alat"
                style="background: #1cc88a; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; margin-bottom: 30px;">
                + Tambah Alat Lain
            </button>

            <div style="margin-bottom: 30px;">
                <label
                    style="display: block; margin-bottom: 8px; font-size: 13px; font-weight: 700; color: #4e73df; text-transform: uppercase;">Rencana
                    Tanggal Pengembalian</label>
                <input type="date" name="tgl_kembali_rencana"
                    style="width: 100%; padding: 12px; border: 1px solid #d1d3e2; border-radius: 6px;"
                    min="{{ date('Y-m-d') }}" required>
                <small style="color: #e74a3b;">*Denda berlaku jika melewati batas tanggal ini.</small>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit"
                    style="flex: 2; background-color: #4e73df; color: white; border: none; padding: 14px; border-radius: 6px; cursor: pointer; font-weight: 700;">Konfirmasi
                    Pinjaman</button>
                <a href="{{ route('peminjam.peminjaman.index') }}"
                    style="flex: 1; text-align: center; background-color: #f8f9fc; color: #4e73df; border: 1px solid #d1d3e2; padding: 14px; border-radius: 6px; text-decoration: none; font-weight: 700;">Kembali</a>
            </div>
        </form>
    </div>
</div>

{{-- Script dinamis sama seperti versi Admin --}}
<script>
document.getElementById('tambah-alat').addEventListener('click', function() {
    const container = document.getElementById('container-alat');
    const originalRow = container.querySelector('.item-alat');
    const newRow = originalRow.cloneNode(true);
    newRow.querySelector('select').value = "";
    newRow.querySelector('input').value = "1";
    const hapusBtn = newRow.querySelector('.btn-hapus');
    hapusBtn.style.visibility = 'visible';
    hapusBtn.addEventListener('click', function() {
        newRow.remove();
    });
    container.appendChild(newRow);
});
</script>
@endsection