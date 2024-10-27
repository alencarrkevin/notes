<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;

use Illuminate\Http\Request;


class MainController extends Controller
{
    public function index()
    {
        //load user's notes
        $id = session('user.id');
        $user = User::find($id)->toArray();
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        //show home view

        return view('home', ['notes' => $notes]);


    }

    public function newNote()
    {
      //show new note view

      return view('new_note');
    }

    //dados do formulario estão entrando aqui

    public function newNoteSubmit(request $request)
    {
        //validade request
        $request->validate(
            [
                        'text_title' => 'required |  min:3|max:200',
                        'text_note' => 'required| min:3|max:3000'
            ],
            //messages
            [
                'text_title.required' => 'O titulo é obrigatorio',

                'text_note.required' => 'a nota é obrigatoria',
                'text_note.min' => 'a nota deve ter no minimo :min caracteres',
                'text_note.max' => 'a nota deve ter no maximo :max caracteres',

                'text_title.min' => 'o titulo deve ter no minimo :min caracteres',
                'text_title.max' => 'o titulo deve ter no maximo :max caracteres'
            ]
        );

        echo "ok";
        //get user id
        $id = session ('user.id');

        //create new note
        $note = new Note();
        $note->user_id = $id; //coluina user_id tera as info de baixo
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save(); //salva no banco de dados

        //redirect to home
        return redirect()->route('home');
    }

    public function editNote($id)
    {


      

      //  $id = $this->decryptId($id);
      $id = Operations::decryptId($id);
      if($id === null){
        return redirect()->route('home');
    }
        //load note
        $note = Note::find($id);

        //show edit note view
        return view ('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(request $request)
    {
        //validade request
        $request->validate(
            [
                        'text_title' => 'required |  min:3|max:200',
                        'text_note' => 'required| min:3|max:3000'
            ],
            //messages
            [
                'text_title.required' => 'O titulo é obrigatorio',

                'text_note.required' => 'a nota é obrigatoria',
                'text_note.min' => 'a nota deve ter no minimo :min caracteres',
                'text_note.max' => 'a nota deve ter no maximo :max caracteres',

                'text_title.min' => 'o titulo deve ter no minimo :min caracteres',
                'text_title.max' => 'o titulo deve ter no maximo :max caracteres'
            ]
        );
        //check if note_id exists
        if($request->note_id  == null){
            return redirect()->route('home');
        }
        //decript note id
        $id = Operations::decryptId($request->note_id);
        if($id === null){
            return redirect()->route('home');
        }
        //load note
        $note = Note::find($id);
        //update note
        $note->title = $request->text_title;
        $note->text =  $request->text_note;
        $note->save(); //salva no banco de dados
        //redirect
        return redirect()->route('home');

    }

    public function deleteNote($id)
    {

      $id = Operations::decryptId($id);
      if($id === null){
        return redirect()->route('home');
    }

      //load note
      $note = Note::find($id);

      //SHOW DELETE NOTE CONFIRMATION
      return view ('delete_note', ['note' => $note]);

    }

    public function deleteNoteConfirm($id)
    {
        //check if id is encrypted
        $id = Operations::decryptId($id);
        if($id === null){
            return redirect()->route('home');
        }
        //load note
        $note = Note::find($id);
        //1 hard delete
        //  $note->delete();
        //2 softdelete
       /*  $note->deleted_at = date('Y-m-d H:i:s');
        $note->save(); */

        //3 soft delete (propiedade na model)
        $note->delete();

        //redirect to home

        return redirect()->route('home');
    }

}



