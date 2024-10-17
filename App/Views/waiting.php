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
        position:relative;
        text-align: center;
        padding: 0 2%;
        margin:auto;
        width: 30%;
        height: auto;
        margin-top:10rem;
    }
    .circle-wrapper {
        position: relative;
        width: 40vmin;
        height: 40vmin;
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
        width: 80%;
        height: 80%;
        transform: translate(-50%, -50%);
    }
    .gif-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .counter {
        font-size: 2vw;
        margin-top: 1rem;
    }
    .cancel-wrapper {
        display: inline-block;
        margin-top: 2rem;
        cursor: pointer;
        text-align: center;
        width:10%
    }
    .cancel-wrapper img {
        width: 50%;
        height: 50%;
    }
    .cancel-wrapper img:hover {
        opacity: 0.7;
    }
    .cancel-text {
        margin-top: 0.5rem;
        font-size: 1vw;
        color: #ff0000;
    }
    h3 {
        font-size: 1.5vw;
        margin-bottom: 1rem;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @media screen and (max-width: 768px) {
        .container {
            width: 80%;
            height: auto;
        }
        .circle-wrapper {
            width: 60vmin;
            height: 60vmin;
        }
        .counter {
            font-size: 4vw;
        }
        h3 {
            font-size: 4vw;
        }
        .cancel-wrapper {
            margin-top: 1rem;
            width:20%;
            height:20%;
        }
        .cancel-text {
            font-size: 2.5vw;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <h3>Encontrando o profissional mais próximo a você...</h3>
        <div class="circle-wrapper">
            <div class="circle"></div>
            <div class="gif-container">
                <img src="assets/img/waiting.gif" alt="Loading">
            </div>
        </div>
        <div class="counter" id="counter">00:00</div>

        <!-- Botão e texto dentro de uma área clicável -->
        <div class="cancel-wrapper" onclick="cancelSearch()">
            <img src="assets/img/cancelar.png" alt="Cancelar">
            <div class="cancel-text">Cancelar</div>
        </div>
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

        // Função para cancelar a busca
        function cancelSearch() {
            window.location.href = "/home"; // Redireciona para /home
        }
    </script>
</body>
</html>
