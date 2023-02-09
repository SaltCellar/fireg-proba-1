<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pdfController extends Controller {

    function board($id) : \Symfony\Component\HttpFoundation\BinaryFileResponse {

        $posts = \App\Helpers\Wrapper::wrap(\App\Models\board_post::class,[
            [ 'eq', 'board', ( $id ? : 0 ) ]
        ],0,100);

        $data = [
            'posts' => $posts['results'] ?? [],
        ];

        $fileName = "board-" . $id . ".pdf";
        $filePath = '../storage/app/public/pdf/'.$fileName;

        //return response()->view('pdf-board',$data);

        $PDF = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf-board',$data)
            ->setPaper('a4', 'landscape');
        $PDF->save($filePath);

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$fileName.'"'
        ]);

    }

}
