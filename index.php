<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Dados</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Courier New', Courier, monospace;
        }

        body {
            background-image: linear-gradient(to left, #FF9E00, #0086FF);
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        table {
            border-radius: 10px;
            border-collapse: collapse;
            overflow: hidden;
            border: 2px solid #000;
        }

        h2 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        th {
            font-size: 18px;
            padding: 10px;
            background-color: #f2f2f2;
        }

        /* Defina a cor de fundo padrão para td */
        td {
            padding: 8px;
            background-color: #f2f2f2;
            /* ou a cor desejada */
        }

        /* Adicione uma regra para linhas pares */
        tr:nth-child(even) td {
            background-color: white;
            /* ou a cor desejada para linhas pares */
        }



        .tb_data {
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #f1f1f1;
            color: #000;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .tb_centro {
            text-align: center;
        }

        .pagination .current {
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            padding: 8px 16px;
        }
    </style>
</head>

<body>
    <h2>Dados do Banco de Dados</h2>

    <?php include('conexao.php'); ?>
    <div class="container">
        <?php
        // Número de registros por página
        $registrosPorPagina = 13;

        // Página atual (obtida a partir do parâmetro de consulta)
        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

        // Consulta SQL para contar o número total de registros
        $sqlTotal = "SELECT COUNT(*) AS total FROM info";
        $resultTotal = $conn->query($sqlTotal);
        $rowTotal = $resultTotal->fetch_assoc();
        $totalRegistros = $rowTotal['total'];

        // Calcula o número total de páginas
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        // Calcula o índice de início para a consulta
        $indiceInicio = ($paginaAtual - 1) * $registrosPorPagina;

        // Consulta SQL para obter dados paginados
        $sql = "SELECT * FROM info LIMIT $indiceInicio, $registrosPorPagina";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Exibição da tabela
            echo "<table border='1'>";
            echo "<tr><th>Nome</th><th>Telefone</th><th>CEP</th><th>Data de Nascimento</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['nome']}</td><td>{$row['telefone']}</td><td class='tb_centro'>{$row['cep']}</td><td class='tb_centro'>{$row['data_nasc']}</td>";
                echo "</tr>";
            }

            echo "</table>";

            echo "<div class='pagination-container'>";
            echo "<div class='pagination'>";

            // Botão para a primeira página
            if ($paginaAtual > 1) {
                echo "<a href='?pagina=1'>&laquo;&laquo;</a> ";
            }

            // Botão para a página anterior
            if ($paginaAtual > 1) {
                $paginaAnterior = $paginaAtual - 1;
                echo "<a href='?pagina=$paginaAnterior'>&laquo;</a> ";
            }

            // Exibir até 5 links de páginas
            $linksParaExibir = 5;

            $paginaInicial = max(1, $paginaAtual - floor($linksParaExibir / 2));
            $paginaFinal = min($totalPaginas, $paginaInicial + $linksParaExibir - 1);

            for ($i = $paginaInicial; $i <= $paginaFinal; $i++) {
                if ($i == $paginaAtual) {
                    echo "<span class='current'>$i</span> ";
                } else {
                    echo "<a href='?pagina=$i'>$i</a> ";
                }
            }

            // Botão para a página seguinte
            if ($paginaAtual < $totalPaginas) {
                $paginaSeguinte = $paginaAtual + 1;
                echo "<a href='?pagina=$paginaSeguinte'>&raquo;</a> ";
            }

            // Botão para a última página
            if ($paginaAtual < $totalPaginas) {
                echo "<a href='?pagina=$totalPaginas'>&raquo;&raquo;</a> ";
            }

            echo "</div>";
            echo "</div>";

        } else {
            echo "<p>Nenhum resultado encontrado.</p>";
        }

        // Fecha a conexão
        $conn->close();
        ?>
    </div>
</body>

</html>