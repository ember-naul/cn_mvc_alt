<main class="main d-flex align-items-center justify-content-center" style="width: 100%;">
    <div class="container" style="width: 100%;">
        <div class="row justify-content-center">
            <div class="col-md-6" style="width: 100%;">
                <div class="card shadow">
                    <div class="card-body" style="padding: 20%;">
                        <h1>Enviar um Arquivo</h1>
                        <form id="uploadForm" action="/upload-imagem" method="post" enctype="multipart/form-data">
                            <label for="file">Escolha um arquivo:</label>
                            <input type="file" name="file" id="file" accept=".png, .jpg, .jpeg, .svg, .webp, .avif"
                                   style="display: none;">
                            <div id="drop-zone"
                                 style="border: 2px dashed #ccc; border-radius: 10px; padding: 20px; text-align: center;">
                                Arraste e solte o arquivo aqui ou clique para selecionar
                            </div>
                            <br><br>
                            <button type="button" id="save-button" style="display: none;">Salvar Imagem</button>
                            <input type="submit" value="Enviar" id="send-button" style="display: none;">
                            <input type="hidden" name="croppedImage" id="croppedImage">
                        </form>

                        <div id="cropper-container" style="display: none;">
                            <img id="image" src="" alt="Imagem para recorte"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file');
    const croppedImageInput = document.getElementById('croppedImage');
    let cropper;
    let croppedImage;
    let originalFileName;

    dropZone.addEventListener('click', () => {
        fileInput.click();
    });

    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropZone.classList.add('hover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('hover');
    });

    dropZone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropZone.classList.remove('hover');

        const files = event.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (validateFileType(file)) {
                originalFileName = file.name;
                validateImage(file);
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
            } else {
                alert('Por favor, envie apenas arquivos de imagem (PNG, JPG/JPEG, WEBP, AVIF).');
            }
        }
    });


    fileInput.addEventListener('change', (event) => {
        if (event.target.files.length > 0) {
            const file = event.target.files[0];
            if (validateFileType(file)) {
                originalFileName = file.name;
                validateImage(file);
            } else {
                alert('Por favor, envie apenas arquivos de imagem (PNG, JPG/JPEG, WEBP, AVIF).');
                fileInput.value = '';
                dropZone.textContent = 'Arraste e solte o arquivo aqui ou clique para selecionar';
            }
        }
    });

    function validateFileType(file) {
        const validTypes = ['image/png', 'image/jpeg', 'image/webp', 'image/avif'];
        return validTypes.includes(file.type);
    }

    function validateImage(file) {
        const img = new Image();
        const reader = new FileReader();

        reader.onload = function (event) {
            img.src = event.target.result;

            img.onload = function () {
                document.getElementById('cropper-container').style.display = 'block';
                document.getElementById('image').src = img.src;

                if (cropper) {
                    cropper.destroy();
                }

                cropper = new Cropper(document.getElementById('image'), {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    restore: true,
                    modal: true,
                    guides: true,
                    center: true,
                    highlight: true,
                });

                document.getElementById('save-button').style.display = 'block';
                document.getElementById('send-button').style.display = 'none';
            };
        };

        reader.readAsDataURL(file);
    }

    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        const fileInput = document.getElementById('file');

        // Verifica se há um arquivo selecionado
        if (fileInput.files.length === 0) {
            fileInput.style.display = 'block'; // Mostra o campo
            fileInput.focus(); // Foca no campo
            alert('Por favor, selecione uma imagem antes de enviar.');
            event.preventDefault(); // Previne o envio do formulário
        }
    });



    document.getElementById('save-button').addEventListener('click', function () {
        if (!originalFileName) {
            alert('Por favor, selecione uma imagem primeiro.');
            return;
        }

        const canvas = cropper.getCroppedCanvas({
            width: 200,
            height: 200,
        });

        canvas.toBlob(function (blob) {
            const file = new File([blob], originalFileName, {type: 'image/png'});
            croppedImage = file;
            dropZone.textContent = file.name;

            const reader = new FileReader();
            reader.onloadend = function () {
                croppedImageInput.value = reader.result; // Armazena a imagem no campo oculto
            };
            reader.readAsDataURL(file);

            document.getElementById('cropper-container').style.display = 'none';
            document.getElementById('send-button').style.display = 'block';
        });
    });
</script>

<style>
    #drop-zone {
        cursor: pointer;
    }

    #drop-zone.hover {
        background-color: #f0f0f0;
    }
</style>
