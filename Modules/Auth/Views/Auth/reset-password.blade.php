{{-- <!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعادة تعيين كلمة المرور</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-6 offset-md-3">
        <div class="card shadow p-4">
            <h4 class="mb-3 text-center">إعادة تعيين كلمة المرور</h4>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if (isset($errors) && $errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(isset($errors) && $errors->has('error'))
    <div class="alert alert-danger">
        {{ $errors->first('error') }}
    </div>
@endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request()->get('email') }}">

                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور الجديدة</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">تحديث كلمة المرور</button>
            </form>
        </div>
    </div>
</div>

</body>
</html> --}}

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        /* Importing Google Fonts for Arabic */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Noto Kufi Arabic', sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .form-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }
        
        h1 {
            color: #2d3748;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
        }
        
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        input {
            width: 100%;
            padding: 12px 40px 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            background-color: #f8fafc;
        }
        
        input:focus {
            outline: none;
            border-color: #805ad5;
            box-shadow: 0 0 0 3px rgba(128, 90, 213, 0.2);
        }
        
        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        
        .global-error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 5px;
        }
        
        button[type="submit"] {
            width: 100%;
            background-color: #805ad5;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        button[type="submit"]:hover {
            background-color: #6b46c1;
        }
        
        button[type="submit"]:disabled {
            background-color: #a0aec0;
            cursor: not-allowed;
        }
        
        .toggle-password {
            position: absolute;
            left: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #718096;
            font-size: 18px;
            padding: 5px;
        }
        
        .success-message {
            text-align: center;
            color: #38a169;
            font-weight: 500;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>تغيير كلمة السر</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                {{-- <strong>حدثت بعض الأخطاء:</strong> --}}
                <ul>
                    @foreach ($errors->all() as $error)
                        @if (!in_array($error, [$errors->first('password'), $errors->first('password_confirmation')]))
                            <div class="global-error-message">{{ $error }}</div>
                        @endif

                    @endforeach
                </ul>
            </div>
        @endif
        <form id="passwordForm" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request()->get('email') }}">

            <div class="form-group">
                <label for="password">كلمة السر الجديدة</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password')">👁</button>
                </div>
                <div class="error-message" id="passwordError">كلمة السر يجب أن تحتوي على 8 أحرف على الأقل</div>
                @error('password')
                    <div class="global-error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">تأكيد كلمة السر</label>
                <div class="input-wrapper">
                    <input type="password" id="confirmPassword" name="password_confirmation" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword')">👁</button>
                </div>
                <div class="error-message" id="confirmError">كلمة السر غير متطابقة</div>
                @error('password_confirmation')
                    <div class="global-error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" id="submitBtn" disabled>تغيير كلمة السر</button>
            <div class="success-message" id="successMessage">تم تغيير كلمة السر بنجاح!</div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('passwordForm');
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('confirmPassword');
            const passwordError = document.getElementById('passwordError');
            const confirmError = document.getElementById('confirmError');
            const submitBtn = document.getElementById('submitBtn');
            const successMessage = document.getElementById('successMessage');

            // Validate password length on input
            passwordInput.addEventListener('input', function () {
                validatePassword();
                checkFormValidity();
            });

            // Validate password match on input
            confirmInput.addEventListener('input', function () {
                validateConfirmPassword();
                checkFormValidity();
            });

            // Prevent copy-paste actions for security
            [passwordInput, confirmInput].forEach(input => {
                input.addEventListener('paste', (e) => e.preventDefault());
                input.addEventListener('copy', (e) => e.preventDefault());
                input.addEventListener('cut', (e) => e.preventDefault());
            });

            // Handle form submission using fetch
            // form.addEventListener('submit', async function (e) {
            //     e.preventDefault();

            //     if (!validatePassword() || !validateConfirmPassword()) {
            //         return; // Stop submission if validation fails
            //     }

            //     // Disable the submit button during submission
            //     submitBtn.disabled = true;

            //     try {
            //         // Dummy API endpoint (replace with your actual URL)
            //         const response = await fetch('https://example.com/api/change-password', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //             },
            //             body: JSON.stringify({
            //                 password: passwordInput.value,
            //                 confirmPassword: confirmInput.value,
            //             }),
            //         });

            //         if (response.ok) {
            //             // Redirect to success page on successful submission
            //             window.location.href = '/success';
            //         } else {
            //             // Show error message if the server returns an error
            //             alert('Failed to update password. Please try again.');
            //         }
            //     } catch (error) {
            //         // Handle network errors
            //         console.error('Error submitting form:', error);
            //         alert('An error occurred. Please try again.');
            //     } finally {
            //         // Re-enable the submit button
            //         submitBtn.disabled = false;
            //     }
            // });

            // Validate password length
            function validatePassword() {
                if (passwordInput.value.length < 8) {
                    passwordError.style.display = 'block';
                    return false;
                }
                passwordError.style.display = 'none';
                return true;
            }

            // Validate password confirmation
            function validateConfirmPassword() {
                if (confirmInput.value !== passwordInput.value) {
                    confirmError.style.display = 'block';
                    return false;
                }
                confirmError.style.display = 'none';
                return true;
            }

            // Check overall form validity
            function checkFormValidity() {
                const isPasswordValid = passwordInput.value.length >= 8;
                const isConfirmValid = confirmInput.value === passwordInput.value && confirmInput.value !== '';
                submitBtn.disabled = !(isPasswordValid && isConfirmValid);
            }

            // Toggle password visibility
            window.togglePassword = function (fieldId) {
                const field = document.getElementById(fieldId);
                field.type = field.type === 'password' ? 'text' : 'password';
            };
        });
    </script>
</body>
</html>
