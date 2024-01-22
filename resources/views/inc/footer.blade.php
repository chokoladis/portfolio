            <footer>
                <div class="container">
                    <div class="content">
                        <ul class="socials">
                            <li><a href="https://github.com/chokoladis/" uk-icon="icon: github; ratio:2;"></a></li>
                        </ul>
                        <i>Сайт разработан на свободное время какого то разработчика с ником <b>chokoladis</b></i>
                    </div>
                    <div class="copyrithg">© 2023 localhost.com</div>
                </div>
            </footer>

        </div>

        @vite(['resources/js/app.js'])
        @stack('scripts')

        @include('inc.modal.response')
        @if(auth()->user() !== null) 
            @if(Route::is('work.*'))
                @include('inc.modal.work_create')
                @include('inc.modal.work_edit')
            @elseif (Route::is('workers.*'))
                @include('inc.modal.worker_new')
            @elseif (Route::is('profile.*'))
                @include('inc.modal.worker_edit')
            @endif
        @endif
        <!-- <a href="https://www.flaticon.com/free-icons/portfolio" title="portfolio icons">Portfolio icons created by Freepik - Flaticon</a> -->
    </body>
</html>