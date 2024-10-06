<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Profissional;

class LocalizacaoController extends Controller
{
    public function enviar_cliente()
    {
         $clienteId = $_SESSION['cliente_id'];

        if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            $cliente = Cliente::find($clienteId);
            if ($cliente) {
                $cliente->latitude = $latitude;
                $cliente->longitude = $longitude;
                $cliente->save();
            }
        }
    }
    public function enviar_profissional()
    {
        $profissionalId = $_SESSION['profissional_id'];

        if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
            $latitude = $_POST['latitude'];
            $longitude = $_POST['longitude'];
            $profissional = Profissional::find($profissionalId);
            if ($profissional) {
                $profissional->latitude = $latitude;
                $profissional->longitude = $longitude;
                $profissional->save();
            }
        }
    }
}