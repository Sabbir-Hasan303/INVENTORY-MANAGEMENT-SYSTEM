<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password"/>
                    <br/>
                    <label>Confirm Password</label>
                    <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="ResetPass()" class="btn w-100  btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function ResetPass() {
        var password = document.getElementById('password').value;
        var cpassword = document.getElementById('cpassword').value;
        if (password.length === 0) {
            errorToast('Password is required')
        } else if (cpassword.length === 0) {
            errorToast('Confirm Password is required')
        } else {
            let url = '/pass-reset'
            let data = {
                password: password
            }
            let response = await axios.post(url, data);

            if (response.status === 200 && response.status['status'] === 'success') {
                successToast(response.data['message']);
                setTimeout(function(){
                    window.location.href = '/login-page'
                },1000)
            } else {
                errorToast(response.data['message']);
            }
        }
    }
</script>
