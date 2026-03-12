<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم تغيير كلمة السر بنجاح</title>
    <style>
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
        
        .success-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease-out forwards;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background-color: #4CAF50;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            animation: bounceIn 0.6s ease-out;
        }
        
        .success-icon svg {
            width: 40px;
            height: 40px;
            color: white;
        }
        
        h1 {
            color: #2d3748;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 700;
        }
        
        p {
            color: #4a5568;
            margin-bottom: 25px;
            line-height: 1.6;
            font-size: 16px;
        }
        
        .home-link {
            display: inline-block;
            background-color: #805ad5;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        
        .home-link:hover {
            background-color: #6b46c1;
            transform: translateY(-2px);
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes bounceIn {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }
            60% {
                transform: scale(1.1);
                opacity: 1;
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1>تم تغيير كلمة السر بنجاح!</h1>
        <p>تم تغيير كلمة السر الخاصة بحسابك بنجاح. يمكنك الآن تسجيل الدخول باستخدام كلمة السر الجديدة.</p>
        <!-- <a href="/" class="home-link">العودة إلى الصفحة الرئيسية</a>  -->
    </div>
</body>
</html>