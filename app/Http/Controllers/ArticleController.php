<?php

namespace App\Http\Controllers;
use App\WebUtils;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller {

    public function get_article() {
        if (!Request::has('id')) {
            return view('articles.layout', [
                'status' => 'error',
                'reason' => 'No ID supplied',
                'data' => null,
            ]);
        }
        if (!$this->article_exists(Request::get('id'))) {
            return view('articles.layout', [
                'status' => 'error',
                'reason' => 'No article exists by ID ' . Request::get('id'),
                'data' => null,
            ]);

        }

        return view('articles.layout', [
            'status' => 'success',
            'reason' => null,
            'data' => $this->fetch_article_data(Request::get('id'))
        ]);
    }

    private function article_exists($id) {
        /**
         * Eventually will need to implement this against a dataset. For now, since the dataset
         * isn't real, just return true.
         */
        return true;
    }

    private function fetch_article_data($id) {

        return [
            'title' =>  'Example Title',
            'abstract' => 'Example abstract',
            'isbn' => 32932932993293232,
            'description' => 'Example description',
            'source' => 'Example source',
            'cover_image' => asset('img/csun-icon.png'),
        ];
    }
}
