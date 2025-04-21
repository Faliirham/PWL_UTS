<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <h5><i class="icon fas fa-info-circle"></i> Informasi User</h5>
                Berikut adalah detail informasi user yang Anda pilih:
            </div>
            <table class="table table-sm table-bordered table-striped">
                <tbody>
                    <tr>
                        <th class="text-right col-3">ID User:</th>
                        <td class="col-9">{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama:</th>
                        <td class="col-9">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Email:</th>
                        <td class="col-9">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Role:</th>
                        <td class="col-9">{{ ucfirst($user->role) }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Cabang:</th>
                        <td class="col-9">{{ $user->branch->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Jumlah Evaluasi:</th>
                        <td class="col-9">{{ $user->evaluations->count() }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Dibuat:</th>
                        <td class="col-9">{{ $user->created_at }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Terakhir Diupdate:</th>
                        <td class="col-9">{{ $user->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>