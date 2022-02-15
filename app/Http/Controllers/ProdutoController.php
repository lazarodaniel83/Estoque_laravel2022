<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use app\Produto;
use Request;

class ProdutoController extends Controller
{
    public function lista(){
       
        $produtos = Produto::all();
        
        return view('produtos.listagem')->with('produtos',$produtos);
    }

    public function mostra($id){
        
        $resposta = DB::select('select * from produtos where id = ?',[$id]);

        if(empty($resposta)){
            return "Esse produto não existe";
        }
        return view('produto.detalhes')->with('p',$resposta[0]);
    }

   public function novo(){
       return view('produto.formulario');
   }

   public function adiciona(){
       $nome = Request::input('nome');
       $valor = Request::input('valor');
       $descricao = Request::input('descricao');
       $quantidade = Request::input('quantidade');        

       DB::insert('insert into produtos
        (nome, valor, descricao, quantidade) values (?,?,?,?)',
         array($nome,$valor,$descricao,$quantidade));

        DB::table('produtos')->insert(['nome'=>$nome,
                    'valor' => $valor,'descricao'=> $descricao,
                    'quantidade' => $quantidade]);

       return redirect()
       ->action('ProdutoController@lista')
       ->withInput(Request::only('nome'));
   }

   public function listaJson(){
       $produtos = Produto::all('select *from produtos');
       
       return response()->json($produtos);
   }
}


