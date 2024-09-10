<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome!</h1>
							<p class="lead">
								Sign in to your account to continue
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input id="email" class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input id="password" class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
										</div>
										<!-- <div>
											<div class="form-check align-items-center">
												<input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
												<label class="form-check-label text-small" for="customControlInline">Remember me</label>
											</div>
										</div> -->
										<div class="d-grid gap-2 mt-3">
											<button class="btn btn-lg btn-primary" type="button" onclick="SubmitLogin()">Sign in</button>
										</div>
										<div class="text-center mt-3"><a href="{{ route('send_otp') }}">Forgot Password?</a></div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							<span>
								<!-- <span class="ms-1">|</span> -->
								Don't have an account? <a href="{{ route('register') }}">Sign up</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
</main>

<script>
	async function SubmitLogin() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (email == 0) {
        errorToast('Email is required');
    } else if (password == 0) {
        errorToast('Password is required');
    } else {
        try {
            showLoader();
            let res = await axios.post("/user-login", { email:email, password:password });
			hideLoader();
            if (res.status===200 && res.data['status']==='success') {
                window.location.href = "{{route('dashboard')}}";
				// successToast(res.data.message);
            } else {
                errorToast(res.data.message);
            }
        } catch (error) {
            errorToast('Login failed, please try again');
        } finally {
            hideLoader();  // Ensure loader is hidden after the request is complete
        }
    	}
	}
</script>