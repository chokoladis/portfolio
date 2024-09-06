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
                    <div class="mt-5">
                        
                    </div>
                    <div class="copyrithg">
                        <br>© you-portfolio.online, 2023-2024
                    </div>
                </div>
            </footer>

        </div>

        @include('inc.modal.response')
        @include('inc.modal.feedback')
        @if(auth()->user() !== null) 
            @if(Route::is('work.*'))
                @include('inc.modal.work_add')
                @include('inc.modal.work_edit')    
            @endif
        @endif

        @vite(['resources/js/app.js'])
        @stack('scripts')
        <script defer src="https://www.google.com/recaptcha/api.js"></script>
    </body>
</html>