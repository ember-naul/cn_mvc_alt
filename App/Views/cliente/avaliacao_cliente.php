<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Avaliação por Estrelas</title>
    <link rel="stylesheet" href="styles.css">
  <style>
      body {
          font-family: Arial, sans-serif;
          align-items: center; 
          height: 100vh;
          margin: 0; 
          background-color: #f4f4f4;
      }
      .rating-container {
          text-align: center;
          max-width: 100%;
          padding: 20px;
          box-sizing: border-box;
      }

        .stars {
            font-size: 2em; 
            color: #ccc;
            cursor: pointer;
            display: inline-flex;
        }

        .stars .star {
            display: inline-block;
            padding: 0 5px;
            transition: color 0.2s;
        }

        .stars .star.selected,
        .stars .star:hover,
        .stars .star:hover ~ .star {
            color: #ffcc00;
        }

        .rating-result {
            margin-top: 20px;
        }

        /* Media queries para dispositivos móveis */
        @media (max-width: 600px) {
            .stars {
                font-size: 1.5em; /* Reduz o tamanho das estrelas em telas menores */
            }
        }

        /* Media queries para tablets e telas maiores */
        @media (min-width: 601px) and (max-width: 1200px) {
            .stars {
                font-size: 1.8em; /* Ajusta o tamanho das estrelas para tablets */
            }
        }
  </style>
  </head>


    <div class="rating-container">
        <h3>Avalie o profissional que te atendeu!</h3>
        <div class="stars" id="rating-stars">
            <span data-value="1" class="star">☆</span>
            <span data-value="2" class="star">☆</span>
            <span data-value="3" class="star">☆</span>
            <span data-value="4" class="star">☆</span>
            <span data-value="5" class="star">☆</span>
        </div>
        <input type="hidden" id="rating-value" name="rating" value="0">
        <div class="rating-result">
            <p>Sua avaliação: <span id="rating-display">Nenhuma avaliação</span></p>
        </div>
        <input type="text" name="descricao">
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        var $stars = $('#rating-stars .star');
        var $ratingValue = $('#rating-value');
        var $ratingDisplay = $('#rating-display');
        
        $stars.on('mouseover', function() {
            var value = $(this).data('value');
            $stars.each(function() {
                $(this).toggleClass('selected', $(this).data('value') <= value);
            });
        });

        $stars.on('mouseout', function() {
            var value = $ratingValue.val();
            $stars.each(function() {
                $(this).toggleClass('selected', $(this).data('value') <= value);
            });
        });

        $stars.on('click', function() {
            var value = $(this).data('value');
            $ratingValue.val(value);
            $stars.each(function() {
                $(this).toggleClass('selected', $(this).data('value') <= value);
            });
            $ratingDisplay.text(value ? value + ' estrela(s)' : 'Nenhuma avaliação');
        });
    });

    </script>

