@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create User</h1>
        <form action="" method="POST" id="userForm" class="form-submit" enctype="multipart/form-data">
            @csrf
            <div class="row">
            <div class="mb-3 col-md-4">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control required" id="name" name="name" >
            </div>
            <div class="mb-3  col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control required" id="email" name="email" >
            </div>
            <div class="mb-3  col-md-4">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control required" id="phone" name="phone" >
            </div>
            <div class="mb-3  col-md-12">
                <label for="description " class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <div class="mb-3  col-md-6">
                <label for="role_id" class="form-label">Role ID</label>
                <select class="form-control required" id="role_id" name="role_id" >
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
                </select>
            </div>
            <div class="mb-3  col-md-6">
                <label for="profile_image" class="form-label">Profile Image</label>
                <input type="file" class="form-control required" id="profile_image" name="profile_image" >
            </div>
            <div class="mb-3  col-md-12">
            <button type="submit"  class="btn btn-primary">Submit</button>
            </div>
            </div>
        </form>

        <h1>User List</h1>
        <div class="table-responsive" id="appendHtml">
         @include('userdata', ['user' => $users])
        </div>
    </div>


   
<script>
    function validateForm(formId) {
        const form = document.getElementById(formId);
        $('.error-message').remove();
            const inputs = form.querySelectorAll('.required');
    
            
            let isValid = true;
            inputs.forEach((input) => {
                console.log(input.value.trim());
                if ( input=='' || !input.value.trim()) {
                    input.classList.add('is-invalid');
                    $(input).after("<div class='invalid-feedback error-message'>This field is required</div>")
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }

              
                if (input.type === 'email' && input.value.trim()) {
                    const isValidEmail = validateEmail(input.value);
                    if (!isValidEmail) {
                        input.classList.add('is-invalid');
                         $(input).after("<div class='invalid-feedback error-message'>Please enter a valid email</div>")
                        isValid = false;
                    }
                }

                  if (input.name === 'phone' && input.value.trim()) {
                    const isValidPhone = validatePhone(input.value);
                    console.log(isValidPhone);
                    if (!isValidPhone) {
                        input.classList.add('is-invalid');
                         $(input).after("<div class='invalid-feedback error-message'>Please enter a valid Phone number</div>")
                        isValid = false;
                    }
                }
            });
            return isValid;
    }
    function validateEmail(email) {
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailRegex.test(email);
    }
    function validatePhone(phone) {
        const phoneRegex = /^(\\+91[-\s]?)?[0]?(91)?[789]\d{9}$/;
    return phoneRegex.test(phone);
    }

   $(document).on("submit","#userForm",function(e){
        e.preventDefault(); 
        const form = event.target;
       var isvalid = validateForm(form.id);
      // var isvalid =true;
      if(isvalid){
         const formData = new FormData(form);
         $.ajax({
            type: "POST",   
            url: "{{ route('users.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status) {
                  $("#appendHtml").html(response.dataHtml);
                  form.reset();
                }
            },
            error: function (data) {
                $(".error-message").remove();
                if (data.status == 500) {
                    alert(data.message, false);
                }
                var response = JSON.parse(data.responseText);
                $.each(response.errors, function (k, v) {
                    console.log(k, v[0]);
                    $('[name="' + k + '"]').after("<div class='text-danger error-message'>" +  v + "</div>");
                });
            }
        });
      }
   })


</script>

@endsection
