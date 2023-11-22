@extends('layout.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card mt-3">
                    <span class="text-success"></span>
                    <form class="myform" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label >Student Name</label>
                            <input type="text" placeholder="Name" name="name" class="form-control">
                            <span class="text-danger name"></span>
                        </div>
                        <div class="form-group">
                            <label >Email</label>
                            <input type="email" placeholder="Email" name="email" class="form-control">
                            <span class="text-danger email"></span>

                        </div>
                        <div class="form-group">
                            <label >Image</label>
                            <input type="file" name="image" class="form-control" >
                            <span class="text-danger image"></span>

                        </div>
                        <button type="submit" class="btn btn-dark button">Submit</button>
                        {{-- <a    type="submit" class="btn btn-dark" >Back</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".myform").submit(function(e) {

                e.preventDefault();
                toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right"
                };

                var form = $('.myform')[0];
                console.log(form)
                var formdata = new FormData(form);
                console.log(formdata)
                $(".button").prop("disabled", true);
                // console.log(form)
                $.ajax({
                    method: "POST",
                    url: "{{ route('create-student') }}",
                    data: formdata,
                    // _token: "{{ csrf_token() }}", // Include CSRF token in the data

                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $(".myform").trigger('reset');
                        $(".button").prop("disabled", false);

                        // alert(data.toastr)
                        toastr.success(data.success);
                    },
                    error: function(err){
                        for (let field in err.responseJSON.errors) {
                            // Assuming each field has only one error message
                            console.log(err.responseJSON.errors[field]);
                            // toastr.error(err.responseJSON.errors[field]);
                        }
                        $('.name').text(err.responseJSON.errors['name']);
                        $('.email').text(err.responseJSON.errors['email']);
                        $('.image').text(err.responseJSON.errors['image']);
                        $(".button").prop("disabled", false);
                    },
                });
            });
        });
    </script>
@endsection
