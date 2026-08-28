<!-- Modal Backdrop -->
<div id="modalBackdrop" onclick="closeAllModals()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:100;"></div>

<!-- ─── LOGIN MODAL ─── -->
<div id="loginModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:101; width:100%; max-width:440px; padding:0 16px;">
    <div style="background:white; border-radius:5px; padding:40px; box-shadow:0 20px 60px rgba(0,0,0,0.3); position:relative;">

        <button onclick="closeAllModals()" style="position:absolute; top:16px; right:20px; background:none; border:none; font-size:20px; color:#9ca3af; cursor:pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div style="text-align:center; margin-bottom:28px;">
            @if($errors->any())
    <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:12px 16px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <i class="fa-solid fa-circle-exclamation" style="color:#ef4444; font-size:16px; flex-shrink:0;"></i>
        <p style="color:#dc2626; font-size:14px; margin:0;">{{ $errors->first() }}</p>
    </div>
@endif
            <img src="{{ asset('logo.png') }}" alt="Rompace" style="height:48px; margin-bottom:12px;">
            <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Welcome back</h2>
            <p style="color:#6b7280; font-size:14px; margin-top:6px;">Sign in to your Rompace account</p>
        </div>

        <div style="margin-bottom:16px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">WhatsApp Number</label>
            <div style="display:flex; border:1.5px solid #e5e7eb; border-radius:12px; overflow:hidden; background:white;">
                <select id="loginCountryCode" style="padding:12px 10px; background:#f9fafb; border:none; border-right:1.5px solid #e5e7eb; color:#374151; font-size:14px; outline:none;">
                    <option value="+254">🇰🇪 +254</option>
                    <option value="+255">🇹🇿 +255</option>
                    <option value="+256">🇺🇬 +256</option>
                    <option value="+234">🇳🇬 +234</option>
                    <option value="+233">🇬🇭 +233</option>
                    <option value="+27">🇿🇦 +27</option>
                    <option value="+44">🇬🇧 +44</option>
                    <option value="+1">🇺🇸 +1</option>
                </select>
                <input type="tel" id="loginPhone" placeholder="712345678" maxlength="9"
                    style="flex:1; border:none; outline:none; padding:12px 14px; font-size:15px; color:#111827;">
            </div>
            <p id="loginPhoneError" style="color:#ef4444; font-size:12px; margin-top:4px; display:none;">
                <i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>Number must start with 7 or 1 and be 9 digits
            </p>
        </div>

        <div style="margin-bottom:8px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Password</label>
            <div style="position:relative;">
                <input type="password" id="loginPassword" placeholder="Enter your password"
                    style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:12px 44px 12px 14px; font-size:15px; color:#111827; outline:none; box-sizing:border-box;">
                <button type="button" onclick="togglePassword('loginPassword')"
                    style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af;">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
        </div>

        <p style="text-align:right; margin-top:0; margin-bottom:24px;">
            <a href="#" onclick="switchModal('loginModal','forgotPasswordModal')" style="color:#720e9e; font-size:13px; font-weight:600; text-decoration:none;">Forgot password?</a>
        </p>

        <button onclick="submitLogin()"
            style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:5px; cursor:pointer; box-shadow:0 4px 14px rgba(114,14,158,0.3);">
            Sign In
        </button>

        <p style="text-align:center; color:#6b7280; font-size:14px; margin-top:20px;">
            Don't have an account?
            <a href="#" onclick="switchModal('loginModal','registerModal')" style="color:#720e9e; font-weight:600; text-decoration:none;">Join free</a>
        </p>
    </div>
</div>

