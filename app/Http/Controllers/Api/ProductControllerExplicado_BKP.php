<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Api\ApiError;

class ProductController extends Controller
{

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;        
    }

    public function index()
    {
        ////////////////////////////////////////////////////////////////////////////////////
        /*
        - Use este comando no terminal para poder abastecer o banco de teste (ajuste no /database/seeds/ProductTableSeeder): 
        "php artisan db:seed"

        - Outros comandos que tambem funcionam:
        
        return ["status"=>true];
        
        $produto = new Product();
        $produto = Product::all();
        return $produto;

        return Product::all();

        return $this->product->all();
        */
        ////////////////////////////////////////////////////////////////////////////////////

        //utilizei o response factory para criar colocar o response todo dentro de um Data;
        //$data = ["data"=>$this->product->all()];

        //paginar as colections para 5;
        $data = ["data"=>$this->product->paginate(5)];
        return response()->json($data);
    }

    //Modelo 1 de Show:
    //Pruduct $id = type, o ID recebe uma entrada do tipo objeto Product;
    /*
    public function show(Product $id)
    {
        //vai retornar direto o produto do banco, com a pesquisa pelo ID, sem precisar referenciar o Product, pois ja eh do tipo Product;
        //return $id;

        //faco a mesma coisa que fiz no index, e retorno tudo dentro do "data";
        $data = ["data"=>$id];
        return response()->json($data);    
    }
    */

    //Modelo 2 de Show:
    /*
    public function show($id)
    {
        $data = ["data"=> $this->product->find($id)];
        return response()->json($data);    
    }
    */
        
    //Modelo 3 de Show:
    public function show($id)
    {
        $product = $this->product->find($id);

        if(!$product)
        {
            return response()->json(["data"=> ["msg" => "Produto não encontrado!"]], 404 );
        }
        else
        {
            $data = ["data"=> $product];
            return response()->json($data);    
        }
    }
    

    public function store(Request $request)
    {
        try {
        
        //pode passar os dados com "active record" ou "mass assignment";
        $productData = $request->all();
        $this->product->create($productData);

        //retorno uma message json com o Status Code;
        $return = ["data"=>["msg"=>"Produto CADASTRADO com SUCESSO!"]];
        return response()->json($return, 201);
        
        } catch (\Exception $e) {
            if(config("app.debug"))
            {
                return response()->json(ApiError::errorMessage($e->getMessage(), 400));
            }
            return response()->json(ApiError::errorMessage("ERRO ao SALVAR o produto!", 400));
        }

    }

    public function update(Request $request, $id)
    {
        try {
        
        $productData = $request->all();
        $product     = $this->product->find($id);
        $product->update($productData);

        $return = ["data"=>["msg"=>"Produto ATUALIZADO com SUCESSO!"]];
        return response()->json($return, 201);
        
        } catch (\Exception $e) {
            if(config("app.debug"))
            {
                return response()->json(ApiError::errorMessage($e->getMessage(), 400));
            }
            return response()->json(ApiError::errorMessage("ERRO ao realizar ao ATUALIZAR produto!", 400));
        }

    }

    public function delete(Product $id)
    {
        try {
            $id->delete();
            return response()->json(["data"=>["msg"=>"Produto: '" . $id->name . "' REMOVIDO com SUCESSO!"]], 201);
        }

        catch (\Exception $e) {
            if(config("app.debug"))
            {
                return response()->json(ApiError::errorMessage($e->getMessage(), 400));
            }
            return response()->json(ApiError::errorMessage("ERRO ao realizar ao REMOVER produto!", 400));
        }
    }

}
