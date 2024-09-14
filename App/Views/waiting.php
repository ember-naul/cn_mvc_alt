<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animação com Linha Giratória</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            overflow: hidden !important;
        }
        .container {
            text-align: center;
            padding: 0 2%;
        }
        .circle-wrapper {
            position: relative;
            width: 80vmin; /* Ajuste o tamanho com base na viewport */
            height: 80vmin; /* Ajuste o tamanho com base na viewport */
            margin: 0 auto;
        }
        .circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 5px solid #60c5ff;
            border-top: 5px solid transparent;
            animation: spin 2s linear infinite;
        }
        .gif-container {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 70%;
            height: 70%;
            transform: translate(-50%, -50%);
        }
        .gif-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Para manter a imagem proporcional */
        }
        .counter {
            font-size: 5vw; /* Tamanho da fonte proporcional à viewport */
            margin-top: 1rem; /* Margem superior ajustada */
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top: 5vh;">
        <div class="circle-wrapper">
            <div class="circle"></div>
            <div class="gif-container">
                <img src="assets/img/waiting.gif" alt="Loading">
            </div>
        </div>
        <div class="counter" id="counter">00:00</div>
    </div>
    <script>
        // Timer script
        let startTime = Date.now();
        const counterElement = document.getElementById('counter');
        
        function updateCounter() {
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            const minutes = String(Math.floor(elapsed / 60)).padStart(2, '0');
            const seconds = String(elapsed % 60).padStart(2, '0');
            counterElement.textContent = `${minutes}:${seconds}`;
        }
        
        setInterval(updateCounter, 1000);
    </script>
</body>
</html>
