<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $formData['subject'] }}</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f6f9fc;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.829);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center;">{{ $formData['subject'] }}</h1>
        <p>
            You have recieved this mail from {{ $formData['name'] }}
        </p>

        <p>
            Here are the mail details:
        </p>

        <ul>
            <li style="margin: 0.6vh 0"><strong>Name:</strong> {{ $formData['name'] }}</li>
            <li style="margin: 0.6vh 0"><strong>Email:</strong> {{ $formData['email'] }}</li>
            <li style="margin: 0.6vh 0"><strong>Message:</strong><p style="text-align: center;">{{ $formData['message'] }}</p></li>
        </ul>

        {{-- <p>
            If you have any further questions or need immediate assistance, please feel free to reach out to us.
        </p> --}}

        <p>Thank you,</p>

        <p>Life Formula</p>
    </div>
</body>
</html>
