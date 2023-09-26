            <footer>
                <div class="container">
                    <div class="content">
                        <ul class="socials">
                            <li><a href="https://github.com/chokoladis/" uk-icon="icon: github; ratio:2;"></a></li>
                        </ul>
                        <div class="by_created">Сайт разработан на свободное время какого то разработчика с ником <b>chokoladis</b></div>
                    </div>
                    <div class="copyrithg">© 2023 ******.com</div>
                </div>
            </footer>

        </div>

        @vite(['resources/js/app.js'])
        @stack('scripts')

        @include('inc.modal.response')
        @if (Route::current()->getName() == 'work.index')
            @include('inc.modal.work_create')
            @include('inc.modal.work_edit')            
        @endif        
        @if (Route::current()->getName() == 'workers.index')
            @include('inc.modal.worker_new')            
        @endif        
        <!-- <a href="https://www.flaticon.com/free-icons/portfolio" title="portfolio icons">Portfolio icons created by Freepik - Flaticon</a> -->
    </body>
</html>