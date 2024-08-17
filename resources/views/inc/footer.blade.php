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
                        <br>© you-profile.online, 2023-2024
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

        <!-- Top.Mail.Ru counter -->
        <script type="text/javascript">
            var _tmr = window._tmr || (window._tmr = []);
            _tmr.push({id: "3546049", type: "pageView", start: (new Date()).getTime()});
            (function (d, w, id) {
            if (d.getElementById(id)) return;
            var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
            ts.src = "https://top-fwz1.mail.ru/js/code.js";
            var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
            if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
            })(document, window, "tmr-code");
        </script>
        <noscript><div><img src="https://top-fwz1.mail.ru/counter?id=3546049;js=na" style="position:absolute;left:-9999px;" alt="Top.Mail.Ru" /></div></noscript>
        <!-- /Top.Mail.Ru counter -->
    </body>
</html>