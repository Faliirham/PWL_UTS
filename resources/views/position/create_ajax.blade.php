<form action="{{ url('/position/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Posisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Nama Posisi --}}
                <div class="form-group">
                    <label>Nama Posisi</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <small id="error-name" class="error-text form-text text-danger"></small>
                </div>

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    <small id="error-description" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</form>

<script>
    $(document).ready(function () {
        $("#form-tambah").validate({
            rules: {
                name: { required: true, minlength: 3, maxlength: 100 }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            if (typeof dataPosition !== 'undefined') {
                                dataPosition.ajax.reload();
                            }
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>