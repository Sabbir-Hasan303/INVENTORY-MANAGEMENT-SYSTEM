<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br/>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <input id="password" placeholder="User Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="SubmitButton()" class="btn w-100 btn-primary">Next</button>
                    <hr/>
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{url('/registration-page')}}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{url('/send-otp-page')}}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     async function SubmitButton() {
         let email = document.getElementById('email').value;
         let password = document.getElementById('password').value;

         if (email.length === 0) {
             errorToast('Please enter email');
         } else if (password.length === 0) {
             errorToast('Please enter password');
         } else {
             let url = '/user-login';
             let response = await axios.post(url, {
                 email: email,
                 password: password
             });

             if (response.status === 200 && response.data['status'] === 'success') {
                 window.location.href = '/dashboard';
             } else {
                 errorToast(response.data['message']);
             }
         }
     }

</script>
