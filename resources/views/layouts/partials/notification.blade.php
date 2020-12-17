@if(session()->has('notificationMessage'))
    @if(session()->get('notificationMessage')['type'] == \App\Helpers\SessionMessage::TYPE_NOTIFICATION)
        <div id="notification"
             class="w-full z-50 fixed bottom-0 left-0 p-4 text-white bg-{{ session()->get('notificationMessage')['severity'] }} transition-opacity opacity-0 text-center">
            {{ session()->get('notificationMessage')['message'] }}
        </div>
        <script>
            document.getElementById('notification').classList.remove('opacity-0');
            document.getElementById('notification').classList.add('opacity-100');
            window.setTimeout(() => {
                document.getElementById('notification').classList.remove('opacity-100');
                document.getElementById('notification').classList.add('opacity-0');
                window.setTimeout(() => {
                    document.getElementById('notification').classList.add('h-0');
                    document.getElementById('notification').classList.add('max-h-0');
                }, 300);
            }, 5000)
        </script>
    @endif
    @if(session()->get('notificationMessage')['type'] == \App\Helpers\SessionMessage::TYPE_POPUP)
        <div id="notification-popup-overlay" class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-75 flex items-center justify-center z-10 opacity-0 transition-opacity">
            <div id="notification"
                 class="w-10/12 h-2/3 md:h-1/3 md:w-1/2 p-4 pt-16 bg-white flex flex-col items-center justify-between text-{{ session()->get('notificationMessage')['severity'] }} mb-4 shadow-xl rounded-lg">
                <div class="text-xl text-center">{{ session()->get('notificationMessage')['message'] }}</div>
                <button onclick="dismissPopup(event)" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Bezár</button>
            </div>
        </div>
        <script>
            document.getElementById('notification-popup-overlay').classList.remove('opacity-0');

            window.addEventListener('keyup', dismissOnEsc);
            function dismissOnEsc(event) {
                if (event.code == 'Escape') {
                    dismissPopup();
                }
            }
            function dismissPopup() {
                window.removeEventListener('keyup', dismissOnEsc);
                document.getElementById('notification-popup-overlay').classList.add('opacity-0');
                window.setTimeout(() => {
                    document.getElementById('notification-popup-overlay').remove();
                }, 300);
            }
        </script>
    @endif
    @php(session()->remove('notificationMessage'))
@endif

