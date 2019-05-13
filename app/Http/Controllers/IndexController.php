<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Page;
use App\Service;
use App\Portfolio;
use App\People;

use DB;
use Mail;

class IndexController extends Controller
{
    public function execute(Request $request)
    {
        if ($request->isMethod('post')) {

            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению',
                'email' => 'Поле :attribute должно соответствовать email адресу',
            ];

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required',
            ], $messages);

            $data = $request->all();

            $result = Mail::send('site.email', ['data' => $data], function($message) use ($data) {

                $mail_admin = env('MAIL_ADMIN');

                $message->from($data['email'], $data['name']);
                $message->to($mail_admin, 'Mr. Admin')->subject('Question');

            });

            if ($result) {
                return redirect()->route('home')->with('status', 'Email is send');
            }

        }

        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']);
        $services = Service::where('id', '<', 20)->get();
        $peoples = People::take(3)->get();

        $tags = DB::table('portfolios')->distinct()->pluck('filter');

        $menu = [];

        foreach ($pages as $page) {
            $menu[] = ['title' => $page->name, 'alias' => $page->alias];
        }

        $menu[] = ['title' => 'Services',  'alias' => 'service'];
        $menu[] = ['title' => 'Protfolio', 'alias' => 'Portfolio'];
        $menu[] = ['title' => 'Team',      'alias' => 'team'];
        $menu[] = ['title' => 'Contact',   'alias' => 'contact'];

        $data = [
            'menu'       => $menu,
            'pages'      => $pages,
            'services'   => $services,
            'portfolios' => $portfolios,
            'peoples'    => $peoples,
            'tags'       => $tags,
        ];

        return view('site.index', $data);
    }
}
