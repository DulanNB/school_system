@extends('backend.layouts.master')

@section('main-content')


    <div class="card">
        <h5 class="card-header">Assign Courses</h5>
        <div class="card-body">
            <form method="post" action="{{route('student.enroll',$student->id)}}" enctype="multipart/form-data" >
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input id="name" type="text" name="name" value=" {{$student->name}}" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="admission_num" class="col-form-label">Admission Number</label>
                    <input type="text" class="form-control" value="{{$student->admission_num}}" id="admission_num" name="admission_num" readonly>
                </div>

                <div class="form-group">
                    <label for="course_select" class="col-form-label">Select Courses</label>
                    <select class="js-example-basic-multiple form-control" id="course_select" name="course_select[]" multiple="multiple">
                        @foreach($courses as $course)
                            <option data-cost="{{$course->value}}" value="{{$course->id}}">{{$course->course_name}}</option>
                        @endforeach
                    </select>
                    @error('course_select')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="course_fee" class="col-form-label">Course Fee</label>
                    <input type="text" class="form-control" id="course_fee" name="admission_num" readonly>
                </div>

                <div class="form-group">
                    <label for="payment" class="col-form-label">Pay By</label>
                    <select class="form-control" id="payment" name="payment">
                        <option value="0" selected> Select Payment Option </option>
                        @foreach($payment_methods as $payment_method )
                            <option value="{{$payment_method->id}}"> {{$payment_method->payment_plan}} </option>
                        @endforeach
                    </select>
                    @error('payment')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
    <script>
        $('#course_select').change(function() {
            var sum = $(this).find(':checked')
                .map(function() { return parseInt($(this).data('cost'), 10); })
                .get()
                .reduce(function(x, y) { return x + y; });

            $('#course_fee').val('LKR '+sum);
        });
    </script>
    <script>



        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 120
            });
        });
    </script>

    <script>
        $('#is_parent').change(function(){
            var is_checked=$('#is_parent').prop('checked');
            // alert(is_checked);
            if(is_checked){
                $('#parent_cat_div').addClass('d-none');
                $('#parent_cat_div').val('');
            }
            else{
                $('#parent_cat_div').removeClass('d-none');
            }
        })
    </script>

@endpush
