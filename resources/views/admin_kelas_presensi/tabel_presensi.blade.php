<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>NIM</th>
            <th>Mahasiswa</th>
            <th width="10%">Status</th>
            <th width="10%">Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($presensi as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nim }}</td>
        <td>{{ $item->nama_mhs }}</td>
        
        <td>
            @if($item->status_kehadiran == 'h') <span class="badge badge-success">Hadir</span>
            @elseif($item->status_kehadiran == 'i') <span class="badge badge-info">Izin</span>
            @elseif($item->status_kehadiran == 's') <span class="badge badge-warning">Sakit</span>
            @elseif($item->status_kehadiran == 'a') <span class="badge badge-danger">Alpha</span>
            @elseif($item->status_kehadiran == 'd') <span class="badge badge-secondary">Dispen</span>
            @else -
            @endif
        </td>
        <td>
            <button type="button" class="btn btn-warning btn-sm btn-edit-presensi" 
                data-toggle="modal" 
                data-target="#modal-edit" 
                data-id_presensi="{{ $item->id }}" 
                data-nim="{{ $item->nim }}"
                data-nama="{{ $item->nama_mhs }}"
                data-status_kehadiran="{{ $item->status_kehadiran }}">
                <i class="fas fa-edit"></i> Edit
            </button>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center">Belum ada data presensi</td>
    </tr>
    @endforelse
</tbody>
</table>