<!-- ─── REGISTER MODAL ─── -->
<div id="registerModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:101; width:100%; max-width:480px; padding:0 16px;">
    <div style="background:white; border-radius:24px; padding:40px; box-shadow:0 20px 60px rgba(0,0,0,0.3); position:relative;">

        <button onclick="closeAllModals()" style="position:absolute; top:16px; right:20px; background:none; border:none; font-size:20px; color:#9ca3af; cursor:pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Progress bar -->
        <div style="margin-bottom:28px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                <span style="font-size:12px; color:#9ca3af;" id="stepLabel">Step 1 of 5</span>
                <span style="font-size:12px; color:#720e9e; font-weight:600;" id="stepPercent">20%</span>
            </div>
            <div style="background:#f3f4f6; border-radius:999px; height:6px;">
                <div id="progressBar" style="background:#720e9e; height:6px; border-radius:999px; width:20%; transition:width 0.3s;"></div>
            </div>
        </div>

        <!-- ── STEP 1: Gender ── -->
        <div id="step1" class="reg-step">
            <div style="text-align:center; margin-bottom:24px;">
                <img src="{{ asset('logo.png') }}" alt="Rompace" style="height:40px; margin-bottom:12px;">
                <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Let's get started</h2>
                <p style="color:#6b7280; font-size:14px; margin-top:6px;">Tell us a bit about yourself</p>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                <div>
                    <p style="font-size:13px; font-weight:600; color:#374151; margin-bottom:10px;">I am a</p>
                    <div onclick="selectGender('male')" id="genderMale"
                        style="border:2px solid #e5e7eb; border-radius:12px; padding:14px 16px; cursor:pointer; display:flex; align-items:center; gap:10px; margin-bottom:10px; transition:all 0.2s;">
                        <div style="width:22px; height:22px; border-radius:50%; border:2px solid #d1d5db;" id="genderMaleCircle"></div>
                        <span style="font-size:15px; color:#374151;">a man</span>
                    </div>
                    <div onclick="selectGender('female')" id="genderFemale"
                        style="border:2px solid #e5e7eb; border-radius:12px; padding:14px 16px; cursor:pointer; display:flex; align-items:center; gap:10px; transition:all 0.2s;">
                        <div style="width:22px; height:22px; border-radius:50%; border:2px solid #d1d5db;" id="genderFemaleCircle"></div>
                        <span style="font-size:15px; color:#374151;">a woman</span>
                    </div>
                </div>
                <div>
                    <p style="font-size:13px; font-weight:600; color:#374151; margin-bottom:10px;">I am looking for</p>
                    <div onclick="selectLooking('male')" id="lookingMale"
                        style="border:2px solid #e5e7eb; border-radius:12px; padding:14px 16px; cursor:pointer; display:flex; align-items:center; gap:10px; margin-bottom:10px; transition:all 0.2s;">
                        <div style="width:22px; height:22px; border-radius:50%; border:2px solid #d1d5db;" id="lookingMaleCircle"></div>
                        <span style="font-size:15px; color:#374151;">a man</span>
                    </div>
                    <div onclick="selectLooking('female')" id="lookingFemale"
                        style="border:2px solid #e5e7eb; border-radius:12px; padding:14px 16px; cursor:pointer; display:flex; align-items:center; gap:10px; margin-bottom:10px; transition:all 0.2s;">
                        <div style="width:22px; height:22px; border-radius:50%; border:2px solid #d1d5db;" id="lookingFemaleCircle"></div>
                        <span style="font-size:15px; color:#374151;">a woman</span>
                    </div>
                    <div onclick="selectLooking('any')" id="lookingAny"
                        style="border:2px solid #e5e7eb; border-radius:12px; padding:14px 16px; cursor:pointer; display:flex; align-items:center; gap:10px; transition:all 0.2s;">
                        <div style="width:22px; height:22px; border-radius:50%; border:2px solid #d1d5db;" id="lookingAnyCircle"></div>
                        <span style="font-size:15px; color:#374151;">anyone</span>
                    </div>
                </div>
            </div>

            <button onclick="nextStep(1)" style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:999px; cursor:pointer; margin-top:24px;">
                Continue <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
            </button>

            <p style="text-align:center; color:#6b7280; font-size:13px; margin-top:16px;">
                Already have an account?
                <a href="#" onclick="switchModal('registerModal','loginModal')" style="color:#720e9e; font-weight:600; text-decoration:none;">Sign in</a>
            </p>
        </div>

        <!-- ── STEP 2: Nickname ── -->
        <div id="step2" class="reg-step" style="display:none;">
            <div style="text-align:center; margin-bottom:24px;">
                <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">What's your nickname?</h2>
                <p style="color:#6b7280; font-size:14px; margin-top:6px;">This is how others will see you</p>
            </div>

            <input type="text" id="regNickname" placeholder="e.g. James, Amina, Alex..." maxlength="30"
                style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:14px 16px; font-size:16px; color:#111827; outline:none; box-sizing:border-box; margin-bottom:6px;">
            <p id="nicknameError" style="color:#ef4444; font-size:12px; margin-bottom:18px; display:none;">
                <i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>Nickname must be at least 2 characters
            </p>

            <div style="display:flex; gap:12px; margin-top:6px;">
                <button onclick="prevStep(2)" style="flex:1; border:2px solid #e5e7eb; background:white; color:#6b7280; font-weight:600; font-size:15px; padding:13px; border-radius:999px; cursor:pointer;">
                    <i class="fa-solid fa-arrow-left" style="margin-right:6px;"></i> Back
                </button>
                <button onclick="nextStep(2)" style="flex:2; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:999px; cursor:pointer;">
                    Continue <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
                </button>
            </div>
        </div>

        <!-- ── STEP 3: Phone + Email ── -->
        <div id="step3" class="reg-step" style="display:none;">
            <div style="text-align:center; margin-bottom:24px;">
                <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Contact details</h2>
                <p style="color:#6b7280; font-size:14px; margin-top:6px;">Your WhatsApp number & email</p>
            </div>

            <div style="margin-bottom:6px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">WhatsApp Number</label>
                <div style="display:flex; border:1.5px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                    <select id="countryCode" style="padding:12px 10px; background:#f9fafb; border:none; border-right:1.5px solid #e5e7eb; color:#374151; font-size:14px; outline:none;">
                        <option value="+254">🇰🇪 +254</option>
                        <option value="+255">🇹🇿 +255</option>
                        <option value="+256">🇺🇬 +256</option>
                        <option value="+234">🇳🇬 +234</option>
                        <option value="+233">🇬🇭 +233</option>
                        <option value="+27">🇿🇦 +27</option>
                        <option value="+44">🇬🇧 +44</option>
                        <option value="+1">🇺🇸 +1</option>
                        <option value="+33">🇫🇷 +33</option>
                    </select>
                    <input type="tel" id="regPhone" placeholder="712345678" maxlength="9" oninput="validatePhone()"
                        style="flex:1; border:none; outline:none; padding:12px 14px; font-size:15px; color:#111827;">
                </div>
                <p id="phoneError" style="color:#ef4444; font-size:12px; margin-top:4px; display:none;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>Must start with 7 or 1 and be exactly 9 digits
                </p>
            </div>

            <div style="margin-bottom:24px; margin-top:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Email Address</label>
                <input type="email" id="regEmail" placeholder="you@example.com" oninput="validateEmail()"
                    style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:13px 16px; font-size:15px; color:#111827; outline:none; box-sizing:border-box;">
                <p id="emailError" style="color:#ef4444; font-size:12px; margin-top:4px; display:none;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>Please enter a valid email address
                </p>
            </div>

            <div style="display:flex; gap:12px;">
                <button onclick="prevStep(3)" style="flex:1; border:2px solid #e5e7eb; background:white; color:#6b7280; font-weight:600; font-size:15px; padding:13px; border-radius:999px; cursor:pointer;">
                    <i class="fa-solid fa-arrow-left" style="margin-right:6px;"></i> Back
                </button>
                <button onclick="nextStep(3)" style="flex:2; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:999px; cursor:pointer;">
                    Continue <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
                </button>
            </div>
        </div>

        <!-- ── STEP 4: Age ── -->
        <div id="step4" class="reg-step" style="display:none;">
            <div style="text-align:center; margin-bottom:24px;">
                <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">How old are you?</h2>
                <p style="color:#6b7280; font-size:14px; margin-top:6px;">You must be 18 or older to join</p>
            </div>

            <div style="display:flex; align-items:center; justify-content:center; gap:24px; margin-bottom:12px;">
                <button onclick="changeAge(-1)"
                    style="width:48px; height:48px; border-radius:50%; border:2px solid #e5e7eb; background:white; font-size:18px; cursor:pointer; color:#720e9e; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <div style="text-align:center;">
                    <span id="ageDisplay" style="font-size:72px; font-weight:800; color:#720e9e; line-height:1;">18</span>
                    <p style="color:#6b7280; font-size:14px; margin:4px 0 0;">years old</p>
                </div>
                <button onclick="changeAge(1)"
                    style="width:48px; height:48px; border-radius:50%; border:2px solid #e5e7eb; background:white; font-size:18px; cursor:pointer; color:#720e9e; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>

            <input type="range" id="ageSlider" min="18" max="80" value="18" oninput="updateAge(this.value)"
                style="width:100%; accent-color:#720e9e; margin-bottom:24px; cursor:pointer;">

            <div style="display:flex; gap:12px;">
                <button onclick="prevStep(4)" style="flex:1; border:2px solid #e5e7eb; background:white; color:#6b7280; font-weight:600; font-size:15px; padding:13px; border-radius:999px; cursor:pointer;">
                    <i class="fa-solid fa-arrow-left" style="margin-right:6px;"></i> Back
                </button>
                <button onclick="nextStep(4)" style="flex:2; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:999px; cursor:pointer;">
                    Continue <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
                </button>
            </div>
        </div>

        <!-- ── STEP 5: Password ── -->
        <div id="step5" class="reg-step" style="display:none;">
            <div style="text-align:center; margin-bottom:24px;">
                <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Set your password</h2>
                <p style="color:#6b7280; font-size:14px; margin-top:6px;">Make it strong and memorable</p>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Password</label>
                <div style="position:relative;">
                    <input type="password" id="regPassword" placeholder="Min 8 characters" oninput="checkPasswordStrength()"
                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:13px 44px 13px 14px; font-size:15px; color:#111827; outline:none; box-sizing:border-box;">
                    <button type="button" onclick="togglePassword('regPassword')"
                        style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <!-- Strength bar -->
                <div style="display:flex; gap:4px; margin-top:8px;">
                    <div id="str1" style="flex:1; height:4px; border-radius:999px; background:#e5e7eb; transition:background 0.3s;"></div>
                    <div id="str2" style="flex:1; height:4px; border-radius:999px; background:#e5e7eb; transition:background 0.3s;"></div>
                    <div id="str3" style="flex:1; height:4px; border-radius:999px; background:#e5e7eb; transition:background 0.3s;"></div>
                    <div id="str4" style="flex:1; height:4px; border-radius:999px; background:#e5e7eb; transition:background 0.3s;"></div>
                </div>
                <p id="strengthLabel" style="font-size:12px; color:#9ca3af; margin-top:4px;"></p>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Confirm Password</label>
                <div style="position:relative;">
                    <input type="password" id="regPasswordConfirm" placeholder="Repeat your password"
                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:13px 44px 13px 14px; font-size:15px; color:#111827; outline:none; box-sizing:border-box;">
                    <button type="button" onclick="togglePassword('regPasswordConfirm')"
                        style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af;">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <p id="passwordMatchError" style="color:#ef4444; font-size:12px; margin-top:4px; display:none;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-right:4px;"></i>Passwords do not match
                </p>
            </div>

            <div style="display:flex; align-items:flex-start; gap:10px; margin-bottom:24px;">
                <input type="checkbox" id="regTerms" style="margin-top:3px; accent-color:#720e9e;">
                <label for="regTerms" style="font-size:13px; color:#6b7280; line-height:1.6;">
                    I agree to the <a href="{{ route('page.terms') }}" style="color:#720e9e;">Terms of Service</a> and <a href="{{ route('page.privacy') }}" style="color:#720e9e;">Privacy Policy</a>
                </label>
            </div>

            <div style="display:flex; gap:12px;">
                <button onclick="prevStep(5)" style="flex:1; border:2px solid #e5e7eb; background:white; color:#6b7280; font-weight:600; font-size:15px; padding:13px; border-radius:999px; cursor:pointer;">
                    <i class="fa-solid fa-arrow-left" style="margin-right:6px;"></i> Back
                </button>
                <button onclick="submitRegister()" style="flex:2; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:999px; cursor:pointer;">
                    <i class="fa-solid fa-heart" style="margin-right:8px;"></i> Create Account
                </button>
            </div>
        </div>

    </div>
