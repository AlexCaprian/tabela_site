<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Banco de Dados</title>
</head>

<body>

    <div class="principal">

        <div class="gifs_01">
            <img src="./thanos-dance.gif" alt="Thanos Dançando">
        </div>

        <div class="tabela_main">
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
        </div>
        <div class="gifs">
            <img src="./thanos-dance.gif" alt="Thanos Dançando">
        </div>
    </div>
</body>

</html>