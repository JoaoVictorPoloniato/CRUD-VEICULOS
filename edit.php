<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Veículo</title>
</head>
<body>
    <h1>Editar Veículo</h1>

    <form id="editForm">
        <input type="hidden" name="id">
        <input type="text" name="marca" placeholder="Marca" required>
        <input type="text" name="modelo" placeholder="Modelo" required>
        <input type="number" name="ano" placeholder="Ano" required>
        <input type="text" name="placa" placeholder="Placa" required>
        <input type="text" name="cor" placeholder="Cor" required>
        <input type="text" name="tipo_de_veiculo" placeholder="Tipo de Veículo" required>
        <input type="text" name="renavam" placeholder="Renavam" required>
        <button type="submit">Atualizar</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Obter o ID do veículo a partir da URL
            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');

            // Fazer uma requisição AJAX para obter os dados do veículo pelo ID
            $.ajax({
                url: "crud.php",
                type: "POST",
                data: { action: "getById", id: id },
                success: function (response) {
                    var veiculo = JSON.parse(response);

                    // Preencher os campos do formulário com os dados do veículo
                    $("#editForm input[name='id']").val(veiculo.id);
                    $("#editForm input[name='marca']").val(veiculo.marca);
                    $("#editForm input[name='modelo']").val(veiculo.modelo);
                    $("#editForm input[name='ano']").val(veiculo.ano);
                    $("#editForm input[name='placa']").val(veiculo.placa);
                    $("#editForm input[name='cor']").val(veiculo.cor);
                    $("#editForm input[name='tipo_de_veiculo']").val(veiculo.tipo_de_veiculo);
                    $("#editForm input[name='renavam']").val(veiculo.renavam);
                }
            });

            // Manipular o envio do formulário de edição
            $("#editForm").submit(function (event) {
                event.preventDefault();

                // Realizar a requisição AJAX para atualizar o veículo
                $.ajax({
                    url: "crud.php",
                    type: "POST",
                    data: $("#editForm").serialize(),
                    success: function (response) {
                        alert(response); // Exibir uma mensagem de sucesso ou erro
                        window.location.href = "index.php"; // Redirecionar para a página inicial
                    }
                });
            });
        });
    </script>
</body>
</html>