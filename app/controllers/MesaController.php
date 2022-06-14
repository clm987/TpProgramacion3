<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

use \App\Models\Mesa as Mesa;

class MesaController implements IApiUsable
{

    public function CargarUno($request, $response, $args)
    {
        //Recibimos los parametros
        $parametros = $request->getParsedBody();

        // $codigo_mesa = $parametros['codigo_mesa'];
        $estado = $parametros['estado'];
        $capacidad = $parametros['capacidad'];

        //Creamos el Mesa
        $auxMesa = new Mesa();
        $auxMesa->codigo_mesa = $auxMesa->GenerarCodigo();
        $auxMesa->estado = $estado;
        $auxMesa->capacidad = $capacidad;


        //Guardamos en la base el Mesa creado
        $auxMesa->save();

        $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // echo "entro a traer uno";
        // // Buscamos Mesa por nombre
        // $auxMesa = $args['nombre_Mesa'];
        // var_dump($auxMesa);

        // // Buscamos por primary key
        // // $Mesa = Mesa::find($usr);

        // // Buscamos por attr Mesa
        // $Mesa = Mesa::where('Mesa', $usr)->first();

        // $payload = json_encode($Mesa);

        // $response->getBody()->write($payload);
        // return $response
        //     ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::all();
        $payload = json_encode(array("listaMesa" => $lista));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usrModificado = $parametros['Mesa'];
        $MesaId = $args['id'];

        // Conseguimos el objeto
        $usr = Mesa::where('id', '=', $MesaId)->first();

        // Si existe
        if ($usr !== null) {
            // Seteamos un nuevo Mesa
            $usr->Mesa = $usrModificado;
            // Guardamos en base de datos
            $usr->save();
            $payload = json_encode(array("mensaje" => "Mesa modificado con exito"));
        } else {
            $payload = json_encode(array("mensaje" => "Mesa no encontrado"));
        }

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $MesaId = $args['id'];
        // Buscamos el Mesa
        $Mesa = Mesa::find($MesaId);
        // Borramos
        $Mesa->delete();

        $payload = json_encode(array("mensaje" => "Mesa borrado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
