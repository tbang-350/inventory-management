@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Purchase </h4><br><br>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Date</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="date" class="form-control example-date-input" type="date"
                                                id="date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Purchase No</label>
                                        <div class=" form-group col-sm-10">
                                            <input name="purchase_no" class="form-control example-date-input" type="text"
                                                id="purchase_no">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Supplier Name</label>
                                        <div class=" form-group col-sm-10">
                                            <select name="supplier_id" id="supplier_id" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="">Open this select menu</option>

                                                @foreach ($supplier as $supp)
                                                    <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Category</label>
                                        <div class=" form-group col-sm-10">
                                            <select name="category_id" id="category_id" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="">Open this select menu</option>



                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label">Product</label>
                                        <div class=" form-group col-sm-10">
                                            <select name="product_id" id="product_id" class="form-select"
                                                aria-label="Default select example">
                                                <option selected="">Open this select menu</option>



                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="md-3">
                                        <label for="example-text-input" class="form-label" style="margin-top: 43px">
                                        </label>
                                        <input type="button" value="Add More"
                                            class="btn btn-secondary btn-rounded waves-effect waves-light">
                                    </div>
                                </div>


                            </div> <!-- end row -->



                        </div>
                        <!--end cardbody -->

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->

        </div>

    </div>


    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#supplier_id', function() {
                var supplier_id = $(this).val();
                $.ajax({
                    url: "{{ route('get-category') }}",
                    type: "GET",
                    data: {
                        supplier_id: supplier_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Category</option>';
                        $.each(data, function(key, v) {
                            html += '<option value=" ' + v.category_id + ' "> ' + v
                                .category.name + '</option>';
                        });
                        $('#category_id').html(html);
                    }
                })
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#category_id', function() {
                var category_id = $(this).val();
                $.ajax({
                    url: "{{ route('get-product') }}",
                    type: "GET",
                    data: {
                        category_id: category_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Category</option>';
                        $.each(data, function(key, v) {
                            html += '<option value=" ' + v.id + ' "> ' + v.name + '</option>';
                        });
                        $('#product_id').html(html);
                    }
                })
            });
        });
    </script>


@endsection
