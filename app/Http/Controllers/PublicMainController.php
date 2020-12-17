<?php

namespace App\Http\Controllers;

use App\BlockStyledefinition;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class PublicMainController extends Controller
{
    public function index()
    {
        $blocks = [
            (object)[
                'id' => 1,
                'blocktype_id' => 1,
                'title' => 'Első hero címe',
                'content' => 'Első hero szövege',
                'button_label' => 'Nyomj meg',
                'button_url' => '#',
                'styledefinitions' => new BlockStyledefinition([
                    'background-color' => 'lightblue',
                    'color' => 'red',
                    'font-size' => '2rem'
                ]),
                'button_styledefinitions' => new BlockStyledefinition([
                    'background-color' => 'darkblue',
                    'color' => 'white',
                    'font-size' => '1.5rem',
                ])
            ],
            (object)[
                'id' => 2,
                'blocktype_id' => 1,
                'title' => 'Első hero címe',
                'content' => 'Első hero szövege',
                'button_label' => null,
                'button_url' => null,
                'styledefinitions' => new BlockStyledefinition([
                    'background-image' => 'url(\'images/x.jpg\')',
                    'color' => 'blue',
                    'font-size' => '1rem'
                ])
            ],
            (object)[
                'id' => 3,
                'blocktype_id' => 2,
                'title' => 'Első szövegblokk címe',
                'content' => 'Első szövegblokk szövege',
                'button_label' => 'Nyomj meg',
                'button_url' => '#',
                'styledefinitions' => new BlockStyledefinition([
                    'background-color' => 'black',
                    'color' => 'white',
                    'font-size' => '1rem'
                ]),
                'image_url' => 'images/x.jpg',
                'button_styledefinitions' => new BlockStyledefinition([
                    'background-color' => 'darkblue',
                    'color' => 'white',
                ])
            ],
            (object)[
                'id' => 4,
                'blocktype_id' => 5,
                'title' => 'Listás szövegblokk címe',
                'content' => 'Listás szövegblokk szövege',
                'button_label' => 'Nyomj meg',
                'button_url' => '#',
                'styledefinitions' => new BlockStyledefinition([
                    'background-color' => 'black',
                    'color' => 'white',
                    'font-size' => '1rem'
                ]),
                'items' => [
                    (object)[
                        'title' => 'Lista 1',
                        'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
                        'image_url' => 'images/2.jpg',
                    ],
                    (object)[
                        'title' => 'Lista 2',
                        'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
                        'image_url' => 'images/x.jpg',
                    ],
                    (object)[
                        'title' => 'Lista 3',
                        'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
                        'image_url' => 'images/2.jpg',
                    ],
                    (object)[
                        'title' => 'Lista 4',
                        'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
                        'image_url' => 'images/2.jpg',
                    ],
                ],
            ],
        ];
        return view('welcome', ['blocks' => $blocks]);
    }

    public function profile()
    {
        return view('members.profile');
    }

    public function verificationNotice()
    {
        return view('members.verification-notice');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return view('members.verification-complete');
    }

    public function sendVerificationLink()
    {
        \Auth::user()->sendEmailVerificationNotification();
        return view('members.verification-notice', ['verificationLinkSent' => true]);
    }
}
