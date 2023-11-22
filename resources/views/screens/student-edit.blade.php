@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card mt-3">
                    <span class="text-success"></span>
                    <form class="updateform" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Student Name</label>
                            <input type="text" placeholder="Name" name="name" class="form-control" value="{{ $student->name }}">
                            <input type="hidden"  name="id" class="form-control" value="{{ $student->id }}">
                            <span class="text-danger name"></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" placeholder="Email" name="email" class="form-control"
                                value="{{ $student->email }}">
                            <span class="text-danger email"></span>

                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                            <span class="text-danger image"></span>
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('images/' . $student->image) }}" height="70" width="70" alt="">
                        </div>
                        <button type="submit" class="btn btn-dark button">Update</button>
                        {{-- <a    type="submit" class="btn btn-dark" >Back</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".updateform").submit(function(e) {
                e.preventDefault();
                toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right"
                };
                var id = $("input[name='id']").val();
                var form = $(".updateform")[0];
                var formdata= new FormData(form);

                $.ajax({
                    type:'POST',
                    url: "/student-update/" + id,
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(data){
                        // console.log(data.result);
                        window.open("/list","_self");
                        toastr.success("Student Has Benn Updated.");
                    },
                    error: function(error){
                        console.log(error.responseText);
                    }
                });

            });

        });
    </script>
@endsection
