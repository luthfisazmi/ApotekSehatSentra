<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #ffffff;
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative; /* Untuk menempatkan tombol X di pojok */
        }

        .card-header {
            background-color: #c0335e;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .card-header h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-bottom: 20px;
            object-fit: cover;
        }

        .name {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .email {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .joined {
            color: #007bff;
            font-weight: 500;
        }

        .details {
            font-size: 14px;
            color: #6c757d;
            margin-top: 20px;
            text-align: left;
            padding-left: 20px;
        }

        .details p {
            margin: 5px 0;
        }

        .details strong {
            color: #333;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 28px;
            color:rgb(255, 255, 255);
            cursor: pointer;
        }

        .close-btn:hover {
            color: #9b1d3e;
        }
    </style>
</head>
<body>

<div class="card">
    <!-- Tombol Kembali X -->
    <button class="close-btn" onclick="window.history.back();">&times;</button>
    
    <div class="card-header">
        <h2>Profil Pengguna</h2>
    </div>

    <div class="card-body">
        <!-- Avatar -->
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=100" alt="Avatar" class="avatar">
        
        <!-- Nama Pengguna -->
        <div class="name">{{ $user->name }}</div>
        
        <!-- Email Pengguna -->
        <div class="email">{{ $user->email }}</div>
        
        <!-- Tanggal Bergabung -->
        <div class="joined">Terdaftar sejak: {{ $user->created_at->format('d M Y') }}</div>
    </div>

    <!-- Detail Pengguna -->
    <div class="details">
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Terdaftar pada:</strong> {{ $user->created_at->format('d M Y') }}</p>
    </div>
</div>

</body>
</html>
