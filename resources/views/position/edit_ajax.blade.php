@empty($position)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Error</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                Position data not found
            </div>
            <a href="{{ url('/position') }}" class="btn btn-warning">Back</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/position/' . $position->id . '/update_ajax') }}" method="POST" id="form-edit-position">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Name --}}
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="name" value="{{ $position->name }}" class="form-control" required>
                    <small id="error-name" class="error-text form-text text-danger"></small>
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ $position->description }}</textarea>
                    <small id="error-description" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#form-edit-position").validate({
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
                                title: 'Success',
                                text: response.message
                            });
                            dataPosition.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Error Occurred',
                                text: response.message
                            });
                        }
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Occurred',
                            text: 'Status 500, please check server logs.'
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
@endempty