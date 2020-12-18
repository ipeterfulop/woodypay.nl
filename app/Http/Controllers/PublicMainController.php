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
//            (object)[
//                'id' => 1,
//                'blocktype_id' => 1,
//                'title' => 'Első hero címe',
//                'content' => 'Első hero szövege',
//                'button_label' => 'Nyomj meg',
//                'button_url' => '#',
//                'styledefinitions' => new BlockStyledefinition([
//                    'background-color' => 'lightblue',
//                    'color' => 'red',
//                    'font-size' => '2rem'
//                ]),
//                'button_styledefinitions' => new BlockStyledefinition([
//                    'background-color' => 'darkblue',
//                    'color' => 'white',
//                    'font-size' => '1.5rem',
//                ])
//            ],
            (object)[
                'id' => 10,
                'blocktype_id' => 7,
                'slide_display_duration' => '2',
                'slide_pagination_duration' => '1',
                'styledefinitions' => new BlockStyledefinition([
                    'background-color' => 'black',
                    'color' => 'red',
                    'font-size' => '2rem'
                ]),
                'slides' => collect([
                    (object)[
                        'id' => 1,
                        'blocktype_id' => 1,
                        'title' => 'Első slidehero címe',
                        'content' => 'Első slidehero szövege',
                        'button_label' => 'Nyomj meg',
                        'button_url' => '#',
                        'styledefinitions' => new BlockStyledefinition([
                            'background-color' => 'black',
                            'color' => 'white',
                            'font-size' => '1rem'
                        ]),
                        'button_styledefinitions' => new BlockStyledefinition([
                            'background-color' => 'darkblue',
                            'color' => 'white',
                            'font-size' => '1.5rem',
                        ])
                    ],
                    (object)[
                        'id' => 1,
                        'blocktype_id' => 1,
                        'title' => 'Második slidehero címe',
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras mattis vehicula augue non volutpat. Sed nisi dolor, auctor vitae velit ut, rutrum ultrices leo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent sit amet quam feugiat, ultrices purus in, sagittis urna. Maecenas facilisis eget turpis at finibus. Nunc sagittis sodales libero vel ullamcorper. Donec erat sem, placerat vel mauris quis, posuere viverra augue. Etiam tempus nec nulla a tincidunt. Maecenas sollicitudin arcu tortor, id aliquam metus eleifend id. Etiam iaculis semper interdum. Maecenas eu urna id dui ultricies aliquet sit amet sed diam. Phasellus venenatis ut lacus sit amet lacinia. Suspendisse ex sapien, hendrerit eu purus vel, elementum sodales nisl. Fusce in odio nisl. Suspendisse vestibulum suscipit arcu at scelerisque. Donec id diam sed diam aliquet blandit.',
                        'button_label' => 'Nyomj meg',
                        'button_url' => '#',
                        'styledefinitions' => new BlockStyledefinition([
                            'background-color' => 'black',
                            'color' => 'red',
                            'font-size' => '2rem'
                        ]),
                        'button_styledefinitions' => new BlockStyledefinition([
                            'background-color' => 'darkblue',
                            'color' => 'white',
                            'font-size' => '1.5rem',
                        ])
                    ],
                ])
            ],
//            (object)[
//                'id' => 2,
//                'blocktype_id' => 1,
//                'title' => 'Első hero címe',
//                'content' => 'Első hero szövege',
//                'button_label' => null,
//                'button_url' => null,
//                'styledefinitions' => new BlockStyledefinition([
//                    'background-image' => 'url(\'images/x.jpg\')',
//                    'color' => 'blue',
//                    'font-size' => '1rem'
//                ])
//            ],
//            (object)[
//                'id' => 3,
//                'blocktype_id' => 2,
//                'title' => 'Első szövegblokk címe',
//                'content' => 'Első szövegblokk szövege',
//                'button_label' => 'Nyomj meg',
//                'button_url' => '#',
//                'styledefinitions' => new BlockStyledefinition([
//                    'background-color' => 'black',
//                    'color' => 'white',
//                    'font-size' => '1rem'
//                ]),
//                'image_url' => 'images/x.jpg',
//                'button_styledefinitions' => new BlockStyledefinition([
//                    'background-color' => 'darkblue',
//                    'color' => 'white',
//                ])
//            ],
//            (object)[
//                'id' => 4,
//                'blocktype_id' => 5,
//                'title' => 'Listás szövegblokk címe',
//                'content' => 'Listás szövegblokk szövege',
//                'button_label' => 'Nyomj meg',
//                'button_url' => '#',
//                'styledefinitions' => new BlockStyledefinition([
//                    'background-color' => 'black',
//                    'color' => 'white',
//                    'font-size' => '1rem'
//                ]),
//                'items' => [
//                    (object)[
//                        'title' => 'Lista 1',
//                        'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
//                        'image_url' => 'images/2.jpg',
//                    ],
//                    (object)[
//                        'title' => 'Lista 2',
//                        'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
//                        'image_url' => 'images/x.jpg',
//                    ],
//                    (object)[
//                        'title' => 'Lista 3',
//                        'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
//                        'image_url' => 'images/2.jpg',
//                    ],
//                    (object)[
//                        'title' => 'Lista 4',
//                        'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
//                        'image_url' => 'images/2.jpg',
//                    ],
//                ],
//            ],
//            (object)[
//                'id' => 5,
//                'blocktype_id' => 6,
//                'title' => 'Listás-tabos szövegblokk címe',
//                'content' => 'Listás-tabos szövegblokk szövege',
//                'styledefinitions' => new BlockStyledefinition([
//                    'background-color' => 'darkgreen',
//                    'color' => 'white',
//                    'font-size' => '1.5rem'
//                ]),
//                'tabs' => [
//                    (object)[
//                        'id' => 1,
//                        'title' => 'Első tab',
//                        'image_url' => 'images/x.jpg',
//                        'items' => [
//                            (object)[
//                                'title' => 'Lista 1',
//                                'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
//                                'image_url' => 'images/2.jpg',
//                            ],
//                            (object)[
//                                'title' => 'Lista 2',
//                                'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
//                                'image_url' => 'images/x.jpg',
//                            ],
//                        ],
//                    ],
//                    (object)[
//                        'id' => 2,
//                        'title' => 'Második tab',
//                        'image_url' => 'images/2.jpg',
//                        'items' => [
//                            (object)[
//                                'title' => 'Lista 3',
//                                'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
//                                'image_url' => 'images/2.jpg',
//                            ],
//                            (object)[
//                                'title' => 'Lista 4',
//                                'content' => 'To each element of the list and image is associated. When an element of the list is opened, the topic image associated to the  (title, content) pair is displayed.',
//                                'image_url' => 'images/2.jpg',
//                            ],
//                        ],
//                    ],
//                ],
//            ],
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
