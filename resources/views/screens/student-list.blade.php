@extends('layout.app')
@section('content')
    <input class="search" type="search" placeholder="Search" aria-label="Search">
    <div class="container text-right">
        <a href="{{ route('index') }}" class="btn btn-dark">New Student</a>
    </div>

    <div class="container">
        <table class="table table-hover mt-3" >
            <thead>
                <tr>
                    <th>S.no</th>
                    <th>Name</th>
                    <th>email</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="std-table">


                {{-- <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><img src="" alt="" height="50" width="50"></td>
                    <td>
                        <a href="" class="btn btn-dark">Show</a>
                        <a href="" class="btn btn-dark">Edit</a>
                        <a href="" class="btn btn-danger">Delete</a>
                    </td>

                </tr> --}}

            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right"
            };
            $.ajax({
                url: "{{ route('student-list') }}",
                success: function(data) {
                    if (data.student.length > 0) {
                        var img = [];
                        var id = [];
                        for (let i = 0; i < data.student.length; i++) {
                            img = data.student[i]['image'];
                            id = data.student[i]['id'];
                            var editUrl = '/student-edit/' + id;
                            $('#std-table').append(
                                `<tr>
                                <td>` + data.student[i]['id'] + `</td>
                                <td>` + data.student[i]['name'] + `</td>
                                <td>` + data.student[i]['email'] + `</td>
                                <td><img src="{{ asset('images/${img}') }}" alt="" height="50" width="50"></td>
                                <td>
                                    <a href="" class="btn btn-dark">Show</a>
                                    <a href="` + editUrl + `" class="btn btn-dark">Edit</a>
                                    <a href="" class="btn btn-danger delete-btn" data-id="` + data.student[i]['id'] + `">Delete</a>
                                </td>
                            </tr>`
                            )
                        }
                    }
                }
            });


            $(".search").on("keyup", function() {
                var term = $(this).val();
                // console.log(term)
                $.ajax({
                    url: "student-list",
                    method: 'get',
                    data: {
                        search: term
                    },
                    success: function(data) {
                        console.log(data.searched);
                        $('#std-table').empty();

                        if (term === '' && data.student && data.student.length > 0) {
                            // If search term is empty, display all original data
                            for (let i = 0; i < data.student.length; i++) {
                                img = data.student[i]['image'];
                                id = data.student[i]['id'];
                                var editUrl = '/student-edit/' + id;
                                // console.log(id);
                                $('#std-table').append(
                                    `<tr>
                                        <td>` + data.student[i]['id'] + `</td>
                                        <td>` + data.student[i]['name'] + `</td>
                                        <td>` + data.student[i]['email'] + `</td>
                                        <td><img src="{{ asset('images/${img}') }}" alt="" height="50" width="50"></td>
                                        <td>
                                            <a href="" class="btn btn-dark">Show</a>
                                            <a href="` + editUrl + `" class="btn btn-dark">Edit</a>
                                            <a href="" class="btn btn-danger delete-btn" data-id="` + data.student[i]['id'] + `">Delete</a>
                                        </td>
                                    </tr>`
                                )
                                // ... Your existing code for appending rows
                            }
                        }
                        if (data.searched && data.searched.length > 0) {
                            var img = [];
                            var id = [];
                            for (let i = 0; i < data.searched.length; i++) {
                                img = data.searched[i]['image'];
                                id = data.searched[i]['id'];
                                var editUrl = '/student-edit/' + id;


                                $('#std-table').append(
                                    `<tr>
                                        <td>` + data.searched[i]['id'] + `</td>
                                        <td>` + data.searched[i]['name'] + `</td>
                                        <td>` + data.searched[i]['email'] + `</td>
                                        <td><img src="{{ asset('images/${img}') }}" alt="" height="50" width="50"></td>
                                        <td>
                                            <a href="" class="btn btn-dark">Show</a>
                                            <a href="` + editUrl + `" class="btn btn-dark">Edit</a>
                                            <a href="" class="btn btn-danger delete-btn" data-id="` + data.searched[i][
                                        'id'
                                    ] + `">Delete</a>
                                        </td>
                                    </tr>`
                                )
                            }
                        }
                    }
                })

            })
            $("#std-table").on("click", ".delete-btn", function() {
                var id = $(this).attr("data-id");

                // console.log(id);
                $.ajax({
                    type: "GET",
                    url: "/student-delete/" + id,
                    success: function(data) {
                        // alert(data.result);
                        toastr.success("Student Has Been Deleted.");
                    },
                    error: function(error) {
                        console.log(error.responseText);
                    },


                })
            })

        });
    </script>
@endsection
