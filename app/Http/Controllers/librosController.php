<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class librosController extends Controller
{
    public function obtenerLibros()
    {
        $datos = [
            ['id' => 1, 'nombre' => 'Harry Potter y la piedra filosofal'],
            ['id' => 2, 'nombre' => 'Harry Potter y la cámara secreta'],
            ['id' => 3, 'nombre' => 'Harry Potter y el prisionero de Azkaban']
        ];
        return $datos;
    }

    public function obtenerLibro($id)
    {
        $datos = [
            ['id' => 1, 'nombre' => 'Harry Potter y la piedra filosofal'],
            ['id' => 2, 'nombre' => 'Harry Potter y la cámara secreta'],
            ['id' => 3, 'nombre' => 'Harry Potter y el prisionero de Azkaban']
        ];
        $res = array_filter($datos, function ($item) use ($id) {
            return $item['id'] == $id;
        });
        return $res;
    }

    public function obtenerLibrosv2(Request $request)
    {
        $datos = [
            ['id' => 1, 'nombre' => 'Harry Potter y la piedra filosofal'],
            ['id' => 2, 'nombre' => 'Harry Potter y la cámara secreta'],
            ['id' => 3, 'nombre' => 'Harry Potter y el prisionero de Azkaban']
        ];
        $nombre = $request->query('nombre');
        $res = array_filter($datos, fn ($item) => str_contains($item['nombre'], $nombre));
        return $res;
    }
}
