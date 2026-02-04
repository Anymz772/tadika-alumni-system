<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Tadika Alumni</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .thankyou-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .success-icon {
            color: #28a745;
            font-size: 4rem;
            margin-bottom: 20px;
        }
        .btn-home {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="thankyou-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h2 class="mb-3">Thank You!</h2>
            
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif
            
            <p class="mb-4">
                Your alumni registration has been submitted successfully. 
                Our team will review your information and you will be notified once your account is approved.
            </p>
            
            <div class="row mt-4">
                <div class="col-md-6 mb-2">
                    <a href="{{ route('survey.create') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-plus me-2"></i> Submit Another
                    </a>
                </div>
                <div class="col-md-6 mb-2">
                    <a href="{{ url('/') }}" class="btn btn-home w-100">
                        <i class="fas fa-home me-2"></i> Back to Home
                    </a>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="text-muted small">
                <p class="mb-1">
                    <i class="fas fa-clock me-1"></i> 
                    Approval usually takes 1-2 working days
                </p>
                <p class="mb-0">
                    <i class="fas fa-envelope me-1"></i> 
                    You will receive an email with login credentials upon approval
                </p>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>