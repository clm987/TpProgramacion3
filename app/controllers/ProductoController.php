<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

use \App\Models\Producto as Producto;

class ProductoController implements IApiUsable
{

    public function CargarUno($request, $response, $args)
    {
        //Recibimos los parametros
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $stock = $parametros['stock'];
        $sector = $parametros['sector'];


        //Creamos el Producto
        $auxProducto = new Producto();
        $auxProducto->nombre = $nombre;
        $auxProducto->stock = $stock;
        $auxProducto->sector = $sector;

        //Guardamos en la base el Producto creado
        $auxProducto->save();

        $payload = json_encode(array("mensaje" => "Producto creado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        echo "entro a traer uno";
        // Buscamos Producto por nombre
        $auxProducto = $args['nombre_producto'];
        var_dump($auxProducto);

        // Buscamos por primary key
        // $Producto = Producto::find($usr);

        // Buscamos por attr Producto
        $Producto = Producto::where('Producto', $usr)->first();

        $payload = json_encode($Producto);

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Producto::all();
        $payload = json_encode(array("listaProducto" => $lista));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usrModificado = $parametros['Producto'];
        $ProductoId = $args['id'];

        // Conseguimos el objeto
        $usr = Producto::where('id', '=', $ProductoId)->first();

        // Si existe
        if ($usr !== null) {
            // Seteamos un nuevo Producto
            $usr->Producto = $usrModificado;
            // Guardamos en base de datos
            $usr->save();
            $payload = json_encode(array("mensaje" => "Producto modificado con exito"));
        } else {
            $payload = json_encode(array("mensaje" => "Producto no encontrado"));
        }

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $ProductoId = $args['id'];
        // Buscamos el Producto
        $Producto = Producto::find($ProductoId);
        // Borramos
        $Producto->delete();

        $payload = json_encode(array("mensaje" => "Producto borrado con exito"));

        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
