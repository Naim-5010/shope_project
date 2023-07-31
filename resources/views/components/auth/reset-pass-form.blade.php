<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <input id="pass" placeholder="New Password" class="form-control" type="password"/>
                    <br/>
                    <label>Confirm Password</label>
                    <input id="cpass"  placeholder="Confirm Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="ResetPass()" class="btn w-100  btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

async function ResetPass(){
    let pass = document.getElementById("pass").value;
    let cpass = document.getElementById('cpass').value;
    if(pass.length === 0){
        errorToast("Please Enter Your New password");
    }
    else if(cpass.length ===0){
        errorToast("please Enter Your Confirm Password");
    }
    else if(pass !== cpass){
        errorToast("New password And comfirm Password Must Be Same");
    }
    else{
        showLoader();
        let res =await axios.post("/Reset-password",{
            password: pass,
        });
        hideLoader();
        if(res.status === 200 && res.data['status'] === "success"){
            successToast("Your Password Update");
            debugger;
            window.location.href = "/userLogin";
        }
        else{
            errorToast(res.data['message']);
        }
    }
}


//  async function ResetPass() {
//         let pass=document.getElementById('pass').value;
//         let cpass=document.getElementById('cpass').value;
//         if(pass.length===0){
//             errorToast("Password Required");
//         }
//         else if(cpass.length===0){
//             errorToast("Confirm Password Required")
//         }
//         else if(pass!==cpass){
//             errorToast("Password & Confirm Password Should be same !")
//         }
//         else{
//             let res=await axios.post("/Reset-password",{password:pass});
//             if(res.status===200){
//                 window.location.href="/userLogin"
//             }
//             else{
//                 errorToast("Request Fail !");
//             }
//         }
//     }






</script>