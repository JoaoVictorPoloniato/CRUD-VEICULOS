<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Início</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
       
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="C:/xampp/htdocs/logo.png" alt="Logo">
        </div>
        <form method="post" action="acao.php" autocomplete="off" onsubmit="return redirecionar()">
            <div class="form-group">
                <label for="user"><strong>Usuário</strong></label>
                <input type="text" name="User" id="user" required>
            </div>
        
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" required>
            </div>
        
            <div class="form-group">
                <input type="submit" value="ENTRAR">
            </div>
        </form>
    </div>
    
    <script>
        function redirecionar() {
            
            var usuario = document.getElementById("user").value;
            
            var senha = document.getElementById("password").value;
            
            if (usuario === "joao", "kaila", "gladson", "feted" && senha === "1", "1", "1", "1") {
                
                window.location.href = "index.php";
                return false; 
            } else {
           
                alert("Usuário ou senha inválidos!");
                return false; 
            }
        }
    </script>
</body>
</html>