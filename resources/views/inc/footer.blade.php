            <footer>
                <div class="container">
                    какой то текст в футере
                </div>
            </footer>

        </div>

        @include('inc.modal.response')
        @if (Route::current()->getName() == 'work.index')
            @include('inc.modal.work_create')
            @include('inc.modal.work_edit')            
        @endif        
        <!-- <a href="https://www.flaticon.com/free-icons/portfolio" title="portfolio icons">Portfolio icons created by Freepik - Flaticon</a> -->
    </body>
</html>