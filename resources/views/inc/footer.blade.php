            <footer>
                <div class="container">
                    <div class="content">
                        <ul>
                            <li>
                                <a uk-toggle="target: #md-feedback-add" type="button">
                                    <span uk-icon="icon:mail" title="Обратная связь"></span>
                                    <span>{{ __('Обратная связь') }}</span>
                                </a>
                            </li>
                        </ul>
                        
                    </div>
                    <div class="copyrithg">© 2023-2024 localhost.com</div>
                </div>
            </footer>

        </div>

        @vite(['resources/js/app.js'])
        @stack('scripts')

        @include('inc.modal.response')
        @include('inc.modal.feedback')
        @if(auth()->user() !== null) 
            @if(Route::is('work.*'))
                @include('inc.modal.work_add')
                @include('inc.modal.work_edit')    
            @endif
        @endif
        <!-- <a href="https://www.flaticon.com/free-icons/portfolio" title="portfolio icons">Portfolio icons created by Freepik - Flaticon</a> -->
    </body>
</html>