</div>

<!-- ─── FORGOT PASSWORD MODAL ─── -->
<div id="forgotPasswordModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); z-index:101; width:100%; max-width:440px; padding:0 16px;">
    <div style="background:white; border-radius:5px; padding:40px; box-shadow:0 20px 60px rgba(0,0,0,0.3); position:relative;">

        <button onclick="closeAllModals()" style="position:absolute; top:16px; right:20px; background:none; border:none; font-size:20px; color:#9ca3af; cursor:pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>

@if($errors->resetPassword->any())
    <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:12px; padding:12px 16px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <i class="fa-solid fa-circle-exclamation" style="color:#ef4444; font-size:16px; flex-shrink:0;"></i>
        <p style="color:#dc2626; font-size:14px; margin:0;">{{ $errors->resetPassword->first() }}</p>
    </div>
@endif

        {{-- ── Step: enter email ── --}}
        <div id="fpStepEmail" style="{{ session('reset_step') && session('reset_step') !== 'email' ? 'display:none;' : '' }}">
            <div style="text-align:center; margin-bottom:24px;">
                <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Reset your password</h2>
                <p style="color:#6b7280; font-size:14px; margin-top:6px;">Enter your email and we'll send you a code</p>
            </div>

            <form method="POST" action="{{ route('password.send-code') }}">
                @csrf
                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Email Address</label>
                    <input type="email" name="email" placeholder="you@example.com" required
                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:13px 16px; font-size:15px; color:#111827; outline:none; box-sizing:border-box;">
                </div>
                <button type="submit" style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:5px; cursor:pointer;">
                    Send Reset Code
                </button>
            </form>

            <p style="text-align:center; color:#6b7280; font-size:14px; margin-top:20px;">
                <a href="#" onclick="switchModal('forgotPasswordModal','loginModal')" style="color:#720e9e; font-weight:600; text-decoration:none;">Back to sign in</a>
            </p>
        </div>

        {{-- ── Step: enter code ── --}}
        <div id="fpStepCode" style="{{ session('reset_step') === 'code' ? '' : 'display:none;' }}">
            <div style="text-align:center; margin-bottom:24px;">
                <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Enter the code</h2>
                <p style="color:#6b7280; font-size:14px; margin-top:6px;">We sent a 6-digit code to {{ session('reset_email') }}</p>
            </div>

            <form method="POST" action="{{ route('password.verify-code') }}">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Reset Code</label>
                    <input type="text" name="code" placeholder="123456" maxlength="6" required
                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:13px 16px; font-size:20px; text-align:center; letter-spacing:6px; color:#111827; outline:none; box-sizing:border-box;">
                </div>
                <button type="submit" style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:5px; cursor:pointer;">
                    Verify Code
                </button>
            </form>

            <p style="text-align:center; color:#6b7280; font-size:13px; margin-top:16px;">
                Didn't get it?
                <a href="{{ route('password.send-code') }}" onclick="event.preventDefault(); document.getElementById('resendForm').submit();" style="color:#720e9e; font-weight:600; text-decoration:none;">Resend code</a>
                <form id="resendForm" method="POST" action="{{ route('password.send-code') }}" style="display:none;">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('reset_email') }}">
                </form>
            </p>
        </div>

        {{-- ── Step: new password ── --}}
        <div id="fpStepPassword" style="{{ session('reset_step') === 'password' ? '' : 'display:none;' }}">
            <div style="text-align:center; margin-bottom:24px;">
                <h2 style="font-size:22px; font-weight:800; color:#111827; margin:0;">Set a new password</h2>
            </div>

            <form method="POST" action="{{ route('password.reset') }}">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                <input type="hidden" name="code" value="{{ session('reset_code') }}">

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">New Password</label>
                    <input type="password" name="password" placeholder="Min 8 characters" required
                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:13px 16px; font-size:15px; color:#111827; outline:none; box-sizing:border-box;">
                </div>

                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password" required
                        style="width:100%; border:1.5px solid #e5e7eb; border-radius:12px; padding:13px 16px; font-size:15px; color:#111827; outline:none; box-sizing:border-box;">
                </div>

                <button type="submit" style="width:100%; background:#720e9e; color:white; font-weight:700; font-size:16px; padding:14px; border:none; border-radius:5px; cursor:pointer;">
                    Reset Password
                </button>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // ── Modal controls ──
    function openModal(id) {
        document.getElementById('modalBackdrop').style.display = 'block';
        document.getElementById(id).style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeAllModals() {
        document.getElementById('modalBackdrop').style.display = 'none';
        document.querySelectorAll('[id$="Modal"]').forEach(m => m.style.display = 'none');
        document.body.style.overflow = '';
    }

    function switchModal(from, to) {
        document.getElementById(from).style.display = 'none';
        document.getElementById(to).style.display = 'block';
    }

    // ── Password toggle ──
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // ── Password strength ──
    function checkPasswordStrength() {
        const val = document.getElementById('regPassword').value;
        const bars = ['str1','str2','str3','str4'];
        let strength = 0;
        if (val.length >= 8) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;

        const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
        const labels = ['Weak','Fair','Good','Strong'];

        bars.forEach((b, i) => {
            document.getElementById(b).style.background = i < strength ? colors[strength - 1] : '#e5e7eb';
        });

        document.getElementById('strengthLabel').textContent = strength > 0 ? labels[strength - 1] : '';
        document.getElementById('strengthLabel').style.color = strength > 0 ? colors[strength - 1] : '#9ca3af';
    }

    // ── Phone validation ──
    function validatePhone() {
        const phone = document.getElementById('regPhone').value.trim();
        const error = document.getElementById('phoneError');
        const valid = /^[71]\d{8}$/.test(phone);
        error.style.display = valid || phone === '' ? 'none' : 'block';
        return valid;
    }

    // ── Email validation ──
    function validateEmail() {
        const email = document.getElementById('regEmail').value.trim();
        const error = document.getElementById('emailError');
        const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        error.style.display = valid || email === '' ? 'none' : 'block';
        return valid;
    }

    // ── Login phone validation ──
    function validateLoginPhone() {
        const phone = document.getElementById('loginPhone').value.trim();
        const error = document.getElementById('loginPhoneError');
        const valid = /^[71]\d{8}$/.test(phone);
        error.style.display = valid || phone === '' ? 'none' : 'block';
        return valid;
    }

    // ── Gender selection ──
    let selectedGender = '';
    let selectedLooking = '';

    function selectGender(val) {
        selectedGender = val;
        ['male','female'].forEach(g => {
            const isActive = g === val;
            document.getElementById('gender' + g.charAt(0).toUpperCase() + g.slice(1)).style.border = isActive ? '2px solid #720e9e' : '2px solid #e5e7eb';
            document.getElementById('gender' + g.charAt(0).toUpperCase() + g.slice(1)).style.background = isActive ? '#faf5ff' : 'white';
            document.getElementById('gender' + g.charAt(0).toUpperCase() + g.slice(1) + 'Circle').style.background = isActive ? '#720e9e' : 'transparent';
            document.getElementById('gender' + g.charAt(0).toUpperCase() + g.slice(1) + 'Circle').style.border = isActive ? '2px solid #720e9e' : '2px solid #d1d5db';
        });
    }

    function selectLooking(val) {
        selectedLooking = val;
        ['male','female','any'].forEach(g => {
            const isActive = g === val;
            document.getElementById('looking' + g.charAt(0).toUpperCase() + g.slice(1)).style.border = isActive ? '2px solid #720e9e' : '2px solid #e5e7eb';
            document.getElementById('looking' + g.charAt(0).toUpperCase() + g.slice(1)).style.background = isActive ? '#faf5ff' : 'white';
            document.getElementById('looking' + g.charAt(0).toUpperCase() + g.slice(1) + 'Circle').style.background = isActive ? '#720e9e' : 'transparent';
            document.getElementById('looking' + g.charAt(0).toUpperCase() + g.slice(1) + 'Circle').style.border = isActive ? '2px solid #720e9e' : '2px solid #d1d5db';
        });
    }

    // ── Age picker ──
    let selectedAge = 18;

    function updateAge(val) {
        selectedAge = parseInt(val);
        document.getElementById('ageDisplay').textContent = val;
        document.getElementById('ageSlider').value = val;
    }

    function changeAge(delta) {
        const newAge = Math.min(80, Math.max(18, selectedAge + delta));
        updateAge(newAge);
    }

    // ── Step navigation ──
    const stepLabels = ['','Step 1 of 5','Step 2 of 5','Step 3 of 5','Step 4 of 5','Step 5 of 5'];
    const stepPercents = ['','20%','40%','60%','80%','100%'];
    const stepWidths = ['','20%','40%','60%','80%','100%'];

    function showStep(n) {
        document.querySelectorAll('.reg-step').forEach(s => s.style.display = 'none');
        document.getElementById('step' + n).style.display = 'block';
        document.getElementById('stepLabel').textContent = stepLabels[n];
        document.getElementById('stepPercent').textContent = stepPercents[n];
        document.getElementById('progressBar').style.width = stepWidths[n];
    }

    function nextStep(current) {
        if (current === 1) {
            if (!selectedGender || !selectedLooking) {
                alert('Please select both options to continue.');
                return;
            }
        }
        if (current === 2) {
            const nick = document.getElementById('regNickname').value.trim();
            if (nick.length < 2) {
                document.getElementById('nicknameError').style.display = 'block';
                return;
            }
            document.getElementById('nicknameError').style.display = 'none';
        }
        if (current === 3) {
            const phoneValid = validatePhone();
            const emailValid = validateEmail();
            const phone = document.getElementById('regPhone').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            if (!phone || !email) { alert('Please fill in both fields.'); return; }
            if (!phoneValid) { document.getElementById('phoneError').style.display = 'block'; return; }
            if (!emailValid) { document.getElementById('emailError').style.display = 'block'; return; }
        }
        if (current === 4) {
            if (selectedAge < 18) { alert('You must be at least 18 years old.'); return; }
        }
        showStep(current + 1);
    }

    function prevStep(current) {
        showStep(current - 1);
    }

    function submitLogin() {
    const phoneValid = validateLoginPhone();
    const phone = document.getElementById('loginPhone').value.trim();
    const password = document.getElementById('loginPassword').value;

    if (!phone) { alert('Please enter your phone number.'); return; }
    if (!phoneValid) { document.getElementById('loginPhoneError').style.display = 'block'; return; }
    if (!password) { alert('Please enter your password.'); return; }

    const fullPhone = document.getElementById('loginCountryCode').value + phone;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("login") }}';

    const fields = {
        '_token': '{{ csrf_token() }}',
        'phone': fullPhone,
        'password': password,
    };

    Object.entries(fields).forEach(([key, val]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = val;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}
    function submitRegister() {
        const password = document.getElementById('regPassword').value;
        const confirm = document.getElementById('regPasswordConfirm').value;
        const terms = document.getElementById('regTerms').checked;

        if (password.length < 8) { alert('Password must be at least 8 characters.'); return; }
        if (password !== confirm) {
            document.getElementById('passwordMatchError').style.display = 'block';
            return;
        }
        document.getElementById('passwordMatchError').style.display = 'none';
        if (!terms) { alert('Please accept the terms to continue.'); return; }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/register';
        const fields = {
            '_token': '{{ csrf_token() }}',
            'gender': selectedGender,
            'interested_in': selectedLooking,
            'name': document.getElementById('regNickname').value,
            'phone': document.getElementById('countryCode').value + document.getElementById('regPhone').value,
            'email': document.getElementById('regEmail').value,
            'age': selectedAge,
            'password': password,
            'password_confirmation': confirm,
        };
        Object.entries(fields).forEach(([key, val]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = val;
            form.appendChild(input);
        });
        document.body.appendChild(form);
        form.submit();
    }

    // ── Auto-open forgot password modal on the right step after redirect ──
    @if(session('reset_step'))
        document.addEventListener('DOMContentLoaded', function () {
            openModal('forgotPasswordModal');
        });
    @endif

    @if(session('reset_success'))
        document.addEventListener('DOMContentLoaded', function () {
            alert('Password reset successfully! Please sign in with your new password.');
            openModal('loginModal');
        });
    @endif
</script>
@endpush
#fef2f2