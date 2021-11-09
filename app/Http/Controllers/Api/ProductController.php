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
        //utilizei o response factory para criar colocar o response todo dentro de um Data;
        //$data = ["data"=>$this->product->all()];

        //paginar as colections para 5;
        $data = ["data"=>$this->product->paginate(5)];
        return response()->json($data);
    }

    public function show($id)
    {
        //busca o produto e armazena na variavel;
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

    //Pruduct $id = type, o ID recebe uma entrada do tipo objeto Product;
    public function delete(Product $id)
    {
        try {
            //vai retornar direto o produto do banco, com a pesquisa pelo ID, sem precisar referenciar o Product, pois ja eh do tipo Product;
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
