<?php
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

use \App\Models\Pedido as Pedido;

class PedidoController implements IApiUsable
{

    public function CargarUno($request, $response, $args)
    {
        //Recibimos los parametros
        $parametros = $request->getParsedBody();

        $id_usuario_mozo = $parametros['id_usuario_mozo'];
        $codigo_mesa = $parametros['codigo_mesa'];
        $lista_productos =  $parametros['listado_id_productos'];
        $array_productos = explode(",", $lista_productos);
        $codigo_pedido = Pedido::GenerarCodigo();
        // $array_id_productos = [];
        for ($i = 0; $i < count($array_productos); $i++) {
            // array_push($array_id_productos, intval($array_productos[$i]));
            //Creamos el Pedido
            $auxPedido = new Pedido();
            $auxPedido->codigo_pedido = $codigo_pedido;
            $auxPedido->id_usuario_mozo = $id_usuario_mozo;
            $auxPedido->codigo_mesa = $codigo_mesa;
            $auxPedido->estado_pedido = 'pendiente';
            $auxPedido->id_producto = intval($array_productos[$i]);
            //Guardamos en la base el Pedido creado
            $auxPedido->save();
        }
        // var_dump($array_id_productos);
        $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        // Buscamos Pedido por nombre
        var_dump($args);
        $usr = $args['Pedido'];

        // Buscamos por primary key
        // $Pedido = Pedido::find($usr);

        // Buscamos por attr Pedido
        $Pedido = Pedido::where('Pedido', $usr)->first();
        var_dump($Pedido);

        $payload = json_encode($Pedido);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::all();
        $payload = json_encode(array("listaPedido" => $lista));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usrModificado = $parametros['Pedido'];
        $PedidoId = $args['id'];

        // Conseguimos el objeto
        $usr = Pedido::where('id', '=', $PedidoId)->first();

        // Si existe
        if ($usr !== null) {
            // Seteamos un nuevo Pedido
            $usr->Pedido = $usrModificado;
            // Guardamos en base de datos
            $usr->save();
            $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));
        } else {
            $payload = json_encode(array("mensaje" => "Pedido no encontrado"));
        }

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $PedidoId = $args['id'];
        // Buscamos el Pedido
        $Pedido = Pedido::find($PedidoId);
        // Borramos
        $Pedido->delete();

        $payload = json_encode(array("mensaje" => "Pedido borrado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
