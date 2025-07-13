@extends('backend.admin.includes.admin_layout')
@section('content')
<div class="page-content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center mb-2">Mood Type</h3>
                    <div style="text-align: right">
                        <button type="button" class="btn btn-success btn-xs addButton" data-bs-toggle="modal"
                            data-bs-target="#AddMoodType"><i class="fa-solid fa-plus"></i> Add </button>
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
                                    <th style="">Mood Type </th>
                                    <th style="">Priority</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($data['mood_type_list'] as $key => $single_mood)
                                <tr>
                                    <td>{{$key +1}}</td>


                                    <td>{{$single_mood->mood_type}}</td>

                                    <td>{{$single_mood->priority}}</td>
                                  
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#EditMoodType"
                                            data-id="{{$single_mood->id}}"
                                            data-mood_type="{{$single_mood->mood_type}}"
                                            data-priority="{{$single_mood->priority}}"
                                            class="edit btn btn-success btn-icon"><i class="fa-solid fa-edit"></i></a>

                                        <a class="btn btn-danger btn-icon" data-delete="{{$single_mood->id}}"
                                            id="delete"><i class="fa-solid fa-trash"></i> </a>
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddMoodType" tabindex="-1" aria-labelledby="AddMoodType" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="title" id="defaultModalLabel">ADD Mood Type</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.mood_type')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label" for="">Mood Type (English)*</label>
                            <input type="text" class="form-control" placeholder="Enter Mood Type" name="mood_type" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="">Priority *</label>
                            <input type="number" class="form-control" placeholder="Enter Priority" name="priority" required>
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


<div class="modal fade" id="EditMoodType" tabindex="-1" aria-labelledby="EditMoodType" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h6 class="title" id="defaultModalLabel">Update Division</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.mood_type')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Name (English)*</label>
                            <input type="hidden" name="id" id="id">

                            <input type="text" class="form-control" placeholder="Enter Division Name" name="mood_type" id="mood_type" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="">Priority *</label>
                            <input type="number" class="form-control" placeholder="Enter Priority" name="priority" id="priority" required>
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
        var mood_type = $(this).data('mood_type');
        var priority = $(this).data('priority');

        $('#id').val(id);
        $('#mood_type').val(mood_type);
        $('#priority').val(priority);

    })
</script>
<script>
    $(document).on('click', '#delete', function() {
        if (confirm('Are You Sure ?')) {
            let id = $(this).attr('data-delete');
            let row = $(this).closest('tr');
            $.ajax({
                url: '/admin/mood_type/delete/' + id,
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
</script>
@endpush