@extends('backend.admin.includes.admin_layout')
@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center mb-2">Mood Entries</h3>
                    <div style="text-align: right">
                        <button type="button" class="btn btn-success btn-xs addButton" data-bs-toggle="modal"
                            data-bs-target="#AddMoodEntries"><i class="fa-solid fa-plus"></i> Add </button>
                    </div>

                    <div class="mt-3">
                        @if (session('success'))
                        <div style="width:100%" class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong> Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                        @elseif(session('error'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Failed!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                        @endif
                        <div id="success"></div>
                        <div id="failed"></div>
                    </div>
                    <div class="table-responsive" id="print_data">
                        <table id="dataTableExample" class="table tableSmall" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="">SL</th>
                                    <th style="">Mood Type (English)</th>
                                    <th style="">Short Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td></td>
                                    <td> </td>
                                    <td> </td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#EditMoodEntries"
                                            data-id=""
                                            data-name_en=""
                                            data-name_bn=""
                                            data-short_note=""
                                            data-division=""
                                            class="edit btn btn-success btn-icon"><i class="fa-solid fa-edit"></i></a>

                                        <a class="btn btn-danger btn-icon" data-delete=""
                                            id="delete"><i class="fa-solid fa-trash"></i> </a>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddMoodEntries" tabindex="-1" aria-labelledby="AddMoodEntries" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="title" id="defaultModalLabel">ADD Zilla</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('operator.mood_entries')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="division_id" class="form-label">Select Division</label>
                            <select name="division" id="division_id" class="form-control" required>
                                <option value="">-- Select Division --</option>

                                <option value=""></option>

                            </select>
                            @error('division_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>


                        <div class="col-md-6 mb-3">
                            <label  class="form-label w-" for="">Short Note *</label>
                            <textarea class="form-control" style="height:38px" name="short_note" id=""></textarea>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button class="btn btn-xs btn-success" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="EditMoodEntries" tabindex="-1" aria-labelledby="EditMoodEntries" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="title" id="defaultModalLabel">Update Zilla</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('operator.mood_entries')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="division_id" class="form-label">Select Division</label>
                            <select name="division" id="edit_division_id" class="form-control" required>
                                <option value="">-- Select Division --</option>

                                <option value=""></option>

                            </select>
                            @error('division_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label  class="form-label w-" for="">Short Note *</label>
                            <textarea class="form-control" style="height:38px" name="short_note" id="short_note"></textarea>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    $(document).on('click', '.edit', function() {
        var id = $(this).data('id');
        var name_en = $(this).data('name_en');
        var name_bn = $(this).data('name_bn');
        var short_note = $(this).data('short_note');
        var division_id = $(this).data('division');

        $('#id').val(id);
        $('#name_en').val(name_en);
        $('#name_bn').val(name_bn);
        $('#short_note').val(short_note);
        $('#edit_division_id').val(division_id).trigger('change');

    })
</script>
<script>
    $(document).on('click', '#delete', function() {
        if (confirm('Are You Sure ?')) {
            let id = $(this).attr('data-delete');
            let row = $(this).closest('tr');
            $.ajax({
                url: '/admin/zilla/delete/' + id,
                success: function(data) {
                    var data_object = JSON.parse(data);
                    if (data_object.status == 'SUCCESS') {
                        row.remove();
                        $('#Table tbody tr').each(function(index) {
                            $(this).find('td:first').text(index + 1);
                        });
                        $('#success').css('display', 'block');
                        $('#success').html(
                            '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success! </strong>' +
                            data_object.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button></div>'
                        );
                    } else {
                        $('#failed').html('display', 'block');
                        $('#failed').html(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Failed! </strong>' +
                            data_object.message +
                            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button></div>'
                        );
                    }

                }
            });
        }
    });

    $(function() {
        $('#division_id').select2({
            dropdownParent: $('#AddMoodEntries')
        });
        $('#edit_division_id').select2({
            dropdownParent: $('#EditMoodEntries')
        });
    });
</script>
@endpush