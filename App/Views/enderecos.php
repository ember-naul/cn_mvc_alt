<?php

$usuarios = \App\Models\Usuario::all();
$clientes = \App\Models\Cliente::all();
$profissionais = \App\Models\Profissional::all();

echo "<div style='display: flex; justify-content: center; align-content: center;'>";
echo "<table style='border-collapse: collapse; width: 100%; max-width: 750px;'>"; // Definindo um tamanho máximo para a tabela
echo "<thead style='background-color: cyan;'>
        <tr>
            <th>Nome</th>
            <th>ID</th>
            <th colspan='2'>Email</th>
            <th></th>
            <th></th>
        </tr>
      </thead>";
foreach ($usuarios as $usuario) {
    echo "<tr style='background-color: #f3f3f3;'>";
    echo "<td style='width: 33%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>".$usuario->nome."</td>"; // Evitar quebra de linha
    echo "<td style='width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>".$usuario->id."</td>";
    echo "<td style='width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; colspan='2''>".$usuario->email."</td>";
    echo "<td style='width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'></td>";
    echo "<td style='width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'></td>";
    echo "</tr>";
}
echo "<thead style='background-color: cyan;'>
        <tr>
            <th>Nome (Usuario)</th>
            <th>ID (C)</th>
            <th>ID_Usuario</th>
            <th>Latitude</th>
            <th>Longitude</th>
        </tr>
      </thead>";
foreach ($clientes as $cliente){
    echo "<tr style='background-color: oldlace;'>";
    echo "<td style='width: 40%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $cliente->usuario->nome."</td>";
    echo "<td style='width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $cliente->id."</td>";
    echo "<td style='width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $cliente->id_usuario."</td>";
    echo "<td style='width: 25%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $cliente->latitude."</td>";
    echo "<td style='width: 25%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $cliente->longitude."</td>";
    echo "</tr>";
}
echo "<thead style='background-color: cyan;'>
        <tr>
            <th>Nome (Usuario)</th>
            <th>ID (P)</th>
            <th>ID_Usuario</th>
            <th>Latitude</th>
            <th>Longitude</th>
        </tr>
      </thead>";
foreach ($profissionais as $profissional){
    echo "<tr style='background-color: antiquewhite;'>";
    echo "<td style='width: 40%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $profissional->usuario->nome."</td>";
    echo "<td style='width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $profissional->id."</td>";
    echo "<td style='width: 10%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $profissional->id_usuario."</td>";
    echo "<td style='width: 25%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $profissional->latitude."</td>";
    echo "<td style='width: 25%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'>" . $profissional->longitude."</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";
