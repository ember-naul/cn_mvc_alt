document.getElementById('cep').addEventListener('input', function() {
    const cep = this.value.replace(/\D/g, ''); 
    if (cep.length <= 8) {
        const formattedCep = cep.replace(/(\d{5})(\d{0,3})/, '$1-$2');
        this.value = formattedCep;
    }

    if (cep.length === 8) { 
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('endereco').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                } else {
                    alert('CEP não encontrado.');
                    document.getElementById('cep').value = '';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar CEP:', error);
                alert('Erro ao buscar CEP.');
                document.getElementById('cep').value = '';
            });
    }
});
