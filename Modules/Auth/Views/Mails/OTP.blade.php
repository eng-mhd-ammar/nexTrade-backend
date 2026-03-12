<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ar" dir="rtl">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>رمز التحقق</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet" type="text/css">
  <style type="text/css">
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #1D4ED8, #2563EB);
      font-family: 'Cairo', Helvetica, Arial, sans-serif;
      direction: rtl;
    }

    table {
      border-spacing: 0;
    }

    td {
      padding: 0;
    }

    img {
      border: 0;
    }

    .email-container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .content {
      padding: 32px 24px;
      color: #1F2937;
      direction: rtl;
    }

    .content h1 {
      color: #9333EA;
      margin-bottom: 20px;
      font-size: 24px;
      direction: rtl;
    }

    .content p {
      font-size: 16px;
      margin-bottom: 16px;
      color: #374151;
      direction: rtl;
    }

    .otp-code {
      display: block;
      font-size: 28px;
      font-weight: bold;
      color: #1E293B;
      background-color: #F1F5F9;
      padding: 14px 24px;
      border-radius: 8px;
      letter-spacing: 4px;
      margin: 30px auto;
      width: fit-content;
      text-align: center;
    }

    .footer {
      text-align: center;
      font-size: 12px;
      color: #9CA3AF;
      padding: 20px;
      background-color: #F9FAFB;
      direction: rtl;
    }

    @media screen and (max-width: 600px) {
      .email-container {
        width: 90% !important;
        margin: 20px auto;
      }

      .content {
        padding: 20px 16px;
      }

      .content h1 {
        font-size: 20px !important;
      }

      .otp-code {
        font-size: 22px !important;
        padding: 10px 16px;
      }
    }
  </style>
</head>

<body>
  <table role="presentation" width="100%">
    <tr>
      <td align="center">
        <table class="email-container" role="presentation" width="100%">
          <tr>
            <td style="text-align: center; padding: 20px;">
              <img src="https://in-syria.com/MainLogo.png" alt="شعار Oxi24" width="120" style="max-width: 100%;">
            </td>
          </tr>
          <tr>
            <td class="content">
              <h1>رمز التحقق الخاص بك</h1>
              <p>مرحبًا،</p>
              <p>استخدم رمز التحقق التالي لتسجيل الدخول إلى حسابك:</p>
              <div class="otp-code">{{$otp_code}}</div>
              <p>إذا لم تطلب هذا الرمز، يمكنك تجاهل هذه الرسالة بأمان.</p>
              <p>مع تحيات فريق العمل،<br>{{ $name }}</p>
            </td>
          </tr>
          <tr>
            <td class="footer">
              © {{ date('Y') }} Oxi24 جميع الحقوق محفوظة.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
