<?php

namespace App\Http\Controllers;

use e\Http\Request\ProdutoRequest;
use Illuminate\Support\Facades\DB ;
use App\Produto;
use Request;

class ProdutoController extends Controller
{
    public function lista(){
       
        $produtos = Produto::all();
        
        return view('produto.listagem')->with('produtos',$produtos);
    }

    public function mostra($id){
        
        // $resposta = DB::select('select * from produtos where id = ?',[$id]);

        // if(empty($resposta)){
        //     return "Esse produto não existe";
        // }
        // return view('produto.detalhes')->with('p',$resposta[0]);

        $produto = Produto::find($id);

        if(empty($produto)){
            return "Esse produto não existe";
        }
        return view('produto.detalhes')->with('p',$produto);
    }

   public function novo(){
       return view('produto.formulario');
   }

   public function adiciona(){
        //    $nome = Request::input('nome');
        //    $valor = Request::input('valor');
        //    $descricao = Request::input('descricao');
        //    $quantidade = Request::input('quantidade');        

        //    DB::insert('insert into produtos
        //     (nome, valor, descricao, quantidade) values (?,?,?,?)',
        //      array($nome,$valor,$descricao,$quantidade));

        //     DB::table('produtos')->insert(['nome'=>$nome,
        //                 'valor' => $valor,'descricao'=> $descricao,
        //                 'quantidade' => $quantidade]);

        // $produto = new Produto();
        // $produto->nome = Request::input('nome');
        // $produto->valor = Request::input('valor');
        // $produto->descricao = Request::input('descricao');
        // $produto->quantidade = Request::input('quantidade');        

        // $params = Request::all();
        // $produto = new Produto($params);
        // $produto->save();

        Produto::create(Request::all);

        return redirect()
        ->action('ProdutoController@lista')
        ->withInput(Request::only('nome'));
   }

   public function listaJson(){
       $produtos = Produto::all();
       
       return response()->json($produtos);
   }
   public function remove($id){
       $produto = Produto::find($id);
    //    dd($produto);
       $produto->delete();

       return redirect()->action('ProdutoController@lista');
   }
}


