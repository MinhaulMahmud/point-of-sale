<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Get started</h1>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form>
										<div class="mb-3">
											<label class="form-label">First name</label>
											<input id="first_name" class="form-control form-control-lg" type="text" name="firstname" placeholder="Enter your first name" />
										</div>
										<div class="mb-3">
											<label class="form-label">Last name</label>
											<input id="last_name" class="form-control form-control-lg" type="text" name="lastname" placeholder="Enter your last name" />
										</div>
										<div class="mb-3">
											<label class="form-label">Phone</label>
											<input id="phone" class="form-control form-control-lg" type="text" name="phone" placeholder="Phone" />
										</div>
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input id="email" class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input id="password" class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" />
										</div>
										<div class="d-grid gap-2 mt-3">
											<button onclick="SubmitRegister()" class="btn btn-lg btn-primary">Sign up</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Already have account? <a href="{{ route('login') }}">Log In</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

<script>
	async function SubmitRegister() {
		let first_name = document.getElementById('first_name').value;
		let last_name = document.getElementById('last_name').value;
		let phone = document.getElementById('phone').value;
		let email = document.getElementById('email').value;
		let password = document.getElementById('password').value;

		// var re = /\S+@\S+\.\S+/;

		if (first_name.length == 0) {
			errorToast('First name is required');
		} 
		else if (last_name.length == 0) {
			errorToast('Last name is required');
		} 
		else if (phone.length != 11) {
			errorToast('Phone number is not valid');
		} 
		else if (email.length == 0 ) {
			errorToast('Email is not valid');
		}
		else if (password.length == 0 || password.length < 6) {
			
			errorToast('Password is invalid');
		} 
		else {
			try {
				showLoader();
				let res = await axios.post("/user-register", { 
					first_name:first_name, 
					last_name:last_name,
					email:email, 
					phone:phone, 
					password:password 
				});
				hideLoader();
				if (res.status === 201 ) {
					successToast(res.data.message);
					window.location.href = "{{ route('login') }}";
				} else {
					errorToast(res.data.message);
				}
			} catch (error) {
				console.error('Error details:', error.response || error.message || error);
				errorToast('Register failed, please try again');
			} finally {
				hideLoader();
			}

		}
	}
</script>