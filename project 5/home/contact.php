<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactpagina</title>
    <link rel="stylesheet" href="../css/header.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .contact-info {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contact-info h2 {
            margin-bottom: 20px;
        }
        .contact-info p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            text-decoration: none;
            color: #333;
            margin-right: 15px;
            font-size: 18px;
        }
        .social-links a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <nav>
        <a class="navbar-brand" href="#">Drive Smart</a>
        <a href="../home/home.php">Home</a>
        <a href="../login/login.php">Inloggen</a>
        <a href="contact.php">Contact</a>
    </nav>

    <header>
        <h1>Contacteer Ons</h1>
    </header>

    <div class="container">
        <div class="contact-info">
            <h2>Onze Contactgegevens</h2>
            <p><strong>Telefoonnummer:</strong> +31 6 12345678</p>
            <p><strong>E-mail:</strong> contact@.com</p>
            <p><strong>Adres:</strong> Straatnaam 123, 1234 AB, Stad, Nederland</p>
            
            <div class="social-links">
                <h3>Volg ons op Social Media:</h3>
                <a href="https://www.facebook.com/voorbeeld" target="_blank">Facebook</a>
                <a href="https://www.instagram.com/voorbeeld" target="_blank">Instagram</a>
                <a href="https://www.linkedin.com/company/voorbeeld" target="_blank">LinkedIn</a>
                <a href="https://twitter.com/voorbeeld" target="_blank">Twitter</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Rijschool Naam - Alle rechten voorbehouden</p>
        <p><a href="#">Algemene Voorwaarden</a> | <a href="#">Privacybeleid</a></p>
    </footer>
</body>
</html>
