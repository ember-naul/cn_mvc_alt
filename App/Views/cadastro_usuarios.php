<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla {
            font-family: karla;
            
        }
        .hidden { display: none; }
    </style>
    <title>Cadastro</title>
  </head>

<img src="../IMAGENS/logo2.png" style="position: absolute; left: 95%; top:1.5%; width:5em;">
    <div class="font-[sans-serif]">
      <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
        <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">             
        <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto">
        <form id="multiStepForm" method='post' action='/novousuario' class="space-y-6">
                        <!-- Etapa 1 -->
                        <div class="mb-8">
                            <h3 class="text-gray-600 text-3xl font-extrabold">Vamos começar o cadastro da sua conta</h3>
                        </div>
                        <div id="step1">
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">Nome de usuário</label>
                                <div class="relative flex items-center">
                                    <input name="nome" type="text" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 mb-4 rounded-lg outline-blue-600" placeholder="Digite seu nome de usuário" />
                                </div>
                            </div>
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">Email</label>
                                <div class="relative flex items-center">
                                    <input name="email" type="email" required class="w-full text-sm text-gray-800 border border-gray-300 px-4 mb-4 py-3 rounded-lg outline-blue-600" placeholder="Digite seu email" />
                                </div>
                            </div>
                            <div class="flex justify-between">
                            
                                <button type="button" class="py-2 px-4 text-sm tracking-wide rounded-lg mb-2 text-white bg-blue-600 hover:bg-blue-700 focus:outline-none" onclick="nextStep(1)">Próximo</button>
                            </div>
                            <a href="/login" class="p-2"> Já possuo uma conta</a>
                        </div>

                        <!-- Etapa 2 -->
                        <div id="step2" class="hidden" style='margin-top:-5px;'>
                            <div>
                                <label class="text-gray-800 text-sm block">Celular</label>
                                <div class="relative flex items-center">
                                    <input name="celular" type="number" required class="w-full text-sm mb-2 text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Digite o número do seu celular" />
                                </div>
                            </div>
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">RG</label>
                                <div class="relative flex items-center">
                                    <input name="rg" type="number" required class="w-full text-sm text-gray-800 mb-4 border border-gray-300 px-4 mb-4 py-3 rounded-lg outline-blue-600" placeholder="Digite o seu RG" />
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <button type="button" class="py-2 px-4 text-sm tracking-wide rounded-lg text-white mb-2 bg-gray-600 hover:bg-gray-700 focus:outline-none" onclick="nextStep(0)">Anterior</button>
                                <button type="button" class="py-2 px-4 text-sm tracking-wide rounded-lg text-white mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none" onclick="nextStep(2)">Próximo</button>
                            </div>
                            <a href="/login" class="p-2"> Já possuo uma conta</a>
                        </div>

                        <!-- Etapa 3 -->
                        <div id="step3" class="hidden" style='margin-top:-5px;'>
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">CPF</label>
                                <div class="relative flex items-center">
                                    <input name="cpf" type="number" required class="w-full text-sm text-gray-800 border border-gray-300 mb-4 px-4 py-3 rounded-lg outline-blue-600" placeholder="Digite o seu CPF" />
                                </div>
                            </div>
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">Senha</label>
                                <div class="relative flex items-center">
                                    <input name="senha" type="password" required class="w-full text-sm text-gray-800 border border-gray-300 mb-4 px-4 py-3 rounded-lg outline-blue-600" placeholder="Digite sua senha" />
                                </div>
                            </div>
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">Confirmar Senha</label>
                                <div class="relative flex items-center">
                                    <input name="confirmar_senha" type="password" required class="w-full text-sm text-gray-800 border mb-4 border-gray-300 px-4 py-3 rounded-lg outline-blue-600" placeholder="Digite novamente a sua senha" />
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <button type="button" class="py-2 px-4 mb-4 text-sm tracking-wide rounded-lg text-white bg-gray-600 hover:bg-gray-700 focus:outline-none" onclick="nextStep(1)">Anterior</button>
                                <button type="submit" class="py-2 px-4 mb-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Cadastrar</button>
                            </div>
                            <a href="/login" class="p-2"> Já possuo uma conta</a>
                            <div class="col-12">
                    <div class="icheck-primary">
                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                    <label for="agreeTerms">
                        Concordo com os <a href="/termos">termos de uso</a>
                    </label>
                    </div>
                </div>
                        </div>
                    </form>

          </div>
          <div class="lg:h-[400px] md:h-[300px] max-md:mt-8">
            <img class="space-y-4" src="../../assets/img/login-img.png" width="568px" height="265px" class="w-full h-full max-md:w-4/5 mx-auto block object-cover" alt="Imagem de Cadastro" />
          </div>
        </div>
      </div>
    </div>

    <script>
        let currentStep = 1;

        function showStep(step) {
            document.querySelector(`#step${currentStep}`).classList.add('hidden');
            document.querySelector(`#step${step}`).classList.remove('hidden');
            currentStep = step;
        }

        function nextStep(step) {
            showStep(step + 1);
        }

        function prevStep(step) {
            showStep(step - 1);
        }
    </script>