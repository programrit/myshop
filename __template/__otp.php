<div class="col-md-12">
    <form action="" method="POST"  class="needs-validation" novalidate>
        <div class="col-md-3 mx-auto mt-3">
            <label for="">OTP</label>
            <input type="password" pattern="[0-9]{6}" name="otp" required class="form-control">
            <button class="btn btn-success mt-3 ml-5" name="otp_verify" type="submit">Submit</button>
            <button class="btn btn-danger mt-3" type="reset">Cancel</button>
        </div>
    </form>
    <form action="" method="POST">
        <div class="text-center mt-2">
        <button class="btn btn-info text-center mt-3" name="resend_otp" type="submit">Resend OTP</button>
        </div>
    </form>
</div>