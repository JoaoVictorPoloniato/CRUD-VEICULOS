<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Veículos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1, h2 {
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .btn-danger {
            background-color: #f44336;
            color: white;
            border: none;
        }

        #editModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        #editModal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            width: 50%;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);
        }

        #editModal h2 {
            margin-top: 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
</head>
<body>
    <h1>CRUD Veículos</h1>

    <h2>Adicionar Veículo</h2>
    <form id="addForm">
        <input type="text" name="marca" placeholder="Marca" required>
        <input type="text" name="modelo" placeholder="Modelo" required>
        <input type="number" name="ano" placeholder="Ano" required>
        <input type="text" name="placa" placeholder="Placa" required>
        <input type="text" name="cor" placeholder="Cor" required>
        <input type="text" name="tipo_de_veiculo" placeholder="Tipo de Veículo" required>
        <input type="number" name="renavam" placeholder="Renavam" required>
        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form>

    <h2>Veículos</h2>
    <table id="veiculosTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th>Placa</th>
                <th>Cor</th>
                <th>Tipo de Veículo</th>
                <th>Renavam</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div id="editModal">
        <div id="editModal-content">
            <h2>Editar Veículo</h2>
            <form id="editForm">
                <input type="hidden" name="id">
                <input type="text" name="marca" placeholder="Marca" required>
                <input type="text" name="modelo" placeholder="Modelo" required>
                <input type="number" name="ano" placeholder="Ano" required>
                <input type="text" name="placa" placeholder="Placa" required>
                <input type="text" name="cor" placeholder="Cor" required>
                <input type="number" name="tipo_de_veiculo" placeholder="Tipo de Veículo" required>
                <input type="text" name="renavam" placeholder="Renavam" required>
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <button type="button" onclick="cancelEdit()" class="btn btn-danger">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        function loadVeiculos() {
            $.ajax({
                url: "crud.php",
                type: "POST",
                data: { action: "read" },
                success: function (response) {
                    var veiculos = JSON.parse(response);

                    var tbody = $("#veiculosTable tbody");
                    tbody.empty();

                    for (var i = 0; i < veiculos.length; i++) {
                        var veiculo = veiculos[i];

                        var row = "<tr>" +
                            "<td>" + veiculo.id + "</td>" +
                            "<td>" + veiculo.marca + "</td>" +
                            "<td>" + veiculo.modelo + "</td>" +
                            "<td>" + veiculo.ano + "</td>" +
                            "<td>" + veiculo.placa + "</td>" +
                            "<td>" + veiculo.cor + "</td>" +
                            "<td>" + veiculo.tipo_de_veiculo + "</td>" +
                            "<td>" + veiculo.renavam + "</td>" +
                            "<td>" +
                            "<button onclick='editVeiculo(" + veiculo.id + ")' class='btn btn-primary'>Editar</button> " +
                            "<button onclick='deleteVeiculo(" + veiculo.id + ")' class='btn btn-danger'>Excluir</button>" +
                            "</td>" +
                            "</tr>";

                        tbody.append(row);
                    }
                }
            });
        }

        $("#addForm").submit(function (event) {
            event.preventDefault();

            if ($("#addForm").valid()) {
                $.ajax({
                    url: "crud.php",
                    type: "POST",
                    data: $("#addForm").serialize() + "&action=create",
                    success: function (response) {
                        alert(response);
                        loadVeiculos();
                        $("#addForm")[0].reset();
                    }
                });
            }
        });

        function editVeiculo(id) {
            $.ajax({
                url: "crud.php",
                type: "POST",
                data: { action: "getById", id: id },
                success: function (response) {
                    var veiculo = JSON.parse(response);

                    $("#editForm input[name='id']").val(veiculo.id);
                    $("#editForm input[name='marca']").val(veiculo.marca);
                    $("#editForm input[name='modelo']").val(veiculo.modelo);
                    $("#editForm input[name='ano']").val(veiculo.ano);
                    $("#editForm input[name='placa']").val(veiculo.placa);
                    $("#editForm input[name='cor']").val(veiculo.cor);
                    $("#editForm input[name='tipo_de_veiculo']").val(veiculo.tipo_de_veiculo);
                    $("#editForm input[name='renavam']").val(veiculo.renavam);

                    $("#editModal").show();
                }
            });
        }

        $("#editForm").submit(function (event) {
            event.preventDefault();

            if ($("#editForm").valid()) {
                $.ajax({
                    url: "crud.php",
                    type: "POST",
                    data: $("#editForm").serialize() + "&action=update",
                    success: function (response) {
                        alert(response);
                        loadVeiculos();
                        cancelEdit();
                    }
                });
            }
        });

        function cancelEdit() {
            $("#editModal").hide();
        }

        function deleteVeiculo(id) {
            if (confirm("Tem certeza que deseja excluir este veículo?")) {
                $.ajax({
                    url: "crud.php",
                    type: "POST",
                    data: { action: "delete", id: id },
                    success: function (response) {
                        alert(response);
                        loadVeiculos();
                    }
                });
            }
        }

        $(document).ready(function () {
            loadVeiculos();
        });
    </script>
</body>
</html